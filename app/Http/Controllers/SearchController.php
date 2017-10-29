<?php

namespace App\Http\Controllers;

use App\Character;
use App\Location;
use Illuminate\Http\Request;

class SearchController extends Controller
{
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
}
