<?php


namespace App\Http\Controllers\Front;


use App\Http\Controllers\Controller;
use Carbon\Carbon;

class KoinkController extends Controller
{
    public function index()
    {
        return view('front.koinks');
    }
}
