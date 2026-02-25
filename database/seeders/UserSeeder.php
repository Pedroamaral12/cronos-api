<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = [
            'name' => 'admin', 
            'cpf' => '09876543210',
            'email' => 'admin@admin.com', 
            'password' => '12345678'
        ];

        User::create($user);
    }
}
