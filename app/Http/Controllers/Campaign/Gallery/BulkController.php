<?php

namespace App\Http\Controllers\Campaign\Gallery;

use App\Http\Controllers\Controller;
use App\Http\Requests\GalleryBulkDelete;
use App\Models\Campaign;
use App\Services\Campaign\Gallery\BulkService;
use Illuminate\Http\Client\Request;

class BulkController extends Controller
{
    protected BulkService $bulkService;

    public function __construct(BulkService $bulkService)
    {
        $this->bulkService = $bulkService;
    }

    public function delete(GalleryBulkDelete $request, Campaign $campaign)
    {
        $this->authorize('gallery', $campaign);

        $count = $this->bulkService
            ->campaign($campaign)
            ->files($request->get('file', []))
            ->delete();
        return response()->json([
            'success' => true,
            'toast' => trans_choice('campaigns/gallery.bulk.destroy.success', $count, ['count' => $count]),
            'deleted' => $count,
        ]);
    }
}
