<?php

namespace App\Http\Controllers;

use App\Http\Requests\BulkRequest;
use App\Services\BulkService;
use Illuminate\Http\Request;

class BulkController extends Controller
{
    /**
     * @var BulkService
     */
    protected $bulkService;

    /**
     * BulkController constructor.
     * @param BulkService $bulkService
     */
    public function __construct(BulkService $bulkService)
    {
        $this->bulkService = $bulkService;
    }

    /**
     * @param BulkRequest $request
     */
    public function process(BulkRequest $request)
    {
        $entity = $request->get('entity');
        $models = $request->get('model');
        if ($request->has('delete')) {
            $count = $this->bulkService->delete($entity, $models);
            return redirect()->route($entity . '.index')
                ->with('success', trans_choice('crud.destroy_many.success', $count, ['count' => $count]));
        } elseif ($request->has('private')) {
            $count = $this->bulkService->makePrivate($entity, $models);
            return redirect()->route($entity . '.index')
                ->with('success', trans_choice('crud.bulk.success.private', $count, ['count' => $count]));
        } elseif ($request->has('public')) {
            $count = $this->bulkService->makePublic($entity, $models);
            return redirect()->route($entity . '.index')
                ->with('success', trans_choice('crud.bulk.success.public', $count, ['count' => $count]));
        }

        return redirect()->route($entity . '.index');
    }
}
