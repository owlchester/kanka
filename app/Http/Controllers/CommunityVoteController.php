<?php

namespace App\Http\Controllers;

use App\Models\CommunityVote;
use Illuminate\Http\Request;

class CommunityVoteController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $voting = CommunityVote::voting()->first();

        $models = CommunityVote::published()
            ->orderBy('visible_at', 'DESC')
            ->paginate();
        return view('community-votes.index', compact('voting', 'models'));
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
     * @param $id
     * @param string $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show($id, $slug = '')
    {
        $vote = CommunityVote::where('id', $id)->firstOrFail();
        $this->authorize('show', $vote);

        return view('community-votes.show', ['model' => $vote]);
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
