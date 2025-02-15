<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'firstname' => 'Super',
            'lastname' =>  'Admin',
            'email' => env('APP_EMAIL'),
            'password' => Hash::make('1234567890'),
            'role' => Role::SUPERADMIN,
        ]);
    }
}
