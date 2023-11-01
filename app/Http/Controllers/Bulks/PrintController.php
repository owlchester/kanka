<?php

namespace App\Http\Controllers\Bulks;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\EntityType;
use App\Services\BulkService;
use App\Services\Entity\TypeService;

class PrintController extends Controller
{
    protected BulkService $bulkService;
    protected TypeService $typeService;

    public function __construct(
        BulkService $bulkService,
        TypeService $typeService,
    ) {
        $this->bulkService = $bulkService;
        $this->typeService = $typeService;

        $this->middleware('auth');
        $this->middleware('campaign.member');
    }

    public function index(Campaign $campaign, EntityType $entityType)
    {
        $entities = $this->bulkService
            ->campaign($campaign)
            ->entity($entityType->code)
            ->entities(request()->get('model'))
            ->export();

        return view('entities.pages.print.print-bulk')
            ->with('campaign', $campaign)
            ->with('entities', $entities)
            ->with('printing', true)
        ;
    }
}
