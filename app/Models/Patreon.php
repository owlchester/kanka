<?php

namespace App\Models;

class Patreon
{
    public const PLEDGE_KOBOLD = 'Kobold';
    public const PLEDGE_GOBLIN = 'Goblin';
    public const PLEDGE_OWLBEAR = 'Owlbear';
    public const PLEDGE_WYVERN = 'Wyvern';
    public const PLEDGE_ELEMENTAL = 'Elemental';

    /**
     * @return array
     */
    public static function pledges(): array
    {
        return [
            self::PLEDGE_KOBOLD => self::PLEDGE_KOBOLD,
            self::PLEDGE_GOBLIN => self::PLEDGE_GOBLIN,
            self::PLEDGE_OWLBEAR => self::PLEDGE_OWLBEAR,
            self::PLEDGE_WYVERN => self::PLEDGE_WYVERN,
            self::PLEDGE_ELEMENTAL => self::PLEDGE_ELEMENTAL,
        ];
    }
}
