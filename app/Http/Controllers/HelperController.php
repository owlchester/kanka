<?php

namespace App\Http\Controllers;

class HelperController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function link()
    {
        return view('helpers.link');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function dice()
    {
        return view('helpers.dice');
    }
}
