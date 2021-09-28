<?php

namespace App\Http\Controllers;

use App\Models\MiscModel;
use Illuminate\Support\Str;

class HelperController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function link()
    {
        return $this->render('link');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function dice()
    {
        return $this->render('dice');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function map()
    {
        return $this->render('map');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function filters()
    {
        return $this->render('filters');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function age()
    {
        return $this->render('age');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function attributes()
    {
        return $this->render('attributes');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function entityTemplates()
    {
        return $this->render('entity_templates');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function widgetFilters()
    {
        return $this->render('widget_filters');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function pins()
    {
        return $this->render('pins');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function apiFilters()
    {
        $type = request()->get('type');
        if (empty($type)) {
            abort(404);
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

    protected function render(string $view)
    {
        $ajax = request()->ajax();
        return view('helpers.' . $view, compact('ajax'));
    }
}
