<?php

namespace App\Http\Controllers\Quests;

use App\Facades\Datagrid;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Quest;
use App\Traits\CampaignAware;
use App\Traits\Controllers\HasDatagrid;
use App\Traits\Controllers\HasSubview;
use App\Traits\GuestAuthTrait;

class QuestController extends Controller
{
    use CampaignAware;
    use GuestAuthTrait;
    use HasDatagrid;
    use HasSubview;

    public function index(Campaign $campaign, Quest $quest)
    {
        $this->campaign($campaign)->authEntityView($quest->entity);

        $options = ['campaign' => $campaign, 'quest' => $quest];
        $filters = [];
        if (request()->has('parent_id')) {
            $options['parent_id'] = $quest->id;
            $filters['quest_id'] = $quest->id;
        }

        Datagrid::layout(\App\Renderers\Layouts\Quest\Quest::class)
            ->route('quests.quests', $options);

        $this->rows = $quest
            ->descendants()
            ->sort(request()->only(['o', 'k']), ['name' => 'asc'])
            ->with([
                'entity', 'entity.image', 'entity.tags', 'entity.tags.entity',
                'parent', 'parent.entity',
            ])
            ->has('entity')
            ->filter($filters)
            ->paginate(15);

        if (request()->ajax()) {
            return $this->campaign($campaign)->datagridAjax();
        }

        return redirect()->to($quest->getLink());
    }
}
