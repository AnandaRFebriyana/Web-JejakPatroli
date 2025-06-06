<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model {
    use HasFactory;

    protected $guarded = ['id'];

    public function guardRelation() {
        return $this->belongsTo(Guard::class, 'guard_id');
    }
}
