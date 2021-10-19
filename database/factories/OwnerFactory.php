<?php

namespace Database\Factories;

use App\Models\CadastralParcel;
use App\Models\owner;
use Illuminate\Database\Eloquent\Factories\Factory;

class OwnerFactory extends Factory {
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = owner::class;

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure(): OwnerFactory {
        return $this->afterCreating(function (Owner $model) {
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
            'first_name' => $this->faker->name,
            'last_name' => $this->faker->name,
            'email' => $this->faker->email,
            'business_name' => $this->faker->company,
            'vat_number' => $this->faker->imei,
            'fiscal_code' => $this->faker->text(16),
            'phone' => substr($this->faker->phoneNumber, 0, 14),
            'addr:street' => $this->faker->streetName,
            'addr:housenumber' => $this->faker->numberBetween(1, 100),
            'addr:city' => $this->faker->city,
            'addr:postcode' => $this->faker->postcode,
            'addr:province' => $this->faker->citySuffix,
            'addr:locality' => $this->faker->city,
        ];
    }
}
