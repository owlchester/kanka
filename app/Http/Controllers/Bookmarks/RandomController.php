<?php

namespace App\Http\Controllers\Bookmarks;

use App\Http\Controllers\Controller;
use App\Models\Bookmark;
use App\Models\Campaign;
use App\Services\Bookmarks\RandomEntityService;

class RandomController extends Controller
{
    public function __construct(protected RandomEntityService $service) {}

    public function index(Campaign $campaign, Bookmark $bookmark)
    {
        $route = $this->service->bookmark($bookmark)->url();

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
