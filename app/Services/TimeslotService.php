<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Room;
use App\Rules\TwoHoursBefore;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Validator as ValidationValidator;

class TimeslotService
{


    function getDateArray(Carbon $start_date, Carbon $end_date): array
    {
        $excludeDays = ['Wen', 'Sun'];
        $date_array = [];

        // 開始日から終了日までの日付を生成
        $currentDate = $start_date->copy();
        while ($currentDate->lte($end_date)) {
            // 特定の曜日が除外対象でなければ配列に追加
            if (!in_array($currentDate->format('D'), $excludeDays)) {
                $date_array[] = $currentDate->format('Y-m-d');
            }
            // 日付を1日進める
            $currentDate->addDay();
        }

        return $date_array;
    }

}
