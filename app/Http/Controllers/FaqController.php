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
        $faqs = Faq::locale(app()->getLocale())->visible()->ordered()->get();
        return view('faqs.index')->with('faqs', $faqs);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Faq  $post
     * @return \Illuminate\Http\Response
     */
    public function show($key, $slug = '')
    {
        if (!Lang::has('faq.' . $key)) {
            return redirect()->route('faq.index');
        }

        return view('faqs.show', ['key' => $key]);
    }
}
