<?php

return [
    'timetable_version' => env('TIMETABLE_VERSION'),
    'slot_count' => env('SLOT_COUNT'),
    'exclude_days' => !empty(env('EXCLUDE_DAYS')) ? array_map('trim', explode(',', env('EXCLUDE_DAYS'))) : [],
    'enable_reservation_before_open' => env('ENABLE_RESERVATION_BEFORE_OPEN'),
    'limit_hours_before_reservation_start' => env('LIMIT_HOURS_BEFORE_RESERVATION_START'),
];