<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Artisan::call('passport:keys');
        Artisan::call('passport:client --personal --name="Candidate Personal Access Client" --provider="candidates" --quiet');
        Artisan::call('passport:client --personal --name="Company Personal Access Client" --provider="companies" --quiet');
    }
}
