<?php

namespace App\Http\Controllers\Search;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Entity;
use App\Http\Resources\EntityResource as Resource;
use App\Services\Search\EntitySearchService;
use Illuminate\Http\Request;

class FullTextController extends Controller
{
    protected EntitySearchService $service;

    public function __construct(EntitySearchService $service)
    {
        $this->service = $service;
    }

    /**
     * return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function uselesstest(Campaign $campaign, Request $request)
    {
        $this->authorize('access', $campaign);
        $term = request()->term;
        $term2 = null;
        $entity = Entity::where(['name' => request()->term, 'campaign_id' => $campaign->id])->first();
        if ($entity) {
            $term2 = $entity->type() . ':' . $entity->id;
        }

        $results = $this->service
            ->campaign($campaign)
            ->search($term, $term2);
        return $results;
        //Return this view

    }









    public function index(Campaign $campaign, Request $request)
    {



        $this->authorize('access', $campaign);
        $term = request()->term;
        $term2 = null;

        $entity = Entity::where(['name' => request()->term, 'campaign_id' => $campaign->id])->first();
        if ($entity) {
            $term2 = $entity->type() . ':' . $entity->id;
        }

        $results = $this->service
            ->campaign($campaign)
            ->search($term, $term2);
        $results = array_column($results, 'id');

        $base = Entity::whereIn('id', $results)->orderBy('name');

        /**
         * Prepare a lot of variables that will be shared over to the view
         * @var MiscModel $model
         */
        //$model = new $this->model();
        

        $name = 'characters';
        //$langKey = $this->langKey ?? $name;

        $unfilteredCount = $base->count();

        $models = $base->paginate(); //We get the entities here

        // If the current page is higher than the max amount of pages, redirect the user
        if ((int) request()->get('page', 1) > $models->lastPage()) {
            return redirect()->route('search.fultext', [
                $campaign,
                'page' => $models->lastPage(),
                'order' => request()->get('order')
            ]);
        }


        $mode = 'grid';
        
        $forceMode = null;

        //$actions = $this->navActions;

        $data = compact(
            'campaign',
            'models',
            'name',
            //'langKey',
            //'model',
            //'actions',
            //'filter',
            //'filterService',
            //'filteredCount',
            'unfilteredCount',
            //'route',
            //'bulk',
            //'templates',
            //'datagridActions',
            'mode',
            //'parent',
            'forceMode',
            //'entityTypeId',
            //'singular',
        );
        $data['titleKey'] = __('abilities.show.tabs.entities');
        return view('cruds.index', $data);
    }


}











