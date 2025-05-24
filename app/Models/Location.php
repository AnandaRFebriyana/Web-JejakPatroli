<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        $isWithinTimeLimit = $this->created_at->diffInMinutes(now()) <= 30;
        $isAttendanceActive = $this->attendance && !$this->attendance->check_out_time;
        return $isWithinTimeLimit && $isAttendanceActive;
    }
}
