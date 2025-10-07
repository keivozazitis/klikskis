<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegionsTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('regions')->insert([
            ['id' => 1, 'name' => 'Kurzeme'],
            ['id' => 2, 'name' => 'Vidzeme'],
            ['id' => 3, 'name' => 'Latgale'],
            ['id' => 4, 'name' => 'Zemgale'],
        ]);
    }
}
