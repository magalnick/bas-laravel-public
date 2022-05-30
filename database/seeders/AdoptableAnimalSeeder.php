<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class AdoptableAnimalSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('adoptable_animals')->insert([
            'token' => '00000000-0000-0000-0000-000000000000',
            'type' => '',
            'description' => '',
            'is_active' => 0,
            'is_available' => 0,
        ]);
    }
}
