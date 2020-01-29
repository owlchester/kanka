<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Release;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $models = Release::with(['category'])
            ->published()
            ->orderBy('created_at', 'DESC')
            ->paginate();
        return view('front.news.index', compact('models'));
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Release  $post
     * @return \Illuminate\Http\Response
     */
    public function show($id, $slug = '')
    {
        $post = Release::where('id', $id)->firstOrFail();
        return view('front.news.show', ['model' => $post]);
    }
}
