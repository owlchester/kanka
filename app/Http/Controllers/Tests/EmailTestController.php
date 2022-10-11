<?php

namespace App\Http\Controllers\Tests;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EmailTestController extends Controller
{
    public function index(Request $request)
    {
        $view = $request->get('email', 'welcome.html');
        return view('emails.' . $view)
            ->with('user', auth()->user())
            ->with('date', Carbon::now()->addDays(60))
        ;
    }
}
