<?php

namespace Tests\Feature;

use App\Models\Hotel;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserRoleTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $admin;
    protected $manager;
    protected $unapprovedManager;
    protected $customer;

    /**
     * Setup test environment
     */
    public function setUp(): void
    {
        parent::setUp();

        // Create test users with different roles
        $this->admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $this->manager = User::factory()->create([
            'role' => 'hotel_manager',
            'is_approved' => true,
        ]);

        $this->unapprovedManager = User::factory()->create([
            'role' => 'hotel_manager',
            'is_approved' => false,
        ]);

        $this->customer = User::factory()->create([
            'role' => 'customer',
        ]);
    }

    /**
     * Test only admins can access admin dashboard
     */
    public function test_only_admin_can_access_admin_dashboard()
    {
        // Admin should be able to access
        $this->actingAs($this->admin);
        $response = $this->get(route('admin.dashboard'));
        $response->assertStatus(200);

        // Hotel manager should not be able to access
        $this->actingAs($this->manager);
        $response = $this->get(route('admin.dashboard'));
        $response->assertStatus(403);

        // Customer should not be able to access
        $this->actingAs($this->customer);
        $response = $this->get(route('admin.dashboard'));
        $response->assertStatus(403);
    }

    /**
     * Test only hotel managers can access manager dashboard
     */
    public function test_only_hotel_manager_can_access_manager_dashboard()
    {
        // Approved hotel manager should be able to access
        $this->actingAs($this->manager);
        $response = $this->get(route('manager.dashboard'));
        $response->assertStatus(200);

        // Unapproved hotel manager should not be able to access
        $this->actingAs($this->unapprovedManager);
        $response = $this->get(route('manager.dashboard'));
        $response->assertStatus(403);

        // Admin should not be able to access
        $this->actingAs($this->admin);
        $response = $this->get(route('manager.dashboard'));
        $response->assertStatus(403);

        // Customer should not be able to access
        $this->actingAs($this->customer);
        $response = $this->get(route('manager.dashboard'));
        $response->assertStatus(403);
    }

    /**
     * Test only admin can manage hotel managers
     */
    public function test_only_admin_can_manage_hotel_managers()
    {
        // Admin should be able to access
        $this->actingAs($this->admin);
        $response = $this->get(route('admin.hotel-managers.index'));
        $response->assertStatus(200);

        // Hotel manager should not be able to access
        $this->actingAs($this->manager);
        $response = $this->get(route('admin.hotel-managers.index'));
        $response->assertStatus(403);
    }

    /**
     * Test admin can approve hotel managers
     */
    public function test_admin_can_approve_hotel_managers()
    {
        $this->actingAs($this->admin);

        $response = $this->patch(route('admin.hotel-managers.approve', $this->unapprovedManager));

        $response->assertRedirect();
        $this->assertDatabaseHas('users', [
            'id' => $this->unapprovedManager->id,
            'is_approved' => true,
        ]);
    }

    /**
     * Test customer cannot access manager routes
     */
    public function test_customer_cannot_access_manager_routes()
    {
        $this->actingAs($this->customer);

        $hotel = Hotel::factory()->create([
            'manager_id' => $this->manager->id,
        ]);

        $response = $this->get(route('manager.hotels.edit', $hotel));
        $response->assertStatus(403);

        $response = $this->get(route('manager.hotels.create'));
        $response->assertStatus(403);
    }

    /**
     * Test hotel manager cannot manage other manager's hotels
     */
    public function test_hotel_manager_cannot_manage_other_managers_hotels()
    {
        $this->actingAs($this->manager);

        $otherManager = User::factory()->create([
            'role' => 'hotel_manager',
            'is_approved' => true,
        ]);

        $otherHotel = Hotel::factory()->create([
            'manager_id' => $otherManager->id,
        ]);

        $response = $this->get(route('manager.hotels.edit', $otherHotel));
        $response->assertStatus(403);

        $response = $this->put(route('manager.hotels.update', $otherHotel), [
            'name' => 'Updated Hotel Name',
            'description' => 'Updated description',
            'location' => 'Updated location',
            'address' => 'Updated address',
            'rating' => 4.5,
            'is_active' => true,
        ]);

        $response->assertStatus(403);
    }

    /**
     * Test customer can only see and cancel their own reservations
     */
    public function test_customer_can_only_manage_own_reservations()
    {
        $this->actingAs($this->customer);

        $hotel = Hotel::factory()->create([
            'manager_id' => $this->manager->id,
        ]);

        $room = Room::factory()->create([
            'hotel_id' => $hotel->id,
        ]);

        $ownReservation = Reservation::factory()->create([
            'user_id' => $this->customer->id,
            'room_id' => $room->id,
            'status' => 'confirmed',
        ]);

        $otherCustomer = User::factory()->create([
            'role' => 'customer',
        ]);

        $otherReservation = Reservation::factory()->create([
            'user_id' => $otherCustomer->id,
            'room_id' => $room->id,
            'status' => 'confirmed',
        ]);

        // Can view own reservation
        $response = $this->get(route('bookings.show', $ownReservation));
        $response->assertStatus(200);

        // Cannot view other's reservation
        $response = $this->get(route('bookings.show', $otherReservation));
        $response->assertStatus(403);

        // Can cancel own reservation
        $response = $this->delete(route('bookings.cancel', $ownReservation));
        $response->assertRedirect();

        // Cannot cancel other's reservation
        $response = $this->delete(route('bookings.cancel', $otherReservation));
        $response->assertStatus(403);
    }

    /**
     * Test middleware redirects for unauthenticated users
     */
    public function test_middleware_redirects_for_unauthenticated_users()
    {
        // Customer route redirects to login
        $response = $this->get(route('bookings'));
        $response->assertRedirect(route('login'));

        // Manager route redirects to login
        $response = $this->get(route('manager.dashboard'));
        $response->assertRedirect(route('login'));

        // Admin route redirects to login
        $response = $this->get(route('admin.dashboard'));
        $response->assertRedirect(route('login'));
    }

    /**
     * Test registration routes are accessible to guests
     */
    public function test_registration_routes_accessible_to_guests()
    {
        // Regular user registration
        $response = $this->get(route('register'));
        $response->assertStatus(200);

        // Hotel manager registration
        $response = $this->get(route('register.hotel-manager'));
        $response->assertStatus(200);
    }
}
