<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Location extends Model {
    use HasFactory;

    protected $guarded = ['id'];
    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function attendance() {
        return $this->belongsTo(Attendance::class, 'attendance_id');
    }
    
    public function guardRelation() {
        return $this->belongsTo(Guard::class, 'guard_id');
    }

    // Virtual attribute for active status
    public function getIsActiveAttribute() {
        if (!$this->created_at || !$this->attendance || !$this->attendance->check_in_time) {
            return false;
        }

        // Buat datetime dari tanggal attendance dan waktu created_at
        $locationDateTime = \Carbon\Carbon::parse($this->attendance->date)
            ->setTime(
                $this->created_at->hour,
                $this->created_at->minute,
                $this->created_at->second
            );

        // Buat datetime dari tanggal attendance dan waktu check-in
        $checkInDateTime = \Carbon\Carbon::parse($this->attendance->date)
            ->setTime(
                \Carbon\Carbon::parse($this->attendance->check_in_time)->hour,
                \Carbon\Carbon::parse($this->attendance->check_in_time)->minute,
                \Carbon\Carbon::parse($this->attendance->check_in_time)->second
            );

        $isWithinTimeLimit = $locationDateTime->between(
            $checkInDateTime,
            $checkInDateTime->copy()->addMinutes(30)
        );
        
        $isAttendanceActive = !$this->attendance->check_out_time;
        return $isWithinTimeLimit && $isAttendanceActive;
    }
}
