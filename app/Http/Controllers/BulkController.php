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

        $this->bulkService->entity($entity)->entities($models);

        if ($request->has('delete')) {
            $count = $this->bulkService->delete();
            return redirect()->route($entity . '.' . $subroute)
                ->with('success', trans_choice('crud.destroy_many.success', $count, ['count' => $count]));
        } elseif ($request->has('export')) {
            $pdf = \App::make('dompdf.wrapper');
            $entities = $this->bulkService->export();
            $name = $entity;
            return $pdf
                ->loadView('cruds.export', compact('entity', 'entities', 'name'))
                ->download('kanka ' . $entity . ' export.pdf');
        } elseif ($request->has('private')) {
            $count = $this->bulkService->makePrivate();
            return redirect()->route($entity . '.' . $subroute)
                ->with('success', trans_choice('crud.bulk.success.private', $count, ['count' => $count]));
        } elseif ($request->has('public')) {
            $count = $this->bulkService->makePublic();
            return redirect()->route($entity . '.' . $subroute)
                ->with('success', trans_choice('crud.bulk.success.public', $count, ['count' => $count]));
        } elseif ($request->has('bulk-permissions')) {
            $count = $this->bulkService->permissions($request->only('user', 'role'), $request->has('permission-override'));
            return redirect()->route($entity . '.' . $subroute)
                ->with('success', trans_choice('crud.bulk.success.permissions', $count, ['count' => $count]));
        }

        return redirect()->route($entity . '.' . $subroute);
    }
}
