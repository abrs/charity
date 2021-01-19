<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = [
        'point_id', 
        'name',
        'is_enabled', 
        'deleted_at', 
        'created_by',
        'modified_by', 
    ];

    /** Relations ----------- */
    public function point() {
        return $this->belongsTo(Point::class);
    }

    public function beneficiaries() {
        return $this->hasMany(Beneficiary_Info::class);
    }
}
