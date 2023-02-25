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

        $c = Catalog::factory()->create([
            'name' => 'MIPAAF 2023 / Rilievi',
            'description' => 'Progetto MIPAAF, rilievi sul campo'
        ]);

        CatalogType::factory()->create([
            'code_int'=>'1',
            'name'=>'',
            'prices'=> [
                'A.1' => 12814,
                'A.2' => 12981,
                'A.3' => 13149,
                'B.1' => 13422,
                'B.2' => 13589,
                'B.3' => 13756,
                'C.1' => 13178,
                'C.2' => 13346,
                'C.3' => 13513,
            ],
            'catalog_id'=>$c->id,
        ]);
        CatalogType::factory()->create([
            'code_int'=>'2',
            'name'=>'Diradamento',
            'prices'=> [
                'A.1' => 7069,
                'A.2' => 8132,
                'A.3' => 9348,
                'B.1' => 7041,
                'B.2' => 8025,
                'B.3' => 9151,
                'C.1' => 7426,
                'C.2' => 10284,
                'C.3' => 11649,
            ],
            'catalog_id'=>$c->id,
        ]);
        CatalogType::factory()->create([
            'code_int'=>'3',
            'name'=>'Avviamento',
            'prices'=> [
                'A.1' => 5411,
                'A.2' => 5959,
                'A.3' => 6726,
                'B.1' => 5464,
                'B.2' => 5971,
                'B.3' => 6681,
                'C.1' => 6230,
                'C.2' => 7386,
                'C.3' => 8121,
            ],
            'catalog_id'=>$c->id,
        ]);
    }
}
