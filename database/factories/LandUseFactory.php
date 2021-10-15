<?php

namespace Database\Factories;

use App\Models\LandUse;
use Illuminate\Database\Eloquent\Factories\Factory;

class LandUseFactory extends Factory {
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = LandUse::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition() {
        return [
            'code' => $this->faker->word,
            'name' => $this->faker->name
        ];
    }
}
