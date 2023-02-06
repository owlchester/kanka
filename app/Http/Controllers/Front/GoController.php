<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;

/**
 * The go controller handles requests to /go/{social} to redirect user to a social network
 */
class GoController extends Controller
{
    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index(string $social)
    {
        if (empty($social) || mb_strlen($social) > 10) {
            abort(404);
        }
        $conf = config('social.' . $social);
        if (empty($conf)) {
            abort(404);
        }
        return redirect()->to($conf);
    }
}
