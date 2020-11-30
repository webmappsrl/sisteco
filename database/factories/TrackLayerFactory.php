<?php

namespace Database\Factories;

use App\Models\TrackLayer;
use Illuminate\Database\Eloquent\Factories\Factory;

class TrackLayerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TrackLayer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->sentence(1),
            'description' => $this->faker->sentence(1),
        ];
    }
}
