<?php

namespace App\Http\Controllers;

use App\Models\MiscModel;
use Illuminate\Support\Str;

class HelperController
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function apiFilters()
    {
        $type = request()->get('type');
        if (empty($type)) {
            return redirect()->route('home');
        }

        // Try creating the object
        try {
            $className = "\App\Models\\" . Str::camel($type);
            /** @var MiscModel $misc */
            $misc = new \ReflectionClass($className);
            if (!$misc->isInstantiable()) {
                abort(404);
            }
            $misc = new $className;
            if (!$misc instanceof MiscModel) {
                abort(404);
            }
            $filters = $misc->getFilterableColumns();

            return view('helpers.api-filters', compact(
                'filters', 'type'
            ));
        } catch(\Exception $e) {
            abort(404);
        }

        abort(404);
    }

    /**
     * @param string $view
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    protected function render(string $helper)
    {
        return view('helpers.helper', compact('helper'));
    }
}
