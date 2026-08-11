<?php

namespace App\Enums;

enum EmailTrigger: string
{
    case Welcome = 'welcome';
    case Nudge = 'nudge';
    case Momentum = 'momentum';
    case Connections = 'connections';

    public function label(): string
    {
        return match ($this) {
            self::Welcome => 'Welcome',
            self::Nudge => 'Nudge',
            self::Momentum => 'Momentum',
            self::Connections => 'Connections',
        };
    }

    /**
     * @return array<string, string>
     */
    public static function options(): array
    {
        $options = [];

        foreach (self::cases() as $trigger) {
            $options[$trigger->value] = $trigger->label();
        }

        return $options;
    }
}
