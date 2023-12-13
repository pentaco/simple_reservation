<?php

namespace Database\Seeders;

use App\Models\TimeslotStatus;
use Illuminate\Database\Seeder;

class TimeslotStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $params = [
            ['name' => '空席'],
            ['name' => '予約済み']
        ];
        foreach ($params as $param) {
            TimeslotStatus::create($param);
        }
    }
}
