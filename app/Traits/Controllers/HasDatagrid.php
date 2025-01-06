<?php

namespace App\Traits\Controllers;

use App\Facades\Datagrid;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

trait HasDatagrid
{
    protected LengthAwarePaginator $rows;

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    protected function datagridAjax()
    {
        $html = view('layouts.datagrid._table')
            ->with('rows', $this->rows)
            ->with('campaign', $this->campaign)
            ->render();
        $deletes = view('layouts.datagrid.delete-forms')
            ->with('models', Datagrid::deleteForms())
            ->with('params', Datagrid::getActionParams())
            ->with('campaign', $this->campaign)
            ->render();

        $data = [
            'success' => true,
            'html' => $html,
            'deletes' => $deletes,
        ];

        return response()->json($data);
    }
}
