<?php

namespace App\Http\Controllers\Tags;

use App\Facades\Datagrid;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTagEntity;
use App\Models\Campaign;
use App\Models\Tag;
use App\Traits\CampaignAware;
use App\Traits\Controllers\HasDatagrid;
use App\Traits\Controllers\HasSubview;
use App\Traits\GuestAuthTrait;

class ChildController extends Controller
{
    use CampaignAware;
    use GuestAuthTrait;
    use HasDatagrid;
    use HasSubview;

    public function index(Campaign $campaign, Tag $tag)
    {
        $this->campaign($campaign)->authEntityView($tag->entity);

        $options = ['campaign' => $campaign, 'tag' => $tag, 'm' => $this->descendantsMode()];
        $base = 'allChildren';
        if ($this->filterToDirect()) {
            $base = 'entities';
        }
        Datagrid::layout(\App\Renderers\Layouts\Tag\Entity::class)
            ->route('tags.children', $options);

        $this->rows = $tag
            ->{$base}()
            ->sort(request()->only(['o', 'k']), ['name' => 'asc'])
            ->with(['image', 'tags', 'entityType'])
            ->paginate(config('limits.pagination'));

        // Ajax Datagrid
        if (request()->ajax()) {
            return $this->campaign($campaign)->datagridAjax();
        }

        return $this
            ->campaign($campaign)
            ->subview('tags.children', $tag);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(Campaign $campaign, Tag $tag)
    {
        $this->authorize('update', $tag->entity);
        $formOptions = ['tags.entity-add.save', $campaign, 'tag' => $tag];
        if (request()->has('from-children')) {
            $formOptions['from-children'] = true;
        }

        return view('tags.entities.create', [
            'campaign' => $campaign,
            'model' => $tag,
            'formOptions' => $formOptions,
        ]);
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreTagEntity $request, Campaign $campaign, Tag $tag)
    {
        $this->authorize('update', $tag->entity);
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }
        $redirectUrlOptions = ['campaign' => $campaign, 'entity' => $tag->entity];
        if (request()->has('from-children')) {
            $redirectUrlOptions['tag_id'] = $tag->id;
        }

        $count = $tag->attachEntities($request->get('entities'));

        return redirect()->route('entities.show', $redirectUrlOptions)
            ->with('success', trans_choice('tags.children.create.attach_success', $count, ['name' => $tag->name, 'count' => $count]));
    }
}
