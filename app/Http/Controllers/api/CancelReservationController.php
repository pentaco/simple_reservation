<?php

namespace App\Http\Controllers\Api;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\TimeslotStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\ReservationStatus;

class CancelReservationController extends Controller
{
    public function __invoke(Request $request)
    {
        try {
            DB::beginTransaction();
            $reservation = Reservation::code($request->code)->with('timeslots')->first();
            $timelots = $reservation->timeslots;
            foreach ($timelots as $timelot) {
                $timelot->update([
                    'timeslot_status_id' => TimeslotStatus::VACANT
                ]);
            }
            $reservation->update([
                'reservation_status_id' => ReservationStatus::CANCELED
            ]);
            DB::commit();
            return response()->json("キャンセルしました。", Response::HTTP_OK);
        } catch (\Exception $e) {
            Log::error($e);
            DB::rollback();
            return response()->json($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
