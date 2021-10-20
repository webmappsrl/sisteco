<?php

namespace Database\Factories;

use App\Models\CadastralParcel;
use App\Models\Owner;
use App\Models\Project;
use App\Models\Research;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory {
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Project::class;

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure(): ProjectFactory {
        return $this->afterCreating(function (Project $model) {
            $ids = CadastralParcel::inRandomOrder()->limit(10)->get()->pluck('id');
            $model->cadastralParcels()->sync($ids);
        });
    }

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array {
        return [
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->text(),
            'research_id' => Research::inRandomOrder()->first()->id,
            'user_id' => User::inRandomOrder()->first()->id
        ];
    }
}
