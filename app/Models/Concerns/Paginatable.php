<?php

namespace App\Models\Concerns;

use App\Services\PaginationService;

trait Paginatable
{
    /**
     * @var int
     */
    private $pageSizeLimit = 45;

    /**
     * @var int
     */
    private $pageSizeMinimum = 15;

    /**
     * @return mixed
     */
    public function getPerPage()
    {
        $pageSize = 15;

        if (auth()->check()) {
            $pageSize = auth()->user()->default_pagination;
            $this->pageSizeLimit = PaginationService::$MAX;
        }

        // Currently exporting single or bulk? Rise limit to 100.
        $request = request()->route()->getAction();
        if (!empty($request['as']) && in_array($request['as'], ['entities.export', 'bulk.process'])) {
            return 100;
        }

        return min(max($pageSize, $this->pageSizeMinimum), $this->pageSizeLimit);
    }
}
