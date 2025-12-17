<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'name' => 'Robert',
                'username' => 'Robert',
                'email' => 'robert@example.com',
                'password' => Hash::make('12345678'),
                'role' => 'admin'
            ],
            [
                'name' => 'Shitu',
                'username' => 'Shitu',
                'email' => 'shitu@example.com',
                'password' => Hash::make('password123'),
                'role' => 'customer'
            ],
            [
                'name' => 'Kasika',
                'username' => 'Kasika',
                'email' => 'kasika@example.com',
                'password' => Hash::make('password123'),
                'role' => 'customer'
            ],
            [
                'name' => 'Admin',
                'username' => 'Admin',
                'email' => 'admin@tapeats.com',
                'password' => Hash::make('admin123'),
                'role' => 'admin'
            ]
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                $user
            );
        }
    }
}
