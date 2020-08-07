<?php

namespace App\Http\Controllers\Entity;

use App\Datagrids\Sorters\EntityTimelineSorter;
use App\Http\Controllers\Controller;
use App\Models\Entity;
use App\Traits\GuestAuthTrait;
use Illuminate\Support\Facades\Auth;

class TimelineController extends Controller
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
        // Policies will always fail if they can't resolve the user.
        if (Auth::check()) {
            $this->authorize('view', $entity->child);
        } else {
            $this->authorizeEntityForGuest('read', $entity->child);
        }


        $datagridSorter = new EntityTimelineSorter();
        $datagridSorter->request(request()->all());

        $ajax = request()->ajax();
        $timelines = $entity
            ->timelines()
            ->with(['timeline', 'timeline.entity', 'era'])
            ->has('timeline')
            ->acl()
            ->simpleSort($datagridSorter)
            ->paginate();

        return view('entities.pages.timelines.index', compact(
            'ajax',
            'entity',
            'timelines',
            'datagridSorter'
        ));
    }
}
