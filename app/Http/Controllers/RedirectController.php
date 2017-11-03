<?php

namespace App\Http\Controllers;

use App\Character;
use App\Family;
use App\Item;
use App\Journal;
use App\Location;
use App\Note;
use App\Organisation;
use Illuminate\Http\Request;

class RedirectController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('campaign');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index(Request $request)
    {
        $allowed = [
            'characters' => Character::class,
            'families' => Family::class,
            'items' => Item::class,
            'journals' => Journal::class,
            'locations' => Location::class,
            'notes' => Note::class,
            'organisations' => Organisation::class,
        ];

        $what = $request->get('what');
        $name = $request->get('name');

        if (!in_array($what, array_keys($allowed))) {
            abort(404);
        }

        $modelClass = new $allowed[$what];
        $model = $modelClass->where('name', 'like', "%$name%")->first();
        if ($model) {
            return redirect()->route($what.'.show', $model->id);
        }

        abort(404);
    }
}
