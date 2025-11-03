<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {

        // Load the raw SQL file
        $path = base_path('database/create.sql');
        $sql = file_get_contents($path);
        // Run the SQL script
        DB::unprepared($sql);
        $path = base_path('database/populate.sql');
        $sql = file_get_contents($path);
        DB::unprepared($sql);
        $this->command->info('Database seeded!');
    }
}
