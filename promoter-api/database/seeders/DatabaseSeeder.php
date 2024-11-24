<?php

namespace Database\Seeders;

use App\Models\Promoter;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Promoter::factory(10)->create();
    }
}
