<?php

namespace App\Http\Controllers\Front;

use App\Models\MiscModel;
use Exception;
use Illuminate\Support\Str;

class HelperController
{
    public function apiFilters()
    {
        $type = request()->get('type');
        if (empty($type)) {
            return redirect()->route('home');
        }

        // Try creating the object
        try {
            $className = "\App\Models\\" . Str::camel($type);
            $misc = new \ReflectionClass($className);
            if (! $misc->isInstantiable()) {
                abort(404);
            }
            /** @var MiscModel $misc */
            $misc = new $className;
            if (! $misc instanceof MiscModel) {
                abort(404);
            }
            // @phpstan-ignore-next-line
            $filters = $misc->getFilterableColumns();

            return view('helpers.api-filters', compact(
                'filters',
                'type'
            ));
        } catch (Exception $e) {
            abort(404);
        }
    }
}
