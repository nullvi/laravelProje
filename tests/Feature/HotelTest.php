<?php

namespace Tests\Feature;

use App\Models\Hotel;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class HotelTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $admin;
    protected $manager;
    protected $customer;
    protected $hotel;

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

        // Create a test hotel
        $this->hotel = Hotel::factory()->create([
            'manager_id' => $this->manager->id,
            'is_active' => true,
        ]);

        // Configure fake filesystem
        Storage::fake('public');
    }

    /**
     * Test public hotel listing page
     */
    public function test_guest_can_view_hotels_listing()
    {
        $response = $this->get(route('hotels.index'));

        $response->assertStatus(200);
        $response->assertViewIs('hotels.index');
        $response->assertViewHas('hotels');
    }

    /**
     * Test public hotel detail page
     */
    public function test_guest_can_view_hotel_details()
    {
        $response = $this->get(route('hotels.show', $this->hotel));

        $response->assertStatus(200);
        $response->assertViewIs('hotels.show');
        $response->assertViewHas('hotel');
        $response->assertSee($this->hotel->name);
    }

    /**
     * Test hotel manager can access dashboard
     */
    public function test_hotel_manager_can_access_dashboard()
    {
        $this->actingAs($this->manager);

        $response = $this->get(route('manager.dashboard'));

        $response->assertStatus(200);
        $response->assertViewIs('manager.dashboard');
    }

    /**
     * Test hotel manager can view their hotels
     */
    public function test_hotel_manager_can_view_their_hotels()
    {
        $this->actingAs($this->manager);

        $response = $this->get(route('manager.hotels.index'));

        $response->assertStatus(200);
        $response->assertViewIs('manager.hotels.index');
        $response->assertViewHas('hotels');
    }

    /**
     * Test hotel manager can create a new hotel
     */
    public function test_hotel_manager_can_create_hotel()
    {
        $this->actingAs($this->manager);

        $response = $this->get(route('manager.hotels.create'));
        $response->assertStatus(200);

        $imageFile = UploadedFile::fake()->image('hotel.jpg');

        $hotelData = [
            'name' => 'Test Hotel',
            'description' => 'A beautiful hotel for testing',
            'location' => 'Test City',
            'address' => '123 Test Street',
            'rating' => 4.5,
            'image' => $imageFile,
            'is_active' => true,
        ];

        $response = $this->post(route('manager.hotels.store'), $hotelData);

        $response->assertRedirect(route('manager.hotels.index'));
        $this->assertDatabaseHas('hotels', [
            'name' => 'Test Hotel',
            'location' => 'Test City',
            'manager_id' => $this->manager->id,
        ]);
    }

    /**
     * Test hotel manager can update their hotel
     */
    public function test_hotel_manager_can_update_hotel()
    {
        $this->actingAs($this->manager);

        $response = $this->get(route('manager.hotels.edit', $this->hotel));
        $response->assertStatus(200);

        $updateData = [
            'name' => 'Updated Hotel Name',
            'description' => $this->hotel->description,
            'location' => $this->hotel->location,
            'address' => $this->hotel->address,
            'rating' => $this->hotel->rating,
            'is_active' => true,
        ];

        $response = $this->put(route('manager.hotels.update', $this->hotel), $updateData);

        $response->assertRedirect(route('manager.hotels.index'));
        $this->assertDatabaseHas('hotels', [
            'id' => $this->hotel->id,
            'name' => 'Updated Hotel Name',
        ]);
    }

    /**
     * Test hotel manager cannot update another manager's hotel
     */
    public function test_hotel_manager_cannot_update_another_managers_hotel()
    {
        $anotherManager = User::factory()->create([
            'role' => 'hotel_manager',
            'is_approved' => true,
        ]);

        $anotherHotel = Hotel::factory()->create([
            'manager_id' => $anotherManager->id,
        ]);

        $this->actingAs($this->manager);

        $response = $this->get(route('manager.hotels.edit', $anotherHotel));
        $response->assertStatus(403);

        $updateData = [
            'name' => 'Should Not Update',
            'description' => $anotherHotel->description,
            'location' => $anotherHotel->location,
            'address' => $anotherHotel->address,
            'rating' => $anotherHotel->rating,
            'is_active' => true,
        ];

        $response = $this->put(route('manager.hotels.update', $anotherHotel), $updateData);

        $response->assertStatus(403);
        $this->assertDatabaseMissing('hotels', [
            'id' => $anotherHotel->id,
            'name' => 'Should Not Update',
        ]);
    }

    /**
     * Test admin can view all hotels
     */
    public function test_admin_can_view_all_hotels()
    {
        $this->actingAs($this->admin);

        $response = $this->get(route('admin.hotels.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.hotels.index');
        $response->assertViewHas('hotels');
    }

    /**
     * Test admin can edit any hotel
     */
    public function test_admin_can_edit_any_hotel()
    {
        $this->actingAs($this->admin);

        $response = $this->get(route('admin.hotels.edit', $this->hotel));
        $response->assertStatus(200);

        $updateData = [
            'name' => 'Admin Updated Hotel',
            'description' => $this->hotel->description,
            'location' => $this->hotel->location,
            'address' => $this->hotel->address,
            'rating' => $this->hotel->rating,
            'is_active' => true,
            'manager_id' => $this->manager->id,
        ];

        $response = $this->put(route('admin.hotels.update', $this->hotel), $updateData);

        $response->assertRedirect(route('admin.hotels.index'));
        $this->assertDatabaseHas('hotels', [
            'id' => $this->hotel->id,
            'name' => 'Admin Updated Hotel',
        ]);
    }

    /**
     * Test admin can delete a hotel
     */
    public function test_admin_can_delete_hotel()
    {
        $this->actingAs($this->admin);

        $hotel = Hotel::factory()->create();

        $response = $this->delete(route('admin.hotels.destroy', $hotel));

        $response->assertRedirect(route('admin.hotels.index'));
        $this->assertSoftDeleted($hotel);
    }
}
