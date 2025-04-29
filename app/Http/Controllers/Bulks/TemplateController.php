<?php

namespace App\Http\Controllers\Bulks;

use App\Http\Controllers\Controller;
use App\Http\Requests\Bulks\Template;
use App\Models\Campaign;
use App\Models\EntityType;
use App\Services\AttributeService;
use App\Services\BulkService;
use Illuminate\Http\Request;
use App\Http\Requests\Bulks\Template;

class TemplateController extends Controller
{
    public function __construct(
        protected BulkService $bulkService,
        protected AttributeService $attributeService,
    ) {
        $this->middleware('auth');
    }

    public function index(Request $request, Campaign $campaign, EntityType $entityType)
    {
        $templates = $this->attributeService
            ->campaign($campaign)
            ->templateList();
        $entities = $request->get('entities');

        return view('cruds.datagrids.bulks.modals._templates')
            ->with('campaign', $campaign)
            ->with('templates', $templates)
            ->with('entityType', $entityType)
            ->with('entities', $entities);
    }

    public function apply(Template $request, Campaign $campaign, EntityType $entityType)
    {
        $models = explode(',', $request->get('models'));
        if ($request->has('entities')) {
            $models = $request->get('entities');
        }
        $target = $request->get('template_id');

        $count = $this->bulkService
            ->entityType($entityType)
            ->entities($models)
            ->templates($target);

        return redirect()
            ->back()
            ->with('success', trans_choice('crud.bulk.success.templates', $count, ['count' => $count]));
    }
}
