<?php

namespace App\Http\Controllers\Search;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Entity;
use App\Services\Search\EntitySearchService;
use Illuminate\Http\Request;

class FullTextController extends Controller
{
    protected EntitySearchService $service;

    public function __construct(EntitySearchService $service)
    {
        $this->service = $service;
    }

    public function index(Campaign $campaign, Request $request)
    {
        $this->authorize('access', $campaign);
        $term = request()->term;
        $term2 = null;

        /** @var Entity|null $entity */
        $entity = Entity::where('name', request()->term)->first();
        if ($entity) {
            // @phpstan-ignore-next-line
            $term2 = $entity->type() . ':' . $entity->id;
        }

        $results = $this->service
            ->campaign($campaign)
            ->search($term, $term2);
        $results = array_column($results, 'id');

        $base = Entity::whereIn('id', $results)->orderBy('name');

        /**
         * Prepare a lot of variables that will be shared over to the view
         */

        $name = 'entities';
        $unfilteredCount = $base->count();

        $models = $base->paginate(); //We get the entities here

        // If the current page is higher than the max amount of pages, redirect the user
        if ((int) request()->get('page', 1) > $models->lastPage()) {
            return redirect()->route('search.fulltext', [
                $campaign,
                'page' => $models->lastPage(),
                'order' => request()->get('order')
            ]);
        }

        $mode = 'grid';

        $forceMode = null;

        $data = compact(
            'campaign',
            'models',
            'name',
            'unfilteredCount',
            'mode',
            'forceMode',
        );
        $data['titleKey'] = __('entities.entities');
        return view('cruds.index', $data);
    }


}
