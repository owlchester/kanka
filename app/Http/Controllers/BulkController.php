<?php

namespace App\Http\Controllers;

use App\Exceptions\TranslatableException;
use App\Facades\CampaignLocalization;
use App\Http\Requests\BulkRequest;
use App\Services\BulkService;
use App\Services\EntityService;
use App\Traits\BulkControllerTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $entity = $request->get('entity');
        $models = $request->get('model', []);
        $action = $request->get('datagrid-action');
        $page = $request->get('page');
        $routeParams = !empty($page) ? ['page' => $page] : [];

        $subroute = 'index';
        if (auth()->user()->defaultNested and \Illuminate\Support\Facades\Route::has($entity . '.tree')) {
            $subroute = 'tree';
        }

        $this->bulkService->entity($entity)->entities($models);

        try {
            if ($action === 'delete') {
                $models = explode(',', $request->get('models'));
                $count = $this->bulkService->entities($models)->delete();
                return redirect()->route($entity . '.' . $subroute, $routeParams)
                    ->with('success', trans_choice('crud.destroy_many.success', $count, ['count' => $count]));
            } elseif ($action === 'export') {
                $pdf = \App::make('dompdf.wrapper');
                $entities = $this->bulkService->export();
                $name = $entity;
                return $pdf
                    ->loadView('cruds.export', compact('entity', 'entities', 'name'))
                    ->download('kanka ' . $entity . ' export.pdf');
            } elseif ($action === 'permissions') {
                $models = explode(',', $request->get('models'));
                $count = $this
                    ->bulkService
                    ->entities($models)
                    ->permissions($request->only('user', 'role'), $request->has('permission-override'));
                return redirect()
                    ->route($entity . '.' . $subroute, $routeParams)
                    ->with('success', trans_choice('crud.bulk.success.permissions', $count, ['count' => $count]));
            } elseif ($action === 'copy-campaign') {
                $models = explode(',', $request->get('models'));
                $campaignId = $request->get('campaign');
                $campaign = Auth::user()->campaigns()->where('campaign_id', $campaignId)->first();

                $count = $this
                    ->bulkService
                    ->entities($models)
                    ->copyToCampaign($campaign->id);
                return redirect()
                    ->route($entity . '.' . $subroute, $routeParams)
                    ->with('success', trans_choice('crud.bulk.success.copy_to_campaign', $count, ['count' => $count, 'campaign' => $campaign->name]));
            } elseif ($action === 'batch') {
                $entityClass = $this->entityService->getClass($entity);
                $entityObj = new $entityClass;
                $count = $this
                    ->bulkService
                    ->entities(explode(',', $request->get('models')))
                    ->editing($request->all(), $this->bulkModel($entityObj));
                return redirect()
                    ->route($entity . '.' . $subroute, $routeParams)
                    ->with('success', trans_choice('crud.bulk.success.editing', $count, ['count' => $count]));
            }
        } catch (\Exception $e) {
            return redirect()
                ->route($entity . '.' . $subroute, $routeParams)
                ->with('error', __('crud.bulk.errors.general', ['hint' => $e->getMessage()]));
        }

        return redirect()->route($entity . '.' . $subroute, $routeParams);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function modal(Request $request)
    {
        if (!$request->has('view') || !in_array($request->get('view'), ['permissions', 'copy_campaign'])) {
            return response()->json(['error' => 'invalid view']);
        }

        $campaign = CampaignLocalization::getCampaign();
        return view('cruds.datagrids.bulks.modals._' . $request->get('view'), compact(
            'campaign'
        ));
    }
}
