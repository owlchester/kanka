<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Character;
use App\Models\MiscModel;
use App\Services\CampaignService;
use App\Services\EntityService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\FilterService;

class SearchController extends Controller
{
    /**
     * @var CampaignService
     */
    protected CampaignService $campaign;

    /**
     * @var EntityService
     */
    protected EntityService $entity;

    /**
     * @var FilterService
     */
    protected FilterService $filterService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(CampaignService $campaignService, EntityService $entityService)
    {
        $this->entity = $entityService;
        $this->campaign = $campaignService;

        $this->filterService = new FilterService();
    }

    /**
     * Old deprecated search page
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index(Request $request, Campaign $campaign)
    {
        $this->authorize('access', $campaign);

        $term = $request->get('q');
        if (empty($term) || !is_string($term)) {
            return view('search.index')
                ->with('results', [])
                ->with('campaign', $campaign);
        }
        $term = trim($term);
        $results = [];
        $resultCount = 0;
        $active = '';
        $filterService = $this->filterService;
        $filters = null;
        $found = null;

        foreach ($this->entity->entities(['menu_links']) as $element => $class) {
            if ($this->campaign->enabled($element)) {
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
        }

        // Found just one result?
        if ($resultCount == 1 && $found instanceof MiscModel) {
            return redirect()->route($found->entity->pluralType() . '.show', $found);
        }

        return view('search.index', compact(
            'campaign',
            'filters',
            'term',
            'results',
            'active',
            'filterService'
        ));
    }
}
