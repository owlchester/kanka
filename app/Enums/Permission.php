<?php

namespace App\Enums;

enum Permission: int
{
    case View = 1;
    case Update = 2;
    case Create = 3;
    case Delete = 4;
    case Posts = 5;
    case Permissions = 6;

    case Manage = 10;
    case Dashboards = 11;
    case Members = 12;
    case Gallery = 13;
    case Campaign = 14;

    case GalleryBrowse = 15;
    case GalleryUpload = 16;

    case Templates = 17;
    case PostTemplates = 18;
    case Bookmarks = 19;
}
