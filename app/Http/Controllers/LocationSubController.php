<?php

namespace App\Http\Controllers;

use App\Facades\Datagrid;
use App\Models\Campaign;
use App\Models\Location;

class LocationSubController extends LocationController
{
    /**
     * @param Location $location
     */
    public function characters(Campaign $campaign, Location $location)
    {
        $this->authCheck($location);

        $options = ['campaign' => $campaign, 'location' => $location];
        $filters = [];
        if (request()->has('parent_id')) {
            $options['parent_id'] = $location->id;
            $filters['location_id'] = $location->id;
        }
        Datagrid::layout(\App\Renderers\Layouts\Location\Character::class)
            ->route('locations.characters', $options);

        $this->rows = $location
            ->allCharacters()
            ->select(['id', 'image', 'name', 'title', 'type','location_id', 'is_dead', 'is_private'])
            ->sort(request()->only(['o', 'k']))
            ->filter($filters)
            ->with(['location', 'location.entity', 'families', 'families.entity', 'races', 'races.entity', 'entity', 'entity.tags', 'entity.image'])
            ->has('entity')
            ->paginate();

        // Ajax Datagrid
        if (request()->ajax()) {
            return $this->datagridAjax();
        }

        return $this
            ->menuView($location, 'characters');
    }
}
