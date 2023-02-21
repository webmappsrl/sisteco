<?php

namespace Database\Seeders;

use App\Models\Catalog;
use App\Models\CatalogType;
use Illuminate\Database\Seeder;

class CatalogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Catalog::factory()->create([
            'name' => 'MIPAAF / SIMONE',
            'description' => 'Progetto MIPAAF, rilievi sul campo'
        ]);

        CatalogType::factory()->create([
            'code'=>'A',
            'name'=>'Nessun intervento',
            'price'=>0.0,
            'catalog_id'=>1,
        ]);
        CatalogType::factory()->create([
            'code'=>'B',
            'name'=>'Diradamento',
            'price'=>20.0,
            'catalog_id'=>1,
        ]);
        CatalogType::factory()->create([
            'code'=>'C',
            'name'=>'Avviamento',
            'price'=>30.0,
            'catalog_id'=>1,
        ]);
    }
}
