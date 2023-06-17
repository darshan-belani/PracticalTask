<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use function Symfony\Component\Uid\Factory\create;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $adminData = [
            'name' => 'Admin',
            'email' => "admin@mailinator.com",
            'phone' => '1234567890',
            'password' => \Hash::make('admin@123'),
            'role' => "admin",
        ];

        $addAdmin = User::create($adminData);

    }
}
