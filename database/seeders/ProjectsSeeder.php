<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectsSeeder extends Seeder {
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run() {
        Project::factory(10)->create();
    }
}
