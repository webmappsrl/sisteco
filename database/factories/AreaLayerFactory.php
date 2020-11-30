<?php

namespace Database\Factories;

use App\Models\AreaLayer;
use Illuminate\Database\Eloquent\Factories\Factory;

class AreaLayerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AreaLayer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $n=rand(-1,-129);
        $date = $this->faker->dateTimeBetween($startDate = $n.' day', $endDate = 'now');
        return [
            'name' => $this->faker->sentence(1),
            'description' => $this->faker->sentence(1),
            'created_at'=> $date,
            'updated_at'=>$date
        ];
    }
}
