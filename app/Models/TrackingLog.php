<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackingLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'guard_id',
        'latitude',
        'longitude',
        'created_at'
    ];

    public function guardRelation()
    {
        return $this->belongsTo(Guard::class, 'guard_id');
    }
}

