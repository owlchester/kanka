<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FamilyRelation extends Model
{
    public $table = 'family_relation';

    protected $fillable = ['first_id', 'second_id', 'relation'];

    public function first()
    {
        return $this->belongsTo('App\Models\Family', 'first_id');
    }

    public function second()
    {
        return $this->belongsTo('App\Models\Family', 'second_id');
    }
    //
}
