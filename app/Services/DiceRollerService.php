<?php

namespace App\Services;

use App\Models\Attribute;
use App\Models\Entity;
use DiceCalc\Calc;

class DiceRollerService
{
    /**
     * @param $query
     * @return mixed
     */
    public function roll($query)
    {
        $calc = new Calc($query);
        return $calc();
    }
}
