<?php

namespace App\Http\Controllers\Search;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Response;

class MiscController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
        $this->middleware('campaign.member');
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function locations(Request $request)
    {
        $term = trim($request->q);
        return $this->buildSearchResults($term, \App\Models\Location::class);
    }


    /**
     * @param Request $request
     * @return mixed
     */
    public function characters(Request $request)
    {
        $term = trim($request->q);
        return $this->buildSearchResults($term, \App\Models\Character::class);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function families(Request $request)
    {
        $term = trim($request->q);
        return $this->buildSearchResults($term, \App\Models\Family::class);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function items(Request $request)
    {
        $term = trim($request->q);
        return $this->buildSearchResults($term, \App\Models\Item::class);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function organisations(Request $request)
    {
        $term = trim($request->q);
        return $this->buildSearchResults($term, \App\Models\Organisation::class);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function events(Request $request)
    {
        $term = trim($request->q);
        return $this->buildSearchResults($term, \App\Models\Event::class);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function quests(Request $request)
    {
        $term = trim($request->q);
        return $this->buildSearchResults($term, \App\Models\Quest::class);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function calendars(Request $request)
    {
        $term = trim($request->q);
        return $this->buildSearchResults($term, \App\Models\Calendar::class);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function tags(Request $request)
    {
        $term = trim($request->q);
        return $this->buildSearchResults($term, \App\Models\Tag::class);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function diceRolls(Request $request)
    {
        $term = trim($request->q);
        return $this->buildSearchResults($term, \App\Models\DiceRoll::class);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function conversations(Request $request)
    {
        $term = trim($request->q);
        return $this->buildSearchResults($term, \App\Models\Conversation::class);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function races(Request $request)
    {
        $term = trim($request->q);
        return $this->buildSearchResults($term, \App\Models\Race::class);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function abilities(Request $request)
    {
        $term = trim($request->q);
        return $this->buildSearchResults($term, \App\Models\Ability::class);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function attributeTemplates(Request $request)
    {
        $term = trim($request->q);
        return $this->buildSearchResults($term, \App\Models\AttributeTemplate::class);
    }

    /**
     * Build the search results
     * @param $term
     * @param $class
     * @return mixed
     */
    protected function buildSearchResults($term, $class)
    {
        $modelClass = new $class;
        if (empty($term)) {
            $models = $modelClass->limit(10)->orderBy('updated_at', 'DESC')->get();
        } else {
            $models = $modelClass->where('name', 'like', "%$term%")->limit(10)->get();
        }
        $formatted = [];

        foreach ($models as $model) {
            $format = [
                'id' => $model->id,
                'text' => $model->name
            ];
            if ($class === 'App\Models\Tag' && $model->hasColour()) {
                $format['colour'] = $model->colourClass();
            }

            $formatted[] = $format;
        }

        return Response::json($formatted);
    }
}
