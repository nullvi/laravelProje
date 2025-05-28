<?php

namespace Tests\Feature;

use App\Models\Hotel;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReservationTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $user;
    protected $hotel;
    protected $room;
    protected $manager;

    /**
     * Setup test environment
     */
    public function setUp(): void
    {
        parent::setUp();

        // Create users and data needed for tests
        $this->manager = User::factory()->create([
            'role' => 'hotel_manager',
            'is_approved' => true,
        ]);

        $this->user = User::factory()->create([
            'role' => 'customer',
        ]);

        $this->hotel = Hotel::factory()->create([
            'manager_id' => $this->manager->id,
            'is_active' => true
        ]);

        $this->room = Room::factory()->create([
            'hotel_id' => $this->hotel->id,
            'is_active' => true,
            'price_per_night' => 100,
            'capacity' => 2
        ]);
    }

    /**
     * Test user can view their bookings
     */
    public function test_user_can_view_their_bookings()
    {
        $this->actingAs($this->user);

        // Create some reservations for the user
        Reservation::factory(3)->create([
            'user_id' => $this->user->id,
            'room_id' => $this->room->id
        ]);

        $response = $this->get(route('bookings'));

        $response->assertStatus(200);
        $response->assertViewIs('customer.bookings.index');
        $response->assertViewHas('reservations');
    }

    /**
     * Test user can view booking details
     */
    public function test_user_can_view_booking_details()
    {
        $this->actingAs($this->user);

        $reservation = Reservation::factory()->create([
            'user_id' => $this->user->id,
            'room_id' => $this->room->id
        ]);

        $response = $this->get(route('bookings.show', $reservation));

        $response->assertStatus(200);
        $response->assertViewIs('customer.bookings.show');
        $response->assertViewHas('reservation');
    }

    /**
     * Test user cannot view other user's booking
     */
    public function test_user_cannot_view_other_users_booking()
    {
        $otherUser = User::factory()->create([
            'role' => 'customer'
        ]);

        $this->actingAs($otherUser);

        $reservation = Reservation::factory()->create([
            'user_id' => $this->user->id,
            'room_id' => $this->room->id
        ]);

        $response = $this->get(route('bookings.show', $reservation));

        $response->assertStatus(403); // Should return forbidden
    }

    /**
     * Test user can create a reservation
     */
    public function test_user_can_create_reservation()
    {
        $this->actingAs($this->user);

        $checkIn = Carbon::now()->addDays(5)->format('Y-m-d');
        $checkOut = Carbon::now()->addDays(7)->format('Y-m-d');

        $response = $this->get(route('reservations.create', $this->room));
        $response->assertStatus(200);

        $response = $this->post(route('reservations.store', $this->room), [
            'check_in_date' => $checkIn,
            'check_out_date' => $checkOut,
            'guests_count' => 2,
            'special_requests' => 'Need extra pillows'
        ]);

        $response->assertRedirect(route('payment.show', 1));
        $this->assertDatabaseHas('reservations', [
            'user_id' => $this->user->id,
            'room_id' => $this->room->id,
            'status' => 'pending',
            'payment_status' => 'pending',
            'guests_count' => 2,
            'special_requests' => 'Need extra pillows'
        ]);
    }

    /**
     * Test user can view payment page
     */
    public function test_user_can_view_payment_page()
    {
        $this->actingAs($this->user);

        $reservation = Reservation::factory()->create([
            'user_id' => $this->user->id,
            'room_id' => $this->room->id,
            'status' => 'pending',
            'payment_status' => 'pending'
        ]);

        $response = $this->get(route('payment.show', $reservation));

        $response->assertStatus(200);
        $response->assertViewIs('customer.bookings.payment');
    }

    /**
     * Test user can process payment
     */
    public function test_user_can_process_payment()
    {
        $this->actingAs($this->user);

        $reservation = Reservation::factory()->create([
            'user_id' => $this->user->id,
            'room_id' => $this->room->id,
            'status' => 'pending',
            'payment_status' => 'pending'
        ]);

        $response = $this->post(route('payment.process', $reservation), [
            'payment_method' => 'credit_card',
            'card_number' => '4242424242424242',
            'card_holder' => 'John Doe',
            'card_expiry' => '12/25',
            'card_cvv' => '123'
        ]);

        $response->assertRedirect(route('bookings.show', $reservation));
        $this->assertDatabaseHas('reservations', [
            'id' => $reservation->id,
            'status' => 'confirmed',
            'payment_status' => 'completed',
            'payment_method' => 'credit_card'
        ]);
    }

    /**
     * Test user can cancel reservation
     */
    public function test_user_can_cancel_reservation()
    {
        $this->actingAs($this->user);

        // Create a reservation with check-in date more than 24 hours from now
        $reservation = Reservation::factory()->create([
            'user_id' => $this->user->id,
            'room_id' => $this->room->id,
            'status' => 'confirmed',
            'check_in_date' => Carbon::now()->addDays(5)
        ]);

        $response = $this->delete(route('bookings.cancel', $reservation));

        $response->assertRedirect(route('bookings'));
        $this->assertDatabaseHas('reservations', [
            'id' => $reservation->id,
            'status' => 'cancelled'
        ]);
    }

    /**
     * Test user cannot cancel reservation within 24 hours of check-in
     */
    public function test_user_cannot_cancel_reservation_within_24_hours()
    {
        $this->actingAs($this->user);

        // Create a reservation with check-in date less than 24 hours from now
        $reservation = Reservation::factory()->create([
            'user_id' => $this->user->id,
            'room_id' => $this->room->id,
            'status' => 'confirmed',
            'check_in_date' => Carbon::now()->addHours(12)
        ]);

        $response = $this->delete(route('bookings.cancel', $reservation));

        $response->assertRedirect(); // Should redirect back
        $this->assertDatabaseHas('reservations', [
            'id' => $reservation->id,
            'status' => 'confirmed' // Status should not change
        ]);
    }
}
