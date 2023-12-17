<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Table;
use App\Models\Timeslot;
use App\Models\Timetable;
use App\Services\TimeslotService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class WebCreateReservationController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {

        $today = Carbon::today();
        $timetables = Timetable::current()->get();
        $tables = Table::orderBy('id', 'asc')->get();
        // $timeslots = Timeslot::with('timetable')->where('date', $today)->orderBy('table_id', 'asc')->orderBy('timetable_id', 'asc')->get();
        $timeslots = Timeslot::with('timetable')
        ->where('date', $today)
        ->whereHas('timetable', function($query){
            $query->orderBy('start', 'asc' );
        })
        ->get();
        $grouped_timeslots = $timeslots->groupBy('timetable_id');
        $timeslot_service = new TimeslotService;
        $reservable_timeslot_ids = $timeslot_service->getReservableTimeSlotIds($timeslots);
        $selectable_timeslot_ids = $reservable_timeslot_ids['selectable_timeslot_ids'];
        $reserve_url = route('api.reservation.store');
        $detail_url = route('reservation.show');
        $reservations_open_at = Carbon::parse($timetables[0]->start)->subHours(config('settings.enable_reservation_before_open'));
        return view('web.reservation.create', compact('timetables', 'today', 'tables', 'grouped_timeslots', 'selectable_timeslot_ids', 'reserve_url', 'detail_url', 'reservations_open_at'));
    }
}
