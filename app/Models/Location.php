<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model {
    use HasFactory;

    protected $guarded = ['id'];
    public $timestamps = false;

    public function report() {
        return $this->hasMany(Report::class);
    }
    public function attandancesRelation() {
        return $this->hasMany(Guard::class, 'guard_id');
    }
    public function guardRelation() {
        return $this->belongsTo(Guard::class, 'guard_id');
    }


}
