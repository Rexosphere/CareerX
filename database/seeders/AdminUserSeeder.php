<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if admin already exists to prevent duplicates
        if (!Admin::where('email', 'admin@careerx.com')->exists()) {
            Admin::create([
                'name' => 'Admin',
                'email' => 'admin@careerx.com',
                'password' => Hash::make('123'),
            ]);
        }
    }
}
