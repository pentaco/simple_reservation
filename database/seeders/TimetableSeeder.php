<?php

namespace Database\Seeders;

use App\Models\Timetable;
use Illuminate\Database\Seeder;

class TimetableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $params = [
            ['start' => '18:00', 'end' => '18:30', 'version' => 1], ['start' => '18:30', 'end' => '18:30', 'version' => 1],
            ['start' => '19:00', 'end' => '19:30', 'version' => 1], ['start' => '19:30', 'end' => '20:00', 'version' => 1],
            ['start' => '20:00', 'end' => '20:30', 'version' => 1], ['start' => '20:30', 'end' => '21:00', 'version' => 1],
            ['start' => '21:00', 'end' => '21:30', 'version' => 1], ['start' => '21:30', 'end' => '22:00', 'version' => 1],
            ['start' => '22:00', 'end' => '22:30', 'version' => 1], ['start' => '22:30', 'end' => '23:00', 'version' => 1],
        ];
        foreach ($params as $param) {
            Timetable::create($param);
        }
    }
}
