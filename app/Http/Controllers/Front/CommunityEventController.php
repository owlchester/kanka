<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\CommunityEvent;
use Illuminate\Http\Request;

class CommunityEventController extends Controller
{
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

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

    }

    /**
     * @param int $id
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

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $post)
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($post)
    {

    }
}
