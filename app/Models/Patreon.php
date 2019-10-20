<?php

namespace App\Models;

class Patreon
{
    const PLEDGE_KOBOLD = 'Kobold';
    const PLEDGE_GOBLIN = 'Goblin';
    const PLEDGE_OWLBEAR = 'Owlbear';
    const PLEDGE_ELEMENTAL = 'Elemental';

    /**
     * @return array
     */
    public static function pledges(): array
    {
        return [
            self::PLEDGE_KOBOLD => self::PLEDGE_KOBOLD,
            self::PLEDGE_GOBLIN => self::PLEDGE_GOBLIN,
            self::PLEDGE_OWLBEAR => self::PLEDGE_OWLBEAR,
            self::PLEDGE_ELEMENTAL => self::PLEDGE_ELEMENTAL,
        ];
    }
}