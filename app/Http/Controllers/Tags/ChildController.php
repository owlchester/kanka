<?php

namespace App\Http\Controllers\Tags;

use App\Facades\Datagrid;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTagEntity;
use App\Models\Campaign;
use App\Models\CampaignPermission;
use App\Models\Tag;
use App\Traits\CampaignAware;
use App\Traits\Controllers\HasDatagrid;
use App\Traits\Controllers\HasSubview;

class ChildController extends Controller
{
    use HasDatagrid;
    use CampaignAware;
    use HasSubview;

    public function index(Campaign $campaign, Tag $tag)
    {
        if (auth()->check()) {
            $this->authorize('view', $tag);
        } else {
            $this->authorizeForGuest(CampaignPermission::ACTION_READ, $tag, $tag->entity->type_id);
        }

        $options = ['campaign' => $campaign, 'tag' => $tag];
        $base = 'allChildren';
        if (request()->has('tag_id')) {
            $options['tag_id'] = $tag->id;
            $base = 'entities';
        }
        Datagrid::layout(\App\Renderers\Layouts\Tag\Entity::class)
            ->route('tags.children', $options);

        $this->rows = $tag
            ->{$base}()
            ->sort(request()->only(['o', 'k']), ['name' => 'asc'])
            ->with(['image', 'tags'])
            ->paginate(15);

        // Ajax Datagrid
        if (request()->ajax()) {
            return $this->campaign($campaign)->datagridAjax();
        }

        return $this
            ->campaign($campaign)
            ->subview('tags.children', $tag);
    }

    /**
     * @param Tag $tag
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(Campaign $campaign, Tag $tag)
    {
        $this->authorize('update', $tag);
        $formOptions = ['tags.entity-add.save', $campaign, 'tag' => $tag];
        if (request()->has('from-children')) {
            $formOptions['from-children'] = true;
        }

        return view('tags.entities.create', [
            'campaign' => $campaign,
            'model' => $tag,
            'formOptions' => $formOptions
        ]);
    }

    /**
     * @param StoreTagEntity $request
     * @param Tag $tag
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreTagEntity $request, Campaign $campaign, Tag $tag)
    {
        $this->authorize('update', $tag);
        $redirectUrlOptions = ['campaign' => $campaign, 'tag' => $tag];
        if (request()->has('from-children')) {
            $redirectUrlOptions['tag_id'] = $tag->id;
        }

        $tag->attachEntity($request->only('entity_id'));
        return redirect()->route('tags.show', $redirectUrlOptions)
            ->with('success', trans('tags.children.create.success', ['name' => $tag->name]));
    }
}
