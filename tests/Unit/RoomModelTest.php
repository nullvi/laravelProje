<?php

namespace Tests\Unit;

use App\Models\Hotel;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoomModelTest extends TestCase
{
    use RefreshDatabase;

    protected $manager;
    protected $hotel;
    protected $room;

    /**
     * Setup test environment
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->manager = User::factory()->create([
            'role' => 'hotel_manager',
            'is_approved' => true
        ]);

        $this->hotel = Hotel::factory()->create([
            'manager_id' => $this->manager->id,
            'is_active' => true
        ]);

        $this->room = Room::factory()->create([
            'hotel_id' => $this->hotel->id,
            'is_active' => true,
            'price_per_night' => 100,
            'capacity' => 2,
            'beds' => '1 King',
            'amenities' => 'WiFi, TV, Air Conditioning'
        ]);
    }

    /**
     * Test room belongs to hotel
     */
    public function test_room_belongs_to_hotel()
    {
        $this->assertInstanceOf(Hotel::class, $this->room->hotel);
        $this->assertEquals($this->hotel->id, $this->room->hotel->id);
    }

    /**
     * Test room has many reservations
     */
    public function test_room_has_many_reservations()
    {
        $user = User::factory()->create(['role' => 'customer']);

        // Create multiple reservations for the room
        $reservations = Reservation::factory(3)->create([
            'room_id' => $this->room->id,
            'user_id' => $user->id
        ]);

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->room->reservations);
        $this->assertCount(3, $this->room->reservations);
    }

    /**
     * Test room availability between dates
     */
    public function test_room_availability_between_dates()
    {
        $user = User::factory()->create(['role' => 'customer']);

        // Create a reservation for the next week
        $checkIn = Carbon::now()->addDays(7);
        $checkOut = Carbon::now()->addDays(10);

        Reservation::factory()->create([
            'room_id' => $this->room->id,
            'user_id' => $user->id,
            'check_in_date' => $checkIn,
            'check_out_date' => $checkOut,
            'status' => 'confirmed'
        ]);

        // Room should be available before the reservation
        $this->assertTrue($this->room->isAvailableBetween(
            Carbon::now()->addDays(1),
            Carbon::now()->addDays(5)
        ));

        // Room should be available after the reservation
        $this->assertTrue($this->room->isAvailableBetween(
            Carbon::now()->addDays(11),
            Carbon::now()->addDays(15)
        ));

        // Room should not be available during the reservation
        $this->assertFalse($this->room->isAvailableBetween(
            Carbon::now()->addDays(8),
            Carbon::now()->addDays(12)
        ));

        // Room should not be available when reservation overlaps
        $this->assertFalse($this->room->isAvailableBetween(
            Carbon::now()->addDays(5),
            Carbon::now()->addDays(8)
        ));
    }

    /**
     * Test room availability ignores cancelled reservations
     */
    public function test_room_availability_ignores_cancelled_reservations()
    {
        $user = User::factory()->create(['role' => 'customer']);

        // Create a cancelled reservation
        $checkIn = Carbon::now()->addDays(3);
        $checkOut = Carbon::now()->addDays(6);

        Reservation::factory()->create([
            'room_id' => $this->room->id,
            'user_id' => $user->id,
            'check_in_date' => $checkIn,
            'check_out_date' => $checkOut,
            'status' => 'cancelled'
        ]);

        // Room should be available even during the cancelled reservation
        $this->assertTrue($this->room->isAvailableBetween(
            Carbon::now()->addDays(3),
            Carbon::now()->addDays(6)
        ));
    }

    /**
     * Test room availability only considers confirmed and pending reservations
     */
    public function test_room_availability_considers_relevant_statuses()
    {
        $user = User::factory()->create(['role' => 'customer']);

        // Create a pending reservation
        $checkIn = Carbon::now()->addDays(20);
        $checkOut = Carbon::now()->addDays(25);

        Reservation::factory()->create([
            'room_id' => $this->room->id,
            'user_id' => $user->id,
            'check_in_date' => $checkIn,
            'check_out_date' => $checkOut,
            'status' => 'pending'
        ]);

        // Room should not be available during the pending reservation
        $this->assertFalse($this->room->isAvailableBetween(
            Carbon::now()->addDays(21),
            Carbon::now()->addDays(23)
        ));
    }

    /**
     * Test formatted price
     */
    public function test_formatted_price()
    {
        $expectedFormat = '$' . number_format($this->room->price_per_night, 2);
        $this->assertEquals($expectedFormat, $this->room->formatted_price);
    }

    /**
     * Test inactive room is not available
     */
    public function test_inactive_room_is_not_available()
    {
        // Make the room inactive
        $this->room->update(['is_active' => false]);

        // Room should not be available even if there are no reservations
        $this->assertFalse($this->room->isAvailableBetween(
            Carbon::now()->addDays(1),
            Carbon::now()->addDays(5)
        ));
    }

    /**
     * Test getting available dates
     */
    public function test_getting_available_dates()
    {
        $user = User::factory()->create(['role' => 'customer']);

        // Create a reservation
        $checkIn = Carbon::now()->addDays(5);
        $checkOut = Carbon::now()->addDays(8);

        Reservation::factory()->create([
            'room_id' => $this->room->id,
            'user_id' => $user->id,
            'check_in_date' => $checkIn,
            'check_out_date' => $checkOut,
            'status' => 'confirmed'
        ]);

        // Get available dates for the next 30 days
        $availableDates = $this->room->getAvailableDatesForMonth(Carbon::now(), 30);

        // There should be dates available
        $this->assertNotEmpty($availableDates);

        // The reserved dates should not be in the available dates
        foreach (range(5, 7) as $day) {
            $reservedDate = Carbon::now()->addDays($day)->format('Y-m-d');
            $this->assertNotContains($reservedDate, $availableDates);
        }
    }
}
