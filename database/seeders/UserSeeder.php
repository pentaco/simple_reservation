<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $params = [
            ['name' => '管理者', 'email' => config('seeder.user_email'), 'password' => Hash::make(config('seeder.user_pass'))],
        ];
        foreach ($params as $param) {
            User::create($param);
        }
    }
}
