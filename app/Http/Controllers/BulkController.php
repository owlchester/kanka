<?php

namespace App\Http\Controllers;

use App\Exceptions\TranslatableException;
use App\Http\Requests\BulkRequest;
use App\Models\Campaign;
use App\Models\EntityType;
use App\Services\BulkService;
use App\Traits\BulkControllerTrait;
use App\Traits\CampaignAware;
use App\Traits\EntityTypeAware;
use Exception;

class BulkController extends Controller
{
    use BulkControllerTrait;
    use CampaignAware;
    use EntityTypeAware;

    protected BulkRequest $request;

    protected array $routeParams = [];

    protected ?string $entity = null;

    public function __construct(protected BulkService $bulkService) {}

    public function index(BulkRequest $request, Campaign $campaign)
    {
        $this->request = $request;
        $this->entity = $request->get('entity');
        $models = $request->get('model', []);
        $action = $request->get('datagrid-action');
        $page = $request->get('page');
        if (! empty($page)) {
            $this->routeParams = ['page' => $page];
        }

        $this->bulkService
            ->entities($models);

        if ($request->filled('entity_type')) {
            $this->entityType = EntityType::find($request->get('entity_type'));
        }

        try {
            if ($action === 'batch') {
                return $this->batch();
            }
        } catch (TranslatableException $e) {
            if (config('app.debug')) {
                throw $e;
            }

            return redirect()
                ->back()
                ->with('error', __('crud.bulk.errors.general', ['hint' => $e->getTranslatedMessage()]));
        } catch (Exception $e) {
            if (config('app.debug')) {
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
     *
     * @throws Exception
     */
    protected function batch()
    {
        if (isset($this->entityType)) {
            $entityObj = $this->entityType->getClass();
            $this->bulkService->entityType($this->entityType);
        } else {
            $classes = config('entities.classes-plural');
            $entityObj = new $classes[$this->entity];
        }

        $langFile = $this->entity === 'relations' ? 'entities/relations.bulk.success.' : 'crud.bulk.success.';
        $models = $this->models();

        $count = $this
            ->bulkService
            ->entities($models)
            ->user($this->request->user())
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
