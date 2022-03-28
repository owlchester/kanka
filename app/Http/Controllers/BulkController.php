<?php

namespace App\Http\Controllers;

use App\Exceptions\TranslatableException;
use App\Facades\CampaignLocalization;
use App\Http\Requests\BulkRequest;
use App\Services\AttributeService;
use App\Services\BulkService;
use App\Services\EntityService;
use App\Traits\BulkControllerTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BulkController extends Controller
{
    use BulkControllerTrait;

    /**
     * @var BulkService
     */
    protected $bulkService;

    /**
     * @var EntityService
     */
    protected $entityService;

    /** @var BulkRequest */
    protected $request;

    protected $routeParams = [];
    protected $entity = null;

    /**
     * BulkController constructor.
     * @param BulkService $bulkService
     */
    public function __construct(BulkService $bulkService, EntityService $entityService)
    {
        $this->bulkService = $bulkService;
        $this->entityService = $entityService;
    }

    /**
     * @param BulkRequest $request
     */
    public function process(BulkRequest $request)
    {
        $this->request = $request;
        $this->entity = $request->get('entity');
        $models = $request->get('model', []);
        $action = $request->get('datagrid-action');
        $page = $request->get('page');
        if (!empty($page)) {
            $this->routeParams = ['page' => $page];
        }

        $this->bulkService->entity($this->entity)->entities($models);

        try {
            if ($action === 'delete') {
                return $this->delete();
            } elseif ($action === 'export') {
                return $this->export();
            } elseif ($action === 'print') {
                return $this->print();
            } elseif ($action === 'permissions') {
                return $this->permissions();
            } elseif ($action === 'copy-campaign') {
                return $this->copyToCampaign();
            } elseif ($action === 'transform') {
                return $this->transform();
            } elseif ($action === 'templates') {
                return $this->templates();
            } elseif ($action === 'batch') {
                return $this->batch();
            }
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', __('crud.bulk.errors.general', ['hint' => $e->getMessage()]));
        }

        return redirect()
            ->back();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function modal(Request $request)
    {
        if (!$request->has('view') || !in_array($request->get('view'), ['permissions', 'copy_campaign', 'templates', 'transform'])) {
            return response()->json(['error' => 'invalid view']);
        }

        $type = request()->get('type');
        $templates = [];
        $entities = null;

        if (request()->get('view') == 'templates') {
            $campaign = CampaignLocalization::getCampaign();
            /** @var AttributeService $service */
            $service = app()->make('App\Services\AttributeService');
            $templates = $service->campaign(CampaignLocalization::getCampaign())->templateList($campaign);
        }
        elseif (request()->get('view') === 'transform') {
            $entities = $this->entityService
                ->labelledEntities(true, [Str::plural($type), 'menu_links', 'relations'], true);
            $entities[''] = __('entities/transform.fields.select_one');
        }

        $campaign = CampaignLocalization::getCampaign();
        return view('cruds.datagrids.bulks.modals._' . $request->get('view'), compact(
            'campaign', 'templates', 'type', 'entities'
        ));
    }

    /**
     * @param $entity
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    protected function batch()
    {
        $entityClass = $this->entityService->getClass($this->entity);
        $entityObj = new $entityClass;
        $langFile = $this->entity === 'relations' ? 'entities/relations.bulk.success.' : 'crud.bulk.success.';
        $models = $this->models();

        $count = $this
            ->bulkService
            ->entities($models)
            ->editing($this->request->all(), $this->bulkModel($entityObj));
        $total = $this->bulkService->total();

        $key = 'editing';
        if ($count != $total) {
            $key = 'editing_partial';
        }

        return redirect()
            ->back()
            ->with('success', trans_choice($langFile . $key, $count, ['count' => $count, 'total' => $total]));
    }

    protected function transform()
    {
        $models = $this->models();
        $target = $this->request->get('target');
        $count = $this
            ->bulkService
            ->entities($models)
            ->transform($target);

        return redirect()
            ->back()
            ->with('success_raw', trans_choice('entities/transform.bulk.success', $count, ['count' => $count, 'type' => __('entities.' . $target)]));
    }

    protected function copyToCampaign()
    {
        $models = $this->models();
        $campaignId = $this->request->get('campaign');
        $campaign = Auth::user()->campaigns()->where('campaign_id', $campaignId)->first();

        $count = $this
            ->bulkService
            ->entities($models)
            ->copyToCampaign($campaign->id);

        return redirect()
            ->back()
            ->with('success_raw', trans_choice('crud.bulk.success.copy_to_campaign', $count, ['count' => $count, 'campaign' => $campaign->name]));
    }

    protected function permissions()
    {
        $models = $this->models();
        $count = $this
            ->bulkService
            ->entities($models)
            ->permissions($this->request->only('user', 'role'), $this->request->has('permission-override'));

        return redirect()
            ->back()
            ->with('success', trans_choice('crud.bulk.success.permissions', $count, ['count' => $count]));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    protected function print()
    {
        $entities = $this->bulkService->export();

        return view('entities.pages.print.print-bulk')
            ->with('entities', $entities)
            ->with('printing', true)
        ;
    }

    protected function delete()
    {
        $models = $this->models();
        $count = $this->bulkService->entities($models)->delete();
        $key = $this->entity === 'relations' ? 'entities/relations.bulk.delete' : 'crud.destroy_many.success';

        return redirect()
            ->back()
            ->with('success', trans_choice($key, $count, ['count' => $count]));
    }

    protected function templates()
    {
        $models = $this->models();
        $count = $this->bulkService
            ->entities($models)
            ->templates($this->request->get('template_id'));

        return redirect()
            ->back()
            ->with('success', trans_choice('crud.bulk.success.templates', $count, ['count' => $count]));
    }

    protected function export()
    {
        $pdf = \App::make('dompdf.wrapper');
        $entities = $this->bulkService->export();
        $entityType = $this->entity;
        $name = $this->entity;

        return $pdf
            ->loadView('cruds.export', compact('entityType', 'entities', 'name'))
            ->download('kanka ' . $this->entity . ' export.pdf');
    }

    /**
     * @return string
     */
    protected function indexRoute(): string
    {
        $subroute = 'index';
        if (auth()->user()->defaultNested and \Illuminate\Support\Facades\Route::has($this->entity . '.tree')) {
            $subroute = 'tree';
        }
        return $this->entity . '.' . $subroute;
    }

    protected function models(): array
    {
        return explode(',', $this->request->get('models'));
    }
}
