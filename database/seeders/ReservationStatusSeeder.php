<?php

namespace Database\Seeders;

use App\Models\ReservationStatus;
use App\Models\TimeslotStatus;
use Illuminate\Database\Seeder;

class ReservationStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $params = [
            ['name' => '予約完了'],
            ['name' => 'キャンセル']
        ];
        foreach ($params as $param) {
            ReservationStatus::create($param);
        }
    }
}
