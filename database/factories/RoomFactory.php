<?php

namespace Database\Factories;

use App\Models\Hotel;
use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Room>
 */
class RoomFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Room::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $roomTypes = ['Single', 'Double', 'Twin', 'Deluxe', 'Suite', 'Presidential Suite'];

        return [
            'hotel_id' => Hotel::factory(),
            'name' => $this->faker->randomElement($roomTypes) . ' Room ' . $this->faker->numberBetween(100, 999),
            'description' => $this->faker->paragraph(),
            'capacity' => $this->faker->numberBetween(1, 4),
            'price_per_night' => $this->faker->numberBetween(50, 500),
            'beds' => $this->faker->randomElement(['1 King', '2 Queen', '1 Queen', '1 King, 1 Single']),
            'amenities' => 'WiFi, TV, Air Conditioning, Mini Bar',
            'size' => $this->faker->numberBetween(20, 100),
            'image' => 'rooms/' . $this->faker->image('public/storage/rooms', 800, 600, null, false),
            'is_active' => true,
        ];
    }

    /**
     * Indicate that the room should be inactive.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function inactive()
    {
        return $this->state(function (array $attributes) {
            return [
                'is_active' => false,
            ];
        });
    }

    /**
     * Set a specific hotel ID
     *
     * @param int $hotel_id
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function forHotel($hotel_id)
    {
        return $this->state(function (array $attributes) use ($hotel_id) {
            return [
                'hotel_id' => $hotel_id,
            ];
        });
    }

    /**
     * Create a room with high price
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function luxury()
    {
        return $this->state(function (array $attributes) {
            return [
                'price_per_night' => $this->faker->numberBetween(500, 2000),
                'name' => 'Luxury Suite ' . $this->faker->numberBetween(100, 999),
                'capacity' => 4,
                'amenities' => 'WiFi, TV, Air Conditioning, Mini Bar, Jacuzzi, Room Service, Butler',
            ];
        });
    }
}
