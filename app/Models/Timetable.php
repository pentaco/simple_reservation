<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timetable extends Model
{
    use HasFactory;
    protected $fillable =[
        'start',
        'end',
    ];

    //
    // クエリースコープ
    //---------------------------------------------
    public function scopeCurrent($query)
    {
        return $query->where('version', config('settings.timetable_version'));
    }
}
