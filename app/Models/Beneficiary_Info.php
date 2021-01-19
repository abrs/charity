<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Beneficiary_Info extends Model
{
    protected $table = 'beneficiary_infos';
    protected $with = ['location', 'type_info.user'];

    protected $fillable = [
        'type_infos_id', 
        'location_id',
        'is_enabled', 
        'deleted_at', 
        'created_by',
        'modified_by', 
    ];

    /** Relations ----------- */
    public function type_info() {
        return $this->belongsTo(Type_Info::class, 'type_infos_id');
    }

    public function location() {
        return $this->belongsTo(Location::class);
    }
}
