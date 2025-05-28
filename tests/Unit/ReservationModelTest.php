<?php

namespace Tests\Unit;

use App\Models\Hotel;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReservationModelTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $hotel;
    protected $room;
    protected $reservation;

    /**
     * Setup test environment
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create(['role' => 'customer']);
        $manager = User::factory()->create(['role' => 'hotel_manager', 'is_approved' => true]);

        $this->hotel = Hotel::factory()->create([
            'manager_id' => $manager->id,
            'is_active' => true
        ]);

        $this->room = Room::factory()->create([
            'hotel_id' => $this->hotel->id,
            'is_active' => true,
            'price_per_night' => 100,
            'capacity' => 2
        ]);

        $this->reservation = Reservation::factory()->create([
            'user_id' => $this->user->id,
            'room_id' => $this->room->id,
            'check_in_date' => Carbon::now()->addDays(5),
            'check_out_date' => Carbon::now()->addDays(8),
            'total_price' => 300,
            'status' => 'confirmed',
            'payment_status' => 'completed'
        ]);
    }

    /**
     * Test reservation belongs to user
     */
    public function test_reservation_belongs_to_user()
    {
        $this->assertInstanceOf(User::class, $this->reservation->user);
        $this->assertEquals($this->user->id, $this->reservation->user->id);
    }

    /**
     * Test reservation belongs to room
     */
    public function test_reservation_belongs_to_room()
    {
        $this->assertInstanceOf(Room::class, $this->reservation->room);
        $this->assertEquals($this->room->id, $this->reservation->room->id);
    }

    /**
     * Test reservation has total nights calculated correctly
     */
    public function test_reservation_has_correct_total_nights()
    {
        $this->assertEquals(3, $this->reservation->total_nights);
    }

    /**
     * Test reservation has proper status for payment
     */
    public function test_reservation_payment_status_methods()
    {
        $this->assertTrue($this->reservation->isPaid());

        $pendingReservation = Reservation::factory()->create([
            'user_id' => $this->user->id,
            'room_id' => $this->room->id,
            'payment_status' => 'pending'
        ]);

        $this->assertFalse($pendingReservation->isPaid());
    }

    /**
     * Test reservation status methods
     */
    public function test_reservation_status_methods()
    {
        $confirmedReservation = $this->reservation; // Already confirmed
        $this->assertTrue($confirmedReservation->isConfirmed());
        $this->assertFalse($confirmedReservation->isPending());

        $pendingReservation = Reservation::factory()->create([
            'user_id' => $this->user->id,
            'room_id' => $this->room->id,
            'status' => 'pending'
        ]);

        $this->assertTrue($pendingReservation->isPending());
        $this->assertFalse($pendingReservation->isConfirmed());

        $cancelledReservation = Reservation::factory()->create([
            'user_id' => $this->user->id,
            'room_id' => $this->room->id,
            'status' => 'cancelled'
        ]);

        $this->assertTrue($cancelledReservation->isCancelled());
    }

    /**
     * Test reservation checks for cancellation period
     */
    public function test_reservation_cancellation_period()
    {
        // Reservation with check_in_date more than 24 hours away
        $cancellableReservation = Reservation::factory()->create([
            'user_id' => $this->user->id,
            'room_id' => $this->room->id,
            'check_in_date' => Carbon::now()->addDays(2),
            'status' => 'confirmed'
        ]);

        $this->assertTrue($cancellableReservation->canBeCancelled());

        // Reservation with check_in_date less than 24 hours away
        $nonCancellableReservation = Reservation::factory()->create([
            'user_id' => $this->user->id,
            'room_id' => $this->room->id,
            'check_in_date' => Carbon::now()->addHours(12),
            'status' => 'confirmed'
        ]);

        $this->assertFalse($nonCancellableReservation->canBeCancelled());

        // Cancelled reservations cannot be cancelled again
        $cancelledReservation = Reservation::factory()->create([
            'user_id' => $this->user->id,
            'room_id' => $this->room->id,
            'check_in_date' => Carbon::now()->addDays(5),
            'status' => 'cancelled'
        ]);

        $this->assertFalse($cancelledReservation->canBeCancelled());
    }

    /**
     * Test reservation date formatting
     */
    public function test_reservation_date_formatting()
    {
        $expectedCheckInFormat = Carbon::parse($this->reservation->check_in_date)->format('Y-m-d');
        $expectedCheckOutFormat = Carbon::parse($this->reservation->check_out_date)->format('Y-m-d');

        $this->assertEquals($expectedCheckInFormat, $this->reservation->formatted_check_in_date);
        $this->assertEquals($expectedCheckOutFormat, $this->reservation->formatted_check_out_date);
    }
}
