<?php

namespace App\Datagrids\Filters;

use App\Models\Character;
use App\Models\DiceRoll;

class DiceRollResultFilter extends DatagridFilter
{
    /**
     * Filters available for dice roll results
     */
    public function __construct()
    {
        $this
            ->add([
                'field' => 'dice_roll_id',
                'label' => __('entities.dice_roll'),
                'type' => 'select2',
                'route' => route('dice_rolls.find'),
                'placeholder' =>  __('dice_rolls.placeholders.dice_roll'),
                'model' => DiceRoll::class,
            ])
            ->add([
                'field' => 'diceRoll-character_id',
                'label' => __('entities.character''),
                'type' => 'select2',
                'route' => route('characters.find'),
                'placeholder' =>  __('crud.placeholders.character'),
                'model' => Character::class,
            ])
            //->isPrivate()
            //->tags()
        ;
    }
}
