<?php

namespace App\Models;

use App\Models\Organisation;
use Illuminate\Database\Eloquent\Model;

class OrganisationRelation extends Model
{
    public $table = 'organisation_relation';

    protected $fillable = ['first_id', 'second_id', 'relation'];

    public function first()
    {
        return $this->belongsTo(Organisation::class, 'first_id');
    }

    public function second()
    {
        return $this->belongsTo(Organisation::class, 'second_id');
    }
    //
}
