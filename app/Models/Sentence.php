<?php

namespace App\Models;

use App\Traits\CustomModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sentence extends Model
{

    use SoftDeletes, CustomModel;

    protected $with = ['languages'];
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'deleted_at', 
        'is_enabled', 
        'created_by', 
        'modified_by', 
        'body'
    ];

    /** Relations ----------- */
    public function languages() {

        return $this->belongsToMany(Language::class)
            ->withPivot('translation')
            ->withTimestamps();
    }

}
