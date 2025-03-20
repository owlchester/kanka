<?php

namespace App\Services;

use App\Http\Requests\ReorderBookmarks;
use App\Models\Bookmark;

class BookmarkService
{
    public function reorder(ReorderBookmarks $request): bool
    {
        $ids = $request->get('bookmark');
        if (empty($ids)) {
            return false;
        }

        $position = 1;
        foreach ($ids as $id) {
            /** @var ?Bookmark $link */
            $link = Bookmark::where('id', $id)->first();
            if (empty($link)) {
                continue;
            }

            $link->position = $position;
            $link->saveQuietly();
            $position++;
        }

        return true;
    }
}
