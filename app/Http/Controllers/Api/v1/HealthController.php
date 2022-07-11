<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;

class HealthController extends Controller
{
    public function index()
    {
        return response()->json(['success' => true]);
    }
}
