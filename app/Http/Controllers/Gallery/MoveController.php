<?php

namespace App\Http\Controllers\Gallery;

use App\Http\Controllers\Controller;
use App\Http\Requests\Gallery\MoveFiles;
use App\Models\Campaign;
use App\Services\Gallery\MoveService;

class MoveController extends Controller
{
    protected MoveService $service;

    public function __construct(MoveService $service)
    {
        $this->middleware('auth');
        $this->service = $service;
    }

    public function process(Campaign $campaign, MoveFiles $request)
    {
        $this->authorize('gallery', $campaign);

        $count = $this->service
            ->campaign($campaign)
            ->files($request->get('images'))
            ->move($request->get('folder_id'));

        return response()->json(['toast' => trans_choice('gallery.move.success', $count, ['count' => $count])]);
    }

}
