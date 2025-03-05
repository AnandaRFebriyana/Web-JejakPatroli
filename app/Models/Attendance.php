<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model {
    use HasFactory;

    protected $guarded = ['id'];
    // protected $dates = ['date'];

    // public function getDateAttribute($value) {
    //     // tipedata timestamp
    //     return Carbon::createFromTimestamp($value);
    // }

    public function getDateAttribute($value) {
        // tipedata date
        return Carbon::parse($value);
    }

    public function shift() {
        return $this->belongsTo(Shift::class);
    }

    public function guardRelation() {
        return $this->belongsTo(Guard::class, 'guard_id');
    }
}
