<?php

namespace App\Http\Controllers;

use App\Exceptions\TranslatableException;
use App\Http\Requests\BulkRequest;
use App\Models\Campaign;
use App\Services\BulkService;
use App\Services\Entity\TypeService;
use App\Traits\BulkControllerTrait;
use App\Traits\CampaignAware;
use Exception;
use Illuminate\Support\Str;

class BulkController extends Controller
{
    use BulkControllerTrait;
    use CampaignAware;

    protected BulkService $bulkService;

    protected TypeService $typeService;

    protected BulkRequest $request;

    protected array $routeParams = [];

    /**  */
    protected null|string $entity = null;

    public function __construct(BulkService $bulkService, TypeService $typeService)
    {
        $this->bulkService = $bulkService;
        $this->typeService = $typeService;
    }

    /**
     */
    public function index(BulkRequest $request, Campaign $campaign)
    {
        dd('what');
        $this->request = $request;
        $this->entity = $request->get('entity');
        $models = $request->get('model', []);
        $action = $request->get('datagrid-action');
        $page = $request->get('page');
        if (!empty($page)) {
            $this->routeParams = ['page' => $page];
        }

        $this->bulkService
            ->entity($this->entity)
            ->entities($models);

        try {
            if ($action === 'batch') {
                return $this->batch();
            }
        } catch (TranslatableException $e) {
            if (app()->isLocal()) {
                throw $e;
            }
            return redirect()
                ->back()
                ->with('error', __('crud.bulk.errors.general', ['hint' => $e->getTranslatedMessage()]));
        } catch (Exception $e) {
            if (app()->isLocal()) {
                throw $e;
            }
            return redirect()
                ->back()
                ->with('error', __('crud.bulk.errors.general', ['hint' => $e->getMessage()]));
        }

        return redirect()
            ->back();
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     * @throws Exception
     */
    protected function batch()
    {
        $classes = config('entities.classes-plural');
        $entityObj = new $classes[$this->entity]();
        if ($this->entity !== 'relations') {
            $this->bulkService->entity(Str::singular($this->entity));
        }

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

    protected function models(): array
    {
        return explode(',', $this->request->get('models'));
    }
}
