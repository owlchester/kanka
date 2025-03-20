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

        $options = ['campaign' => $campaign, 'quest' => $quest, 'm' => $this->descendantsMode()];
        $filters = [];
        if ($this->filterToDirect()) {
            $filters['quest_id'] = $quest->id;
        }

        Datagrid::layout(\App\Renderers\Layouts\Quest\Quest::class)
            ->route('quests.quests', $options);

        // @phpstan-ignore-next-line
        $this->rows = $quest
            ->descendants()
            ->sort(request()->only(['o', 'k']), ['name' => 'asc'])
            ->with([
                'entity', 'entity.image', 'entity.entityType',
                'entity.visibleTags',
                'parent', 'parent.entity',
            ])
            ->has('entity')
            ->filter($filters)
            ->paginate(config('limits.pagination'));

        if (request()->ajax()) {
            return $this->campaign($campaign)->datagridAjax();
        }

        return redirect()->to($quest->getLink());
    }
}
