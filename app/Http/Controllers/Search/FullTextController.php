<?php

namespace App\Http\Controllers\Search;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Entity;
use App\Services\Search\EntitySearchService;
use Illuminate\Http\Request;

class FullTextController extends Controller
{
    public function __construct(protected EntitySearchService $service)
    {}

    public function index(Campaign $campaign, Request $request)
    {
        $term = strip_tags($request->get('term'));
        $term2 = null;

        $data = [
            'campaign' => $campaign,
            'models' => [],
            'term' => $term,
            'route' => 'search.fulltext',
        ];

        if (empty($term)) {
            return view('search.fulltext')->with($data);
        }

        /** @var ?Entity $entity */
        $entity = Entity::with('entityType')->where('name', $term)->first();
        if ($entity) {
            $term2 = $entity->entityType->code . ':' . $entity->id;
        }

        // Get entity ids from meilisearch
        $results = $this->service
            ->campaign($campaign)
            ->limit(100)
            ->search($term, $term2);
        $results = array_column($results, 'id');

        // Then get the actual entities from the campaign
        $models = Entity::whereIn('id', $results)
            ->orderBy('name')
            ->paginate();

        // If the current page is higher than the max amount of pages, redirect the user
        if ((int) $request->get('page', 1) > $models->lastPage()) {
            return redirect()->route('search.fulltext', [
                $campaign,
                'page' => $models->lastPage(),
                'order' => $request->get('order'),
            ]);
        }

        $data['models'] = $models;

        return view('search.fulltext')->with($data);
    }
}
