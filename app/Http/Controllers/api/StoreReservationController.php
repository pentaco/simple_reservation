<?php

namespace App\Http\Controllers\api;

use App\Models\Timeslot;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\TimeslotStatus;
use App\Services\TimeslotService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Services\ReservationService;

class StoreReservationController extends Controller
{
    public function __invoke(Request $request)
    {
        try {
            DB::beginTransaction();
            $reservation_service = new ReservationService;
            $target_validator = $reservation_service->validateTargetData($request);
            if ($target_validator->fails()) throw new \Exception("予約対象データの取得に失敗しました。");
            $input_validator = $reservation_service->validateInput($request);
            if ($input_validator->fails()) throw new \Exception('任意項目以外を全て入力してください。');


            // 予約可能か調べる
            $timeslot_service = new TimeslotService;
            $timeslots = Timeslot::with('timetable')->where('date', $request->date)
                ->whereHas('timetable', function($query){
                    $query->orderBy('start', 'asc' );
                })
                ->get();
            $reservable_timeslot_ids = $timeslot_service->getReservableTimeSlotIds($timeslots);
            $selectable_timeslot_ids = $reservable_timeslot_ids['selectable_timeslot_ids'];
            $vacant_timeslot_ids = $reservable_timeslot_ids['vacant_timeslot_ids'];
            $reserve_timeslots = [];
            if (in_array($request->timeslot_id, $selectable_timeslot_ids)) {
                $start_index = array_search($request->timeslot_id, $vacant_timeslot_ids);
                $reserve_timeslot_ids = array_slice($vacant_timeslot_ids, $start_index, config('settings.slot_count'));
                $reserve_timeslots = Timeslot::whereIn('id', $reserve_timeslot_ids)->get();
            } else {
                throw new \Exception("申し訳ございません。操作中に予約済みとなりました。\n再読み込みをして、最新情報を取得してください。");
            }
            //ランダムな予約コードを生成する
            $reservation_code = $reservation_service->getCode();

            $reservation = Reservation::create([
                'customer_name' => $request->customer_name,
                'number_of_people' => $request->number_of_people,
                'email' => $request->email,
                'tel' => $request->tel,
                'note' => $request->note,
                'code' => $reservation_code,
            ]);
            foreach ($reserve_timeslots as $reserve_timeslot) {
                $reserve_timeslot->update([
                    'timeslot_status_id' => TimeslotStatus::RESERVED
                ]);
                $reserve_timeslot->reservations()->attach($reservation->id);
            }
            DB::commit();
            return response()->json($reservation_code, Response::HTTP_OK);
        } catch (\Exception $e) {
            Log::error($e);
            DB::rollback();
            return response()->json($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
