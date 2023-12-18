<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Carbon\Carbon;

class WebShowReservationController extends Controller
{
    public function __invoke(Request $request)
    {

        $reservation_code = $request->reservation_code;
        $reservation = Reservation::select('id', 'customer_name', 'number_of_people','code', 'note', 'reservation_status_id')
        ->code($reservation_code)
        ->with('timeslots.table')
        ->with(['timeslots.timetable' => function ($query) {
            $query->orderBy('start', 'asc');
        }])
        ->first();
        if (empty($reservation)) abort(404);

        $today = Carbon::today();
        $slot_count = config('settings.slot_count');
        $redirect_url_when_canceled = route('home');

        return view('web.reservation.show', compact('reservation', 'today', 'slot_count', 'redirect_url_when_canceled'));
    }
}
