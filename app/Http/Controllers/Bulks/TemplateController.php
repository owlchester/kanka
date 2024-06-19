<?php

namespace App\Http\Controllers\Bulks;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\EntityType;
use App\Services\AttributeService;
use App\Services\BulkService;

class TemplateController extends Controller
{
    protected BulkService $bulkService;
    protected AttributeService $attributeService;

    public function __construct(
        BulkService $bulkService,
        AttributeService $attributeService,
    ) {
        $this->bulkService = $bulkService;
        $this->attributeService = $attributeService;

        $this->middleware('auth');
    }

    public function index(Campaign $campaign, EntityType $entityType)
    {
        $templates = $this->attributeService
            ->campaign($campaign)
            ->templateList();

        return view('cruds.datagrids.bulks.modals._templates')
            ->with('campaign', $campaign)
            ->with('templates', $templates)
            ->with('entityType', $entityType)
        ;
    }

    public function apply(Campaign $campaign, EntityType $entityType)
    {
        $models = explode(',', request()->get('models'));
        $target = request()->get('template_id');

        $count = $this->bulkService
            ->entity($entityType->code)
            ->entities($models)
            ->templates($target);

        return redirect()
            ->back()
            ->with('success', trans_choice('crud.bulk.success.templates', $count, ['count' => $count]));
    }
}
