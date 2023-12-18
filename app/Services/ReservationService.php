<?php

namespace App\Services;

use App\Models\Reservation;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Validator as ValidationValidator;

class ReservationService
{
    public function validateInput(Request $request): ValidationValidator
    {
        $validation_array = [
            'customer_name' => ['required'],
            'number_of_people' => ['required'],
            'email' => ['required'],
            'tel' => ['required'],
        ];
        return Validator::make($request->all(), $validation_array);
    }

    public function validateTargetData(Request $request): ValidationValidator
    {
        $validation_array = [
            'timeslot_id' => ['required'],
            'date' => ['required'],
        ];
        return Validator::make($request->all(), $validation_array);
    }

    public function getCode(): string
    {
        do {
            $random_string = Str::random(24);
        } while (Reservation::where('code', $random_string)->exists());
        return $random_string;
    }
}
