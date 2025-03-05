<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model {
    use HasFactory;

    protected $guarded = ['id'];
    public $timestamps = false;
    
    public function guardRelation() {
        return $this->belongsTo(Guard::class, 'guard_id');
    }

    public function shift() {
        return $this->belongsTo(Shift::class);
    }
}