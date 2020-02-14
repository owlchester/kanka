<?php

namespace App\Http\Controllers;

use App\Models\Release;
use Illuminate\Http\Request;

class ReleaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect(route('front.news'), 301);
        $models = Release::with(['category'])
            ->published()
            ->orderBy('created_at', 'DESC')
            ->paginate();
        return view('releases.index', compact('models'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        return redirect(route('front.news.show', $post->getSlug()), 301);
        return view('releases.show', ['model' => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Release  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Release $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Release  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Release $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Release  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Release $post)
    {
        //
    }
}
