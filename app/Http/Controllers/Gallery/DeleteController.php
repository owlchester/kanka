<?php

namespace App\Http\Controllers\Gallery;

use App\Http\Controllers\Controller;
use App\Http\Requests\Gallery\DeleteImages;
use App\Models\Campaign;
use App\Services\Gallery\DeleteService;

class DeleteController extends Controller
{
    protected DeleteService $service;

    public function __construct(DeleteService $service)
    {
        $this->middleware('auth');
        $this->service = $service;
    }

    public function destroy(Campaign $campaign, DeleteImages $request)
    {
        $this->authorize('gallery', $campaign);

        $count = $this->service
            ->campaign($campaign)
            ->delete($request->get('images'));

        return response()->json(['toast' => trans_choice('gallery.delete.success', $count, ['count' => $count])]);
    }
}
