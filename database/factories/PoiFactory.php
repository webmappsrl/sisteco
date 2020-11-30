<?php

namespace Database\Factories;

use App\Models\Poi;
use Illuminate\Database\Eloquent\Factories\Factory;

class PoiFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Poi::class;

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
            'layer_id' => \App\Models\PoiLayer::factory(),
        ];
    }
}
