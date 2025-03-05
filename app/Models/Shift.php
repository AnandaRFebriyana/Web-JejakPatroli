<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model {
    use HasFactory;

    protected $guarded = ['id'];
    public $timestamps = false;

    public function schedules() {
        return $this->hasMany(Schedule::class);
    }

    public function attendances() {
        return $this->hasMany(Attendance::class);
    }
}
