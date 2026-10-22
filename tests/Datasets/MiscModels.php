<?php

use App\Models\Ability;
use App\Models\AttributeTemplate;
use App\Models\Calendar;
use App\Models\Character;
use App\Models\Conversation;
use App\Models\Creature;
use App\Models\DiceRoll;
use App\Models\Event;
use App\Models\Family;
use App\Models\Item;
use App\Models\Journal;
use App\Models\Location;
use App\Models\Map;
use App\Models\Note;
use App\Models\Organisation;
use App\Models\Quest;
use App\Models\Race;
use App\Models\Tag;
use App\Models\Timeline;
use App\Models\Whiteboard;

dataset('misc models', [
    'ability' => Ability::class,
    'attribute template' => AttributeTemplate::class,
    'calendar' => Calendar::class,
    'character' => Character::class,
    'conversation' => Conversation::class,
    'creature' => Creature::class,
    'dice roll' => DiceRoll::class,
    'event' => Event::class,
    'family' => Family::class,
    'item' => Item::class,
    'journal' => Journal::class,
    'location' => Location::class,
    'map' => Map::class,
    'note' => Note::class,
    'organisation' => Organisation::class,
    'quest' => Quest::class,
    'race' => Race::class,
    'tag' => Tag::class,
    'timeline' => Timeline::class,
    'whiteboard' => Whiteboard::class,
]);
