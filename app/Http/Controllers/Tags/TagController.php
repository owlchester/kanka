<?php

namespace App\Http\Controllers\Tags;

use App\Facades\Datagrid;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Tag;
use App\Traits\CampaignAware;
use App\Traits\Controllers\HasDatagrid;
use App\Traits\Controllers\HasSubview;
use App\Traits\GuestAuthTrait;

class TagController extends Controller
{
    use CampaignAware;
    use GuestAuthTrait;
    use HasDatagrid;
    use HasSubview;

    public function index(Campaign $campaign, Tag $tag)
    {
        $this->campaign($campaign)->authEntityView($tag->entity);

        $options = ['campaign' => $campaign, 'tag' => $tag, 'm' => $this->descendantsMode()];
        $filters = [];
        if ($this->filterToDirect()) {
            $filters['tag_id'] = $tag->id;
        }

        Datagrid::layout(\App\Renderers\Layouts\Tag\Tag::class)
            ->route('tags.tags', $options);

        $this->rows = $tag
            ->descendants()
            ->sort(request()->only(['o', 'k']), ['name' => 'asc'])
            ->filter($filters)
            ->with([
                'entity', 'entity.image',
                'parent', 'parent.entity',
            ])
            ->paginate();

        if (request()->ajax()) {
            return $this->campaign($campaign)->datagridAjax();
        }

        return $this
            ->campaign($campaign)
            ->subview('tags.tags', $tag);
    }
}
