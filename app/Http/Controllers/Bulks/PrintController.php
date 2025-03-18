<?php

namespace App\Http\Controllers\Bulks;

use App\Facades\Mentions;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\EntityType;
use App\Services\BulkService;
use Illuminate\Http\Request;

class PrintController extends Controller
{
    public function __construct(
        protected BulkService $bulkService
    ) {
        $this->middleware('auth');
    }

    public function index(Request $request, Campaign $campaign, EntityType $entityType)
    {
        Mentions::campaign($campaign);
        $entities = $this->bulkService
            ->campaign($campaign)
            ->entityType($entityType)
            ->entities($request->get('model'))
            ->export();

        return view('entities.pages.print.print-bulk')
            ->with('campaign', $campaign)
            ->with('entities', $entities)
            ->with('printing', true)
        ;
    }
}
