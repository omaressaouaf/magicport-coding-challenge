<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $seeders = [
            UserSeeder::class,
        ];

        if (! app()->environment('testing')) {
            $seeders[] = ProjectSeeder::class;
        }

        $this->call($seeders);
    }
}
