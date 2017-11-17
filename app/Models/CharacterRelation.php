<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CharacterRelation extends Model
{
    public $table = 'character_relation';

    protected $fillable = ['first_id', 'second_id', 'relation'];

    public function first()
    {
        return $this->belongsTo('App\Character', 'first_id');
    }

    public function second()
    {
        return $this->belongsTo('App\Character', 'second_id');
    }
    //
}
