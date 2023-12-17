<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;
    protected $fillable =[
        'customer_name',
        'number_of_people',
        'email',
        'tel',
        'note',
        'code',
        'reservation_status_id',
    ];

    //
    // リレーション
    //-----------------------------------------------
    public function reservationStatus()
    {
        return $this->belongsTo(ReservationStatus::class);
    }
    public function timeslots()
    {
        return $this->belongsToMany(Timeslot::class,  'reservations_timeslots');
    }
    //
    // クエリースコープ
    //---------------------------------------------
    public function scopeCode($query, $code)
    {
        return $query->where('code', $code);
    }
}
