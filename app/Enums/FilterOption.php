<?php

namespace App\Enums;

enum FilterOption: string
{
    case INCLUDE = 'include';
    case EXCLUDE = 'exclude';
    case NONE = 'none';
    case CHILDREN = 'children';
}
