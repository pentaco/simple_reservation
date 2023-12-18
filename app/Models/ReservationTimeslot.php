<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservationTimeslot extends Model
{
    use HasFactory;
    protected $table = 'reservations_timeslots';
    protected $fillable =[
        'reservation_id',
        'timeslot_id',
    ];
}
