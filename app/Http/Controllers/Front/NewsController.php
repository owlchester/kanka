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
        $recent = Release::published()->orderBy('created_at', 'DESC')->take(5)->get();
        return view('front.news.index', compact('models', 'recent'));
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
        $recent = Release::published()->where('id', '!=', $post->id)->orderBy('created_at', 'DESC')->take(5)->get();
        return view('front.news.show', ['model' => $post, 'recent' => $recent]);
    }
}
