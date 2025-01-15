<?php

namespace App\Http\Controllers\Entity;

use App\Http\Controllers\Controller;
use App\Facades\Datagrid;
use App\Models\Campaign;
use App\Models\Entity;
use App\Traits\CampaignAware;
use App\Traits\Controllers\HasDatagrid;
use App\Traits\GuestAuthTrait;

class MentionController extends Controller
{
    use CampaignAware;
    use GuestAuthTrait;
    use HasDatagrid;

    public function index(Campaign $campaign, Entity $entity)
    {
        $this->authEntityView($entity);

        $options = ['campaign' => $campaign, 'entity' => $entity];

        Datagrid::layout(\App\Renderers\Layouts\Mention\Mention::class)
            ->route('entities.mentions', $options);
        $this->rows = $entity
            ->targetMentions()
            ->datagridElements(request()->only(['o', 'k']))
            ->with([
                'campaign' => function ($sub) {
                    $sub->select('id', 'name', 'slug');
                },
                'post' => function ($sub) {
                    $sub->select('id', 'entity_id', 'name', 'visibility_id');
                },
                'post.entity' => function ($sub) {
                    $sub->select('id', 'type_id', 'entity_id', 'name', 'is_private');
                },
                'entity' => function ($sub) {
                    $sub->select('id', 'type_id', 'entity_id', 'name', 'is_private');
                },
                'entity.entityType' => function ($sub) {
                    $sub->select('id', 'code', 'singular', 'plural');
                },
                'questElement' => function ($sub) {
                    $sub->select('id', 'name', 'quest_id', 'entity_id', 'visibility_id');
                },
                'questElement.entity' => function ($sub) {
                    $sub->select('id', 'type_id', 'entity_id', 'name', 'is_private');
                },
                /*'questElement.quest' => function ($sub) {
                    $sub->select('id', 'name', 'is_private');
                },
                'questElement.quest.entity' => function ($sub) {
                    $sub->select('id', 'type_id', 'entity_id', 'name', 'is_private');
                },*/
                'timelineElement' => function ($sub) {
                    $sub->select('id', 'name', 'timeline_id', 'entity_id', 'visibility_id');
                },
                'timelineElement.entity' => function ($sub) {
                    $sub->select('id', 'type_id', 'entity_id', 'name', 'is_private');
                },
                /*'timelineElement.timeline' => function ($sub) {
                    $sub->select('id', 'name', 'is_private');
                },
                'timelineElement.timeline.entity' => function ($sub) {
                    $sub->select('id', 'type_id', 'entity_id', 'name', 'is_private');
                },*/
            ])
            ->filterValid()
            ->paginate();

        // Ajax Datagrid
        if (request()->ajax()) {
            return $this->campaign($campaign)->datagridAjax();
        }

        $rows = $this->rows;
        return view('entities.pages.mentions.mentions', compact(
            'entity',
            'rows',
            'campaign',
        ));
    }
}
