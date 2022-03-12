<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect()->route('front.faqs.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Faq  $post
     * @return \Illuminate\Http\Response
     */
    public function show($key, $slug = '')
    {
        return redirect()->route('front.faqs.index');
    }
}
