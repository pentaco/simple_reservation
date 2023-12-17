<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timeslot extends Model
{
    use HasFactory;
    protected $fillable =[
        'date',
        'table_id',
        'timetable_id',
        'timeslot_status_id',
    ];

    //
    // リレーション
    //-----------------------------------------------
    public function table()
    {
        return $this->belongsTo(Table::class);
    }
    public function timetable()
    {
        return $this->belongsTo(Timetable::class);
    }
    public function reservations()
    {
        return $this->belongsToMany(Reservation::class, 'reservations_timeslots');
    }
}
