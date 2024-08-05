<?php

namespace App\Traits\Controllers;

trait HasSubview
{
    public function subview(string $view, $model)
    {

        return view('cruds.subview')
            ->with([
                'fullview' => $view,
                'model' => $model,
                'entity' => $model->entity,
                'campaign' => $this->campaign,
                'rows' => $this->rows,
            ]);
    }
}
