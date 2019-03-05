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
        $subroute = 'index';
        if (auth()->user()->defaultNested and \Illuminate\Support\Facades\Route::has($entity . '.tree')) {
            $subroute = 'tree';
        }

        if ($request->has('delete')) {
            $count = $this->bulkService->delete($entity, $models);
            return redirect()->route($entity . '.' . $subroute)
                ->with('success', trans_choice('crud.destroy_many.success', $count, ['count' => $count]));
        } elseif ($request->has('export')) {
            $pdf = \App::make('dompdf.wrapper');
            $entities = $this->bulkService->export($entity, $models);
            $name = $entity;
            return $pdf
                ->loadView('cruds.export', compact('entity', 'entities', 'name'))
                ->download('kanka ' . $entity . ' export.pdf');
        } elseif ($request->has('private')) {
            $count = $this->bulkService->makePrivate($entity, $models);
            return redirect()->route($entity . '.' . $subroute)
                ->with('success', trans_choice('crud.bulk.success.private', $count, ['count' => $count]));
        } elseif ($request->has('public')) {
            $count = $this->bulkService->makePublic($entity, $models);
            return redirect()->route($entity . '.' . $subroute)
                ->with('success', trans_choice('crud.bulk.success.public', $count, ['count' => $count]));
        }

        return redirect()->route($entity . '.' . $subroute);
    }
}
