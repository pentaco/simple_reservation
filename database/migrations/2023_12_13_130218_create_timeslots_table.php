<?php

use App\Models\TimeslotStatus;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('timeslots', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->foreignId('table_id')->default(null)->nullable();
            $table->foreignId('timetable_id')->default(null)->nullable();
            $table->foreignId('timeslot_status_id')->default(TimeslotStatus::VACANT);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('timeslots');
    }
};
