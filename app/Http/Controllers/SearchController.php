<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Character;
use App\Models\MiscModel;
use App\Services\EntityService;
use Illuminate\Http\Request;
use App\Services\FilterService;

class SearchController extends Controller
{
    protected EntityService $entity;

    protected FilterService $filterService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(EntityService $entityService, FilterService $filterService)
    {
        $this->middleware('campaign.member');

        $this->entity = $entityService;
        $this->filterService = $filterService;
    }

    /**
     * Old deprecated search page
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function search(Request $request, Campaign $campaign)
    {
        $term = $request->get('q');
        if (empty($term) || !is_string($term)) {
            return view('search.index')
                ->with('results', [])
                ->with('campaign', $campaign)
            ;
        }
        $term = trim($term);
        $results = [];
        $resultCount = 0;
        $active = '';
        $filterService = $this->filterService;
        $filters = null;
        $found = null;

        foreach ($this->entity->exclude(['bookmarks'])->entities() as $element => $class) {
            if (!$campaign->enabled($element)) {
                continue;
            }
            /** @var MiscModel|Character $model */
            $model = new $class();
            $results[$element] = $model->search($term)->limit(5)->get();
            $active = count($results[$element]) > 0 && empty($active) ? $element : $active;
            $resultCount += count($results[$element]);

            if (count($results[$element]) == 1) {
                if ($found === null) {
                    $found = $results[$element][0];
                } else {
                    $found = false;
                }
            }
        }

        // Found just one result?
        if ($resultCount == 1 && $found instanceof MiscModel) {
            return redirect()->to($found->getLink());
        }

        return view('search.index', compact(
            'campaign',
            'filters',
            'term',
            'results',
            'active',
            'filterService'
        ))
            ->with('campaign', $campaign);
    }
}
