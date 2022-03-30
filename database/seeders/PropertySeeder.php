<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('properties')->insert([
            'name' => 'vegan',
        ]);

        DB::table('properties')->insert([
            'name' => 'vegetarian',
        ]);

        DB::table('properties')->insert([
            'name' => 'sweet',
        ]);

        DB::table('properties')->insert([
            'name' => 'spicy',
        ]);

        DB::table('properties')->insert([
            'name' => 'gluten free',
        ]);

        DB::table('properties')->insert([
            'name' => 'no salty',
        ]);
    }
}
