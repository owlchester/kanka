<?php

namespace App\Http\Controllers\QuickLink;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\MenuLink;

class RandomController extends Controller
{
    public function index(Campaign $campaign, MenuLink $menuLink)
    {
        $route = $menuLink->randomEntity();

        if (empty($route)) {
            return redirect()
                ->route('dashboard', $campaign)
                ->with(
                    'error',
                    __('menu_links.random_no_entity')
                );
        }
        return redirect()->to($route);
    }
}
