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

class PostController extends Controller
{
    use CampaignAware;
    use GuestAuthTrait;
    use HasDatagrid;
    use HasSubview;

    public function index(Campaign $campaign, Tag $tag)
    {
        $this->campaign($campaign)->authEntityView($tag->entity);

        $options = ['campaign' => $campaign, 'tag' => $tag];

        Datagrid::layout(\App\Renderers\Layouts\Tag\Post::class)
            ->route('tags.posts', $options);

        $this->rows = $tag
            ->posts()
            ->sort(request()->only(['o', 'k']), ['name' => 'asc'])
            ->with(['entity', 'entity.image', 'visibleTags'])
            ->has('entity')
            ->paginate(config('limits.pagination'));

        if (request()->ajax()) {
            return $this->campaign($campaign)->datagridAjax();
        }

        return $this
            ->campaign($campaign)
            ->subview('tags.children.posts', $tag);
    }
}
