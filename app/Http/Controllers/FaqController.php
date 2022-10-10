<?php

namespace App\Http\Controllers;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return redirect()->route('front.faqs.index');
    }

    /**
     * Display the specified resource.
     */
    public function show($key, $slug = '')
    {
        return redirect()->route('front.faqs.index');
    }
}
