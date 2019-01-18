<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;

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
    public function show($id, $slug = '')
    {
        $post = Faq::where('id', $id)->firstOrFail();
        return view('faqs.show', ['model' => $post]);
    }
}
