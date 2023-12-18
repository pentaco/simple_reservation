<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Table;
use App\Models\TimeslotStatus;
use Illuminate\Database\Eloquent\Collection;

class TimeslotService
{


    function getDateArray(Carbon $start_date, Carbon $end_date): array
    {
        // 店休の曜日を指定できる
        $exclude_days = config('settings.exclude_days');
        $date_array = [];

        // 開始日から終了日までの日付を生成
        $currentDate = $start_date->copy();
        while ($currentDate->lte($end_date)) {
            // 特定の曜日が除外対象でなければ配列に追加
            if (!in_array($currentDate->format('D'), $exclude_days)) {
                $date_array[] = $currentDate->format('Y-m-d');
            }
            // 日付を1日進める
            $currentDate->addDay();
        }

        return $date_array;
    }

    function getReservableTimeSlotIds(Collection $timeslots): array
    {
        $tables = Table::get();
        $vacant_timeslot_ids = [];
        $selectable_timeslot_ids = [];
        foreach ($tables as $table) {
            $consecutive_timeslots = [];
            foreach ($timeslots as $timeslot) {
                if ($table->id === $timeslot->table_id) {
                    $limit_time_before_reservation_start = Carbon::parse($timeslot->timetable->start)->subHours(config('settings.limit_hours_before_reservation_start'));
                    if ($timeslot->timeslot_status_id === TimeslotStatus::VACANT) {
                        $vacant_timeslot_ids[] = $timeslot->id;
                        if ($limit_time_before_reservation_start->gte(now())) {
                            $consecutive_timeslots[] = $timeslot->id;
                            if (count($consecutive_timeslots) >= config('settings.slot_count')) {
                                $selectable_timeslot_ids[] = array_shift($consecutive_timeslots);
                            }
                        } else {
                            $consecutive_timeslots = [];
                        }
                    }
                }
            }
        }
        $reservable_timeslot_ids = [
            'selectable_timeslot_ids' => $selectable_timeslot_ids,
            'vacant_timeslot_ids' => $vacant_timeslot_ids,

        ];
        return $reservable_timeslot_ids;
    }
}
