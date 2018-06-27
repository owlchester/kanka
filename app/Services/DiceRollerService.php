<?php

namespace App\Services;

use App\Models\Attribute;
use App\Models\DiceRoll;
use App\Models\Entity;
use DiceCalc\Calc;

class DiceRollerService
{
    /**
     * @param $query
     * @return mixed
     */
    public function roll(DiceRoll $diceRoll)
    {
        // Switch character attributes with the values
        $query = strtolower($diceRoll->parameters);

        $attributes = [];
        if ($diceRoll->character) {
            foreach ($diceRoll->character->entity->attributes as $attribute) {
                $attributes[strtolower('{character.' . $attribute->name . '}')] = $attribute->value;
            }
        }
        preg_match_all("/\{(.*?)\}/", $query, $matches);
        foreach ($matches[0] as $match) {
            $match = strtolower($match);
            if (isset($attributes[$match])) {
                $query = str_replace($match, $attributes[$match], $query);
            }
        }

        $query = str_replace('+-', '-', $query);

        $calc = new Calc($query);
        return $calc();
    }
}
