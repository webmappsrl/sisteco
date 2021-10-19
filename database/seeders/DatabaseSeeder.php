<?php

namespace Database\Seeders;

use App\Models\LandUse;
use App\Models\Owner;
use App\Models\Project;
use App\Models\Research;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder {
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run() {
        $production = config('app.env') == 'production';
        if ($production) {
            if (User::all()->count() > 0)
                return;
            if (LandUse::all()->count() > 0)
                return;
            $this->call([
                UsersSeeder::class,
                LandUsesSeeder::class
            ]);
        } else {
            $this->call([
                UsersSeeder::class,
                LandUsesSeeder::class
            ]);

            Artisan::call('sisteco:import_cadastral_parcels');

            $this->call([
                OwnersSeeder::class,
                ResearchesSeeder::class,
                ProjectsSeeder::class
            ]);
        }
    }
}
