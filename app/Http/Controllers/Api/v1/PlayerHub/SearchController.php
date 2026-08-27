<?php

namespace App\Http\Controllers\Api\v1\PlayerHub;

use App\Http\Controllers\Api\v1\ApiController;
use Illuminate\Http\Request;

class SearchController extends ApiController
{
    public function index(Request $request)
    {
        $user = $request->user();

    }
}
