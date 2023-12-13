<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeslotStatus extends Model
{
    use HasFactory;

    const VACANT = 0;
    const RESERVED = 1;
}
