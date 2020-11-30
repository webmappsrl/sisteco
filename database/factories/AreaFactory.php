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
            'geometry' =>  'Point', 'POINT(0 0)',
            'layer_id' => \App\Models\AreaLayer::factory(),
            'properties' => '"publisher" => "postgresqltutorial.com",
	                        "language"  => "English",
	                        "ISBN-13"   => "978-1449370000"'
        ];
    }
}
