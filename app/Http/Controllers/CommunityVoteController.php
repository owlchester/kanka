<?php

namespace App\Http\Controllers;

use App\Models\CommunityVote;
use App\Services\CommunityVoteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommunityVoteController extends Controller
{
    /**
     * @var CommunityVoteService
     */
    protected $service;

    /**
     * CommunityVoteController constructor.
     * @param CommunityVoteService $service
     */
    public function __construct(CommunityVoteService $service)
    {
        $this->service = $service;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $voting = CommunityVote::voting()->first();

        $models = CommunityVote::published()
            ->orderBy('visible_at', 'DESC')
            ->paginate();

        $recent = CommunityVote::recent()->get();
        return view('community-votes.index', compact('voting', 'models', 'recent'));
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
        $this->middleware(['identity']);
        $vote = CommunityVote::where('id', $id)->firstOrFail();

        $recent = CommunityVote::recent()->get();

        return view('community-votes.show', [
            'model' => $vote,
            'recent' => $recent
        ]);
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

    public function vote(Request $request, CommunityVote $communityVote)
    {
        $this->middleware(['auth', 'identity']);
        $this->authorize('vote', $communityVote);

        $data = $this->service->cast(
            $communityVote,
            Auth::user(),
            $request->post('vote', null)
        );

        return response()->json([
            'success' => true,
            'data' => $data
        ]);

    }
}
