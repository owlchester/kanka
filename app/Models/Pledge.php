<?php

namespace App\Models;

class Pledge
{
    public const string KOBOLD = 'Kobold';
    public const string GOBLIN = 'Goblin';
    public const string OWLBEAR = 'Owlbear';
    public const string WYVERN = 'Wyvern';
    public const string ELEMENTAL = 'Elemental';

    /** @var string Role name for subscribers. For legacy reasons, called Patreon. */
    public const string ROLE = 'patreon';
}
