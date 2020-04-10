<?php


namespace App\Models;


use App\Facades\Mentions;
use App\Models\Concerns\SimpleSortableTrait;
use App\Traits\VisibleTrait;

/**
 * Class QuestElement
 * @package App\Models
 *
 * @property Quest $quest
 */
abstract class QuestElement extends MiscModel
{
    /**
     * Traits
     */
    use VisibleTrait, SimpleSortableTrait;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function quest()
    {
        return $this->belongsTo('App\Models\Quest', 'quest_id');
    }

    /**
     * @return string
     */
    public function colourClass(): string
    {
        if (empty($this->colour)) {
            return 'bg-none';
        }

        return $this->colour == 'grey' ? 'bg-gray' : 'bg-' . $this->colour;
    }

    /**
     * @return mixed
     */
    public function entry()
    {
        return Mentions::map($this, 'description');
    }

    /**
     * @return mixed
     */
    public function getEntryForEditionAttribute()
    {
        $text = Mentions::edit($this, 'description');
        return $text;
    }
}
