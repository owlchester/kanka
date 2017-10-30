<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FamilyRelation extends Model
{
    public $table = 'family_relation';

    protected $fillable = ['first_id', 'second_id', 'relation'];

    public function first()
    {
        return $this->belongsTo(Family::class, 'first_id');
    }

    public function second()
    {
        return $this->belongsTo(Family::class, 'second_id');
    }
    //
}
