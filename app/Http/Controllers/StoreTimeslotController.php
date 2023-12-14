<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Table;
use App\Models\Timeslot;
use App\Models\Timetable;
use Illuminate\Http\Request;
use App\Services\TimeslotService;

class StoreTimeslotController extends Controller
{
    public function __invoke(Request $request)
    {
        $startDate = Carbon::parse($request->start);
        $endDate = Carbon::parse($request->end);

        $timeslot_service = new TimeslotService;
        $date_array = $timeslot_service->getDateArray($startDate, $endDate);

        $timetables = Timetable::where('version', config('settings.timetable_version'))->get();
        $tables = Table::get();
        foreach ($tables as $table) {
            foreach ($date_array as $date) {
                foreach ($timetables as $timetable) {
                Timeslot::create([
                    'table_id' => $table->id,
                    'timetable_id' => $timetable->id,
                    'date' => $date,
                ]);
            }
        }
        return view('timeslot.complete');
    }

    }
}
