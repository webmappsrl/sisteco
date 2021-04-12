<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder {
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run() {
        User::factory(1)->create([
            'name' => 'Webmapp Team',
            'email' => 'team@webmapp.it',
            'password' => bcrypt('timesisteco'),
            'remember_token' => 'g2BOTXhe5IfYVTXYmxTfDu1ribuh52lSdoqMj76Bk58MsUl1IuMdBzcg7JYq'
        ]);

        User::factory(1)->create([
            'name' => 'Mario Pestarini',
            'email' => 'mario.pestarini@timesis.it',
            'password' => bcrypt('timesisteco'),
        ]);

        User::factory(1)->create([
            'name' => 'Fabrizio Cassi',
            'email' => 'fabrizio.cassi@timesis.it',
            'password' => bcrypt('timesisteco'),
        ]);

        User::factory(1)->create([
            'name' => 'Leonardo Pugliesi',
            'email' => 'leonardo.pugliesi@timesis.it',
            'password' => bcrypt('timesisteco'),
        ]);

        User::factory(1)->create([
            'name' => 'Anna Chiara Lorenzelli',
            'email' => 'ac.lorenzelli@timesis.it',
            'password' => bcrypt('timesisteco'),
        ]);

        User::factory(1)->create([
            'name' => 'Enrico Quaglino',
            'email' => 'enrico.quaglino@timesis.it',
            'password' => bcrypt('timesisteco'),
        ]);

        User::factory(1)->create([
            'name' => 'Mauro Piazzi',
            'email' => 'mauro.piazzi@timesis.it',
            'password' => bcrypt('timesisteco'),
        ]);
    }
}
