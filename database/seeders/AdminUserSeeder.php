<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Slamet Wahyudi E. G.',
            'email' => 'simasdalang@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('Simasdalang2024'),
            'role' => 'admin',
        ]);
    }
}
