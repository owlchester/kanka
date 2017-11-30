<?php

namespace App\Services;

use App\Models\Character;
use Illuminate\Database\Eloquent\Model;

class RandomCharacterService
{
    /**
     * @var Character
     */
    protected $character;

    protected $translations = [];

    /**
     * RandomCharacterService constructor.
     * @param Character $character
     */
    public function __construct(Character $character)
    {
        $this->character = $character;
        $this->translations = trans('randomisers/characters');
    }

    /**
     * Generate a new random character with some attributes
     *
     * @return Character
     */
    public function generate($field = '', $max = 1, $min = 1)
    {
        if (request()->route()->getName() != 'characters.random') {
            return null;
        }

        // No random values for this field
        if (empty($this->translations[$field])) {
            return null;
        }

        $random = [];

        // If the first element has a key
        $keys = array_keys($this->translations[$field]);
        if (is_string($keys[0])) {
            foreach ($this->translations[$field] as $key => $values) {
                $r = $values[mt_rand(0, count($values)-1)];
                if (!empty($r)) {
                    $random[] = $r;
                }
            }
        } else {
            // Not always up to max
            if ($max > $min) {
                // 20% chance that max goes down one
                $r = mt_rand(0, 100);
                if ($r >= 95) {
                    $max = $min;
                } elseif ($r >= 70) {
                    if ($r >= 90 && ($max > ($min+2))) {
                        $max -= 2;
                    } else {
                        $max--;
                    }
                }
            }
            for ($i = $min; $i <= $max; $i++) {
                $r = $this->translations[$field][mt_rand(0, count($this->translations[$field]) - 1)];
                if (in_array($r, $random)) {
                    $i--;
                } else {
                    $random[] = $r;
                }
            }
        }

        return implode(' ', $random);
    }

    /**
     * Generate a random number between min and max
     *
     * @param int $min
     * @param int $max
     * @return int
     */
    public function generateNumber($min = 1, $max = 200)
    {
        if (request()->route()->getName() != 'characters.random') {
            return null;
        }

        return mt_rand(intval($min), intval($max));
    }

    /**
     * @param $model
     * @return array
     */
    public function generateForeign($model)
    {
        if (request()->route()->getName() != 'characters.random') {
            return [];
        }

        $first = (new $model)->inRandomOrder()->first();
        if (!empty($first)) {
            return [$first->id => $first->name];
        }
        return [];
    }
}
