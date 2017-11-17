<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FamilyRelation extends Model
{
    public $table = 'family_relation';

    protected $fillable = ['first_id', 'second_id', 'relation'];

    public function first()
    {
        return $this->belongsTo('App\Family', 'first_id');
    }

    public function second()
    {
        return $this->belongsTo('App\Family', 'second_id');
    }
    //
}
