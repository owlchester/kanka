<?php

namespace App\Enums;

enum Widget: String
{
    case Preview = 'preview';
    case Recent = 'recent';
    case Calendar = 'calendar';
    case UNMENTIONED = 'unmentioned';
    case Random = 'random';
    case Header = 'header';
    case Campaign = 'campaign';
    case Welcome = 'welcome';

    public static function visibile(): array
    {
        return [
            Widget::Recent,
            Widget::Random,
            Widget::Header,
            Widget::Welcome,
        ];
    }
}
