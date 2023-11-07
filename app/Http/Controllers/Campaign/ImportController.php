<?php

namespace App\Http\Controllers\Campaign;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Services\Campaign\Imports\PrepareService;

class ImportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Campaign $campaign)
    {
        $this->authorize('setting', $campaign);

        return view('campaigns.import.index', compact('campaign'));
    }
}
