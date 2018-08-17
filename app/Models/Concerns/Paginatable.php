<?php

namespace App\Models\Concerns;

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
        }

        return min(max($pageSize, $this->pageSizeMinimum), $this->pageSizeLimit);
    }
}
