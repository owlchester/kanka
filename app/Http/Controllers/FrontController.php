<?php

namespace App\Http\Controllers;

use App\Models\Faq;

class FrontController extends Controller
{
    public function about()
    {
        return view('front.about');
    }
    public function tos()
    {
        return view('front.tos');
    }
    public function help()
    {
        return view('front.help');
    }
    public function faq()
    {
        $faqs = Faq::locale(app()->getLocale())->visible()->ordered()->get();
        return view('front.faq')->with('faqs', $faqs);
    }
}
