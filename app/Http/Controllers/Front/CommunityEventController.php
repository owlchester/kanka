<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\CommunityEvent;
use App\Services\CommunityVoteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommunityEventController extends Controller
{
    /**
     * @var CommunityEventService
     */
    protected $service;

    /**
     * CommunityEventController constructor.
     * @param CommunityEventService $service
     */
    public function __construct(CommunityVoteService $service)
    {
        //$this->service = $service;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $ongoing = CommunityEvent::ongoing()->get();

        $finished = CommunityEvent::finished()
            ->orderBy('end_at', 'DESC')
            ->paginate();

        return view('front.community-events.index', compact('ongoing', 'finished'));
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
        $event = CommunityEvent::where('uuid', $id)->firstOrFail();

        return view('front.community-events.show', [
            'model' => $event,
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

    public function event(Request $request, CommunityEvent $communityEvent)
    {
        $this->middleware(['auth', 'identity']);
        $this->authorize('event', $communityEvent);

        $data = $this->service->cast(
            $communityEvent,
            Auth::user(),
            $request->post('event', null)
        );

        return response()->json([
            'success' => true,
            'data' => $data
        ]);

    }
}
