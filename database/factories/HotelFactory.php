<?php

namespace Database\Factories;

use App\Models\Hotel;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Hotel>
 */
class HotelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Hotel::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
            'description' => $this->faker->paragraph(),
            'location' => $this->faker->city(),
            'address' => $this->faker->address(),
            'rating' => $this->faker->randomFloat(1, 1, 5),
            'image' => 'hotels/' . $this->faker->image('public/storage/hotels', 800, 600, null, false),
            'manager_id' => User::factory()->create(['role' => 'hotel_manager'])->id,
            'is_active' => true,
        ];
    }

    /**
     * Indicate that the hotel should be inactive.
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
     * Set a specific manager ID
     *
     * @param int $manager_id
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function forManager($manager_id)
    {
        return $this->state(function (array $attributes) use ($manager_id) {
            return [
                'manager_id' => $manager_id,
            ];
        });
    }
}
