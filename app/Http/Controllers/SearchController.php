<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('campaign.member');
    }

    /**
     * Old deprecated search page
     */
    public function search(Request $request, Campaign $campaign): RedirectResponse
    {
        $term = $request->get('q');
        if (empty($term) || !is_string($term)) {
            return redirect()->route('search.fulltext', [$campaign]);
        }
        $term = trim($term);
        return redirect()->route('search.fulltext', [$campaign, 'term' => trim($term)]);
    }
}
