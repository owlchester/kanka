<?php

namespace App\Http\Controllers;

use App\Character;
use App\Family;
use App\Item;
use App\Location;
use App\Note;
use App\Organisation;
use Illuminate\Http\Request;

class SearchController extends Controller
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

    public function search(Request $request)
    {
        $term = trim($request->q);
        $locations = Location::where('name', 'like', "%$term%")->limit(5)->get();
        $characters = Character::where('name', 'like', "%$term%")->limit(5)->get();
        $items = Item::where('name', 'like', "%$term%")->limit(5)->get();
        $organisations = Organisation::where('name', 'like', "%$term%")->limit(5)->get();
        $notes = Note::where('name', 'like', "%$term%")->limit(5)->get();

        return view('search.index', compact(
            'term', 'locations', 'characters', 'items', 'organisations', 'notes'
        ));
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function locations(Request $request)
    {
        $term = trim($request->q);

        if (empty($term)) {
            return \Response::json([]);
        }

        $models = Location::where('name', 'like', "%$term%")->limit(10)->get();
        $formatted = [];

        foreach ($models as $model) {
            $formatted[] = ['id' => $model->id, 'text' => $model->name];
        }

        return \Response::json($formatted);
    }


    /**
     * @param Request $request
     * @return mixed
     */
    public function characters(Request $request)
    {
        $term = trim($request->q);

        if (empty($term)) {
            return \Response::json([]);
        }

        $models = Character::where('name', 'like', "%$term%")->limit(10)->get();
        $formatted = [];

        foreach ($models as $model) {
            $formatted[] = ['id' => $model->id, 'text' => $model->name];
        }

        return \Response::json($formatted);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function families(Request $request)
    {
        $term = trim($request->q);

        if (empty($term)) {
            return \Response::json([]);
        }

        $models = Family::where('name', 'like', "%$term%")->limit(10)->get();
        $formatted = [];

        foreach ($models as $model) {
            $formatted[] = ['id' => $model->id, 'text' => $model->name];
        }

        return \Response::json($formatted);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function notes(Request $request)
    {
        $term = trim($request->q);

        if (empty($term)) {
            return \Response::json([]);
        }

        $models = Note::where('name', 'like', "%$term%")->limit(10)->get();
        $formatted = [];

        foreach ($models as $model) {
            $formatted[] = ['id' => $model->id, 'text' => $model->name];
        }

        return \Response::json($formatted);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function organisations(Request $request)
    {
        $term = trim($request->q);

        if (empty($term)) {
            return \Response::json([]);
        }

        $models = Organisation::where('name', 'like', "%$term%")->limit(10)->get();
        $formatted = [];

        foreach ($models as $model) {
            $formatted[] = ['id' => $model->id, 'text' => $model->name];
        }

        return \Response::json($formatted);
    }
}
