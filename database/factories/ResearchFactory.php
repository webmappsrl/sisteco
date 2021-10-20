<?php

namespace Database\Factories;

use App\Models\CadastralParcel;
use App\Models\Research;
use Illuminate\Database\Eloquent\Factories\Factory;

class ResearchFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Research::class;

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure(): ResearchFactory
    {
        return $this->afterCreating(function (Research $model) {
            $ids = CadastralParcel::inRandomOrder()->limit(10)->get()->pluck('id');
            $model->cadastralParcels()->sync($ids);
        });
    }

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->text(),
            'elastic_query' => ''
        ];
    }
}
