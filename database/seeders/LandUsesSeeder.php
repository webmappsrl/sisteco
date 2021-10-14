<?php

namespace Database\Seeders;

use App\Models\LandUse;
use Illuminate\Database\Seeder;

class LandUsesSeeder extends Seeder {
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run() {
        LandUse::factory()->create([
            'code' => '223',
            'name' => 'Oliveti'
        ]);
        LandUse::factory()->create([
            'code' => '311',
            'name' => 'Boschi di latifoglie'
        ]);
        LandUse::factory()->create([
            'code' => '311.1',
            'name' => 'Boschi di castagni'
        ]);
        LandUse::factory()->create([
            'code' => '312',
            'name' => 'Boschi di conifere'
        ]);
        LandUse::factory()->create([
            'code' => '313',
            'name' => 'Boschi misti di conifere e latifoglie'
        ]);
        LandUse::factory()->create([
            'code' => '322',
            'name' => 'Arbusti ed erbacee'
        ]);
        LandUse::factory()->create([
            'code' => '323',
            'name' => 'Vegetazione sclerofilla (vegetazione 50 cm - 4 mt, sempreverde, come mirto, corbezzolo, leccio et similia per intendersi internos)'
        ]);
        LandUse::factory()->create([
            'code' => '324',
            'name' => 'Vegetazione boschiva ed arbustiva in evoluzione'
        ]);
        LandUse::factory()->create([
            'code' => '333',
            'name' => 'Area con vegetazione rada'
        ]);
        LandUse::factory()->create([
            'code' => '334',
            'name' => 'Aree percorse da incendi'
        ]);
    }
}
