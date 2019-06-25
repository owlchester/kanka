<?php

namespace App\Services;

use App\Models\Character;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class RandomCharacterService
{
    /**
     * @var Character
     */
    protected $character;

    /**
     * @var array
     */
    protected $translations = [];

    /**
     * RandomCharacterService constructor.
     * @param Character $character
     */
    public function __construct(Character $character)
    {
        $this->character = $character;

        // Let's build english + local language to make sure all the numbers match properly. This is because in en-US,
        // we only translate a few words and lose the original translations.
        $this->translations = trans('randomisers/characters', [], 'en');
        $this->translations = array_replace_recursive($this->translations, trans('randomisers/characters'));
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
     * Generate a boolean with a 50/50% chance of being true or false
     *
     * @param int $threshold
     * @return bool
     */
    public function generateBool($threshold = 50)
    {
        return mt_rand(1, 100) <= intval($threshold);
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

    public function generateTraits($physical = true)
    {
        $availableTraits = [
            'skin', 'hair', 'eye', 'height', 'weight'
        ];
        if (!$physical) {
            $availableTraits = [
                'fear', 'goal', 'mannerism', 'trait'
            ];
        }
        $traits = [];
        for ($i = 0; $i <= count($availableTraits) - 1; $i++) {
            $traitKey = $availableTraits[$i];
            $randomNumber = in_array($traitKey, ['height', 'weight']);
            $trait = new \stdClass();
            $trait->id = null;
            $trait->name = __('randomisers/characters.traits.' . $traitKey);
            $trait->entry = $randomNumber ? $this->generateNumber(45, 220) : $this->generate($traitKey);

            $traits[] = $trait;
        }

        return $traits;
    }
}
