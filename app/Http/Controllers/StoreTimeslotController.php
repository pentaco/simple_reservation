<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Table;
use App\Models\Timeslot;
use App\Models\Timetable;
use Illuminate\Http\Request;
use App\Services\TimeslotService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StoreTimeslotController extends Controller
{
    public function __invoke(Request $request)
    {
        $startDate = Carbon::parse($request->start);
        $endDate = Carbon::parse($request->end);

        $timeslot_service = new TimeslotService;
        $date_array = $timeslot_service->getDateArray($startDate, $endDate);

        $timetables = Timetable::current()->get();
        $tables = Table::get();
        try {
            DB::beginTransaction();
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
            };
            DB::commit();
        } catch (\Exception $e) {
            Log::error($e);
            DB::rollback();
        }
        return view('timeslot.complete');
    }
}
