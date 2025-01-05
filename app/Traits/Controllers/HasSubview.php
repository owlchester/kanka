<?php

namespace App\Traits\Controllers;

use App\Enums\Descendants;

trait HasSubview
{
    protected Descendants $descendantsMode;

    public function subview(string $view, $model)
    {

        return view('cruds.subview')
            ->with([
                'fullview' => $view,
                'model' => $model,
                'entity' => $model->entity,
                'campaign' => $this->campaign,
                'rows' => $this->rows,
                'mode' => $this->descendantsMode(),
            ]);
    }

    protected function filterToDirect(): bool
    {
        return $this->descendantsMode() === Descendants::Direct;
    }

    protected function descendantsMode(): Descendants
    {
        if (isset($this->descendantsMode)) {
            return $this->descendantsMode;
        }
        if (request()->has('m')) {
            if (request()->get('m') == Descendants::All->value) {
                return $this->descendantsMode = Descendants::All;
            }
             elseif (request()->get('m') == Descendants::Direct->value) {
                return $this->descendantsMode = Descendants::Direct;
            }
        }
        return $this->descendantsMode = $this->campaign->defaultDescendantsMode();
    }
}
