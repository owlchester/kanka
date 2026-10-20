<?php

namespace App\Enums;

enum EmailAudience: string
{
    case Gm = 'gm';
    case Player = 'player';

    public function label(): string
    {
        return match ($this) {
            self::Gm => 'GM',
            self::Player => 'Player',
        };
    }

    /**
     * @return array<string, string>
     */
    public static function options(): array
    {
        $options = [];

        foreach (self::cases() as $audience) {
            $options[$audience->value] = $audience->label();
        }

        return $options;
    }
}
