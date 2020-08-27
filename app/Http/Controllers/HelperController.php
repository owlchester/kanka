<?php

namespace App\Http\Controllers;

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

    protected function render(string $view)
    {
        $ajax = request()->ajax();
        return view('helpers.' . $view, compact('ajax'));
    }
}
