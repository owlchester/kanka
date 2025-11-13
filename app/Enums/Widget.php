<?php

namespace App\Enums;

enum Widget: string
{
    case Preview = 'preview';
    case Recent = 'recent';
    case Calendar = 'calendar';
    case Unmentioned = 'unmentioned';
    case Random = 'random';
    case Header = 'header';
    case Campaign = 'campaign';
    case Welcome = 'welcome';
    case Help = 'help';

    public function isHeader(): bool
    {
        return match ($this) {
            Widget::Header => true,
            default => false,
        };
    }
}
