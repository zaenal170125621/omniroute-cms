<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'name' => 'Administrator',
                'email' => 'admin@omniroute.dev',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ],
            [
                'name' => 'Content Editor',
                'email' => 'editor@omniroute.dev',
                'password' => Hash::make('password'),
                'role' => 'editor',
            ],
            [
                'name' => 'Sales Staff',
                'email' => 'sales@omniroute.dev',
                'password' => Hash::make('password'),
                'role' => 'sales',
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                $user
            );
        }
    }
}
