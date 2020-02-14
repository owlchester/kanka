<?php

namespace App\Datagrids\Filters;

use App\Models\Character;
use App\Models\DiceRoll;

class DiceRollResultFilter extends DatagridFilter
{
    /**
     * CharacterFilter constructor.
     */
    public function __construct()
    {
        $this
            ->add([
                'field' => 'dice_roll_id',
                'label' => trans('crud.fields.dice_roll'),
                'type' => 'select2',
                'route' => route('dice_rolls.find'),
                'placeholder' =>  trans('dice_rolls.placeholders.dice_roll'),
                'model' => DiceRoll::class,
            ])
            ->add([
                'field' => 'diceRoll-character_id',
                'label' => trans('crud.fields.character'),
                'type' => 'select2',
                'route' => route('characters.find'),
                'placeholder' =>  trans('crud.placeholders.character'),
                'model' => Character::class,
            ])
            //->isPrivate()
            //->tags()
        ;
    }
}
