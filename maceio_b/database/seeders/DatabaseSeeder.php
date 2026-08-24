<?php

namespace Database\Seeders;

use App\Models\Userers;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Userers::factory(10)->create();

        Userers::factory()->create([
            'name' => 'Test Userers',
            'email' => 'test@example.com',
        ]);
    }
}
