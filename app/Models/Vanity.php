<?php

namespace App\Models;

class Vanity extends Campaign
{
    public $table = 'campaigns';

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
