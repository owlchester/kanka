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
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
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
     */
    public function edit($post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($post)
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
