<?php

namespace App\Http\Controllers\Bookmarks;

use App\Http\Controllers\Controller;
use App\Models\Bookmark;
use App\Models\Campaign;

class RandomController extends Controller
{
    public function index(Campaign $campaign, Bookmark $bookmark)
    {
        $route = $bookmark->randomEntity();

        if (empty($route)) {
            return redirect()
                ->route('dashboard', $campaign)
                ->with(
                    'error',
                    __('bookmarks.random_no_entity')
                );
        }

        return redirect()->to($route);
    }
}
