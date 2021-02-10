<?php

namespace App\Http\Controllers\Entity;

use App\Datagrids\Sorters\EntityTimelineSorter;
use App\Http\Controllers\Controller;
use App\Models\Entity;
use App\Traits\GuestAuthTrait;
use Illuminate\Support\Facades\Auth;

class MapPointController extends Controller
{
    /**
     * Guest Auth Trait
     */
    use GuestAuthTrait;

    /**
     * @param Entity $entity
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Entity $entity)
    {
        if (empty($entity->child)) {
            abort(404);
        }

        // Policies will always fail if they can't resolve the user.
        if (Auth::check()) {
            $this->authorize('view', $entity->child);
        } else {
            $this->authorizeEntityForGuest('read', $entity->child);
        }


        $datagridSorter = new EntityTimelineSorter();
        $datagridSorter->request(request()->all());

        $ajax = request()->ajax();
        $markers = $entity
            ->mapMarkers()
            ->with(['map', 'map.entity'])
            ->has('map')
            //->simpleSort($datagridSorter)
            ->paginate();

        $data = $entity
            ->targetMapPoints()
            ->orderBy('name', 'ASC')
            ->with(['location'])
            ->has('location')
            ->get();

        return view('entities.pages.map_markers.index', compact(
            'ajax',
            'entity',
            'markers',
            'data',
            'datagridSorter'
        ));
    }
}
