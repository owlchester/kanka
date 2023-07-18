<?php

namespace App\Models\Concerns;

use App\Facades\Api;
use App\Services\PaginationService;

trait Paginatable
{
    private int $pageSizeMax = 45;

    private int $pageSizeMinimum = 15;

    /**
     * @return mixed
     */
    public function getPerPage()
    {
        $pageSize = 15;

        if (auth()->check()) {
            $pageSize = auth()->user()->pagination;
            $pagService = app()->make(PaginationService::class);
            $this->pageSizeMax = $pagService->max();
        }

        // Currently exporting single or bulk? Rise limit to 100.
        // @phpstan-ignore-next-line
        $request = request()->route()->getAction();
        if (!empty($request['as']) && in_array($request['as'], ['entities.export', 'bulk.process'])) {
            return 100;
        }

        if (Api::isApi()) {
            $this->pageSizeMinimum = 45;
        }

        return min(max($pageSize, $this->pageSizeMinimum), $this->pageSizeMax);
    }
}
