<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed sākotnējos reģionus
        $this->call(RegionsTableSeeder::class);

        // Seed testa lietotāju
        User::factory()->create([
            'first_name' => 'Test',
            'last_name'  => 'User',
            'email'      => 'test@example.com',
            'password'   => bcrypt('password'), // default parole
            'region_id'  => 1, // Kurzeme
            'weight'     => 70,
            'augums'     => 180,
        ]);
    }
}
