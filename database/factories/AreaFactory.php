<?php

namespace Database\Factories;

use App\Models\Area;
use Illuminate\Database\Eloquent\Factories\Factory;

class AreaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Area::class;

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
            'geometry' =>  'POINT(0 0)',
            'layer_id' => \App\Models\AreaLayer::factory(),
//            'properties' => '{"\"a\"=>\"1.0\", \"b\"=>\"2.0\"","\"a\"=>\"3.0\", \"b\"=>\"4.0\""}'
        ];
    }
}
