<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Model;

class Guard extends Model {
    use HasFactory;

    protected $guarded = ['id'];
    public $timestamps = false;

    public function schedules() {
        return $this->hasMany(Schedule::class);
    }

    public function attendances() {
        return $this->hasMany(Attendance::class);
    }

    public function permissions() {
        return $this->hasMany(Permission::class);
    }

    public function reports() {
        return $this->hasMany(Report::class);
    }
}