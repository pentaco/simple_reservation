<?php

namespace App\Http\Controllers;

use App\Models\Timeslot;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class WebReservationController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {


        // Carbonインスタンスを作成して今日の日付を取得
        $today = Carbon::today();
        // 今日の日付を文字列として表示
        // echo $today->toDateString();
        $timeslots = Timeslot::where('date', $today)->orderBy('table_id', 'asc')->get();
        $grouped_timeslots = $timeslots->groupBy('timetable_id');
        // foreach ($grouped_timeslots as $key => $value) {
        //     Log::info($value);
        // }
        return view('web.reservation', compact('grouped_timeslots'));
    }
}
