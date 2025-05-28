<?php

namespace Tests\Feature;

use App\Models\Hotel;
use App\Models\Room;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class RoomTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $admin;
    protected $manager;
    protected $customer;
    protected $hotel;
    protected $room;

    /**
     * Setup test environment
     */
    public function setUp(): void
    {
        parent::setUp();

        // Create test users
        $this->admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $this->manager = User::factory()->create([
            'role' => 'hotel_manager',
            'is_approved' => true,
        ]);

        $this->customer = User::factory()->create([
            'role' => 'customer',
        ]);

        // Create test hotel and room
        $this->hotel = Hotel::factory()->create([
            'manager_id' => $this->manager->id,
            'is_active' => true,
        ]);

        $this->room = Room::factory()->create([
            'hotel_id' => $this->hotel->id,
            'is_active' => true,
            'price_per_night' => 100,
            'capacity' => 2,
        ]);

        // Configure fake filesystem
        Storage::fake('public');
    }

    /**
     * Test public room listing page
     */
    public function test_guest_can_view_rooms_listing()
    {
        $response = $this->get(route('rooms.index', $this->hotel));

        $response->assertStatus(200);
        $response->assertViewIs('rooms.index');
        $response->assertViewHas('rooms');
        $response->assertViewHas('hotel');
    }

    /**
     * Test public room detail page
     */
    public function test_guest_can_view_room_details()
    {
        $response = $this->get(route('rooms.show', [
            'hotel' => $this->hotel,
            'room' => $this->room
        ]));

        $response->assertStatus(200);
        $response->assertViewIs('rooms.show');
        $response->assertViewHas('room');
        $response->assertSee($this->room->name);
    }

    /**
     * Test hotel manager can view room create form
     */
    public function test_hotel_manager_can_view_room_create_form()
    {
        $this->actingAs($this->manager);

        $response = $this->get(route('manager.hotels.rooms.create', $this->hotel));

        $response->assertStatus(200);
        $response->assertViewIs('manager.rooms.create');
    }

    /**
     * Test hotel manager can create a room
     */
    public function test_hotel_manager_can_create_room()
    {
        $this->actingAs($this->manager);

        $imageFile = UploadedFile::fake()->image('room.jpg');

        $roomData = [
            'name' => 'Deluxe Room',
            'description' => 'A beautiful room with great amenities',
            'price_per_night' => 150,
            'capacity' => 3,
            'beds' => '1 King, 1 Single',
            'amenities' => 'WiFi, TV, Mini Bar',
            'size' => '30',
            'images' => [$imageFile],
            'is_active' => true,
        ];

        $response = $this->post(route('manager.hotels.rooms.store', $this->hotel), $roomData);

        $response->assertRedirect();
        $this->assertDatabaseHas('rooms', [
            'hotel_id' => $this->hotel->id,
            'name' => 'Deluxe Room',
            'price_per_night' => 150,
            'capacity' => 3,
        ]);
    }

    /**
     * Test hotel manager can update a room
     */
    public function test_hotel_manager_can_update_room()
    {
        $this->actingAs($this->manager);

        $response = $this->get(route('manager.hotels.rooms.edit', [
            'hotel' => $this->hotel,
            'room' => $this->room
        ]));

        $response->assertStatus(200);

        $updateData = [
            'name' => 'Updated Room Name',
            'description' => 'Updated room description',
            'price_per_night' => 200,
            'capacity' => $this->room->capacity,
            'beds' => $this->room->beds,
            'amenities' => $this->room->amenities,
            'size' => $this->room->size,
            'is_active' => true,
        ];

        $response = $this->put(route('manager.hotels.rooms.update', [
            'hotel' => $this->hotel,
            'room' => $this->room
        ]), $updateData);

        $response->assertRedirect();
        $this->assertDatabaseHas('rooms', [
            'id' => $this->room->id,
            'name' => 'Updated Room Name',
            'price_per_night' => 200,
        ]);
    }

    /**
     * Test hotel manager cannot update rooms of another hotel
     */
    public function test_hotel_manager_cannot_update_other_hotel_rooms()
    {
        $otherManager = User::factory()->create([
            'role' => 'hotel_manager',
            'is_approved' => true,
        ]);

        $otherHotel = Hotel::factory()->create([
            'manager_id' => $otherManager->id,
        ]);

        $otherRoom = Room::factory()->create([
            'hotel_id' => $otherHotel->id,
        ]);

        $this->actingAs($this->manager);

        $response = $this->get(route('manager.hotels.rooms.edit', [
            'hotel' => $otherHotel,
            'room' => $otherRoom
        ]));

        $response->assertStatus(403);

        $updateData = [
            'name' => 'Should Not Update',
            'description' => 'Should not update',
            'price_per_night' => 999,
            'capacity' => $otherRoom->capacity,
            'beds' => $otherRoom->beds,
            'amenities' => $otherRoom->amenities,
            'size' => $otherRoom->size,
            'is_active' => true,
        ];

        $response = $this->put(route('manager.hotels.rooms.update', [
            'hotel' => $otherHotel,
            'room' => $otherRoom
        ]), $updateData);

        $response->assertStatus(403);
        $this->assertDatabaseMissing('rooms', [
            'id' => $otherRoom->id,
            'name' => 'Should Not Update',
        ]);
    }

    /**
     * Test hotel manager can delete room
     */
    public function test_hotel_manager_can_delete_room()
    {
        $this->actingAs($this->manager);

        $roomToDelete = Room::factory()->create([
            'hotel_id' => $this->hotel->id,
        ]);

        $response = $this->delete(route('manager.hotels.rooms.destroy', [
            'hotel' => $this->hotel,
            'room' => $roomToDelete
        ]));

        $response->assertRedirect();
        $this->assertSoftDeleted($roomToDelete);
    }

    /**
     * Test booking form is displayed for active rooms
     */
    public function test_booking_form_is_displayed_for_active_rooms()
    {
        $this->actingAs($this->customer);

        $response = $this->get(route('reservations.create', $this->room));

        $response->assertStatus(200);
        $response->assertViewIs('customer.bookings.create');
    }

    /**
     * Test booking form is not available for inactive rooms
     */
    public function test_booking_form_not_available_for_inactive_rooms()
    {
        $this->actingAs($this->customer);

        $inactiveRoom = Room::factory()->create([
            'hotel_id' => $this->hotel->id,
            'is_active' => false,
        ]);

        $response = $this->get(route('reservations.create', $inactiveRoom));

        $response->assertRedirect(route('hotels.show', $this->hotel));
        $response->assertSessionHas('error');
    }

    /**
     * Test admin can view all rooms
     */
    public function test_admin_can_view_all_rooms()
    {
        $this->actingAs($this->admin);

        // Create multiple hotels with rooms
        $hotels = Hotel::factory(3)->create();
        foreach ($hotels as $hotel) {
            Room::factory(2)->create(['hotel_id' => $hotel->id]);
        }

        // Admin should be able to see all hotel rooms
        $response = $this->get(route('admin.hotels.index'));

        $response->assertStatus(200);
        $this->assertCount(3 + 1, Hotel::all()); // +1 for the hotel created in setUp
    }
}
