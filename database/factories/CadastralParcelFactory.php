<?php

namespace Database\Factories;

use App\Models\cadastralParcel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

class CadastralParcelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = cadastralParcel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $a = $this->faker->randomLetter();
        $c1 = $this->faker->numberBetween(100, 999);
        $c2 = $this->faker->numberBetween(10, 99);
        $c3 = $this->faker->numberBetween(10, 99);
        return [
            'code' => $a . $c1 . '_00' . $c2 . '00.' . $c3,
            'geometry' => DB::raw("(ST_GeomFromText('MULTIPOLYGON(((10 45, 11 45, 11 46, 11 46, 10 45)))'))"),
        ];
    }
}
