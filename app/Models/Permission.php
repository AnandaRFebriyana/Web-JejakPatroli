<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model {
    use HasFactory;

    protected $guarded = ['id'];

    public function guardRelation() {
        return $this->belongsTo(Guard::class, 'guard_id');
    }
}
