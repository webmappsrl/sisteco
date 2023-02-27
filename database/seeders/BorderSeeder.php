<?php

namespace Database\Seeders;

use App\Models\Border;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BorderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = json_decode(file_get_contents(storage_path('app/imports/montepisano.geojson')),TRUE);
        $geometry = json_encode($json['features'][0]['geometry']);
        $border = Border::factory()->create([
            'name' => 'MontePisano',
            'geometry' => DB::raw("St_GeomFromGeoJson('$geometry')"),
        ]);
    }
}
