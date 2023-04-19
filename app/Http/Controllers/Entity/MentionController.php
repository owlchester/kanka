<?php

namespace App\Http\Controllers\Entity;

use App\Http\Controllers\Controller;
use App\Facades\Datagrid;
use App\Models\Entity;
use App\Traits\GuestAuthTrait;
use Illuminate\Support\Facades\Auth;

class MentionController extends Controller
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
            $this->authorizeEntityForGuest(\App\Models\CampaignPermission::ACTION_READ, $entity->child);
        }
        $options = ['entity' => $entity];

        $ajax = request()->ajax();

        Datagrid::layout(\App\Renderers\Layouts\Mention\Mention::class)
            ->route('entities.mentions', $options);
        $rows = $entity
            ->targetMentions()
            ->datagridElements(request()->only(['o', 'k']))
            ->with([
                'campaign' => function ($sub) {
                    $sub->select('id', 'name');
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
            ->paginate();

        // Ajax Datagrid
        if ($ajax) {
            return $this->datagridAjax($rows);
        }

        return view('entities.pages.mentions.mentions', compact(
            'entity',
            'rows',
            'ajax',
        ));
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    protected function datagridAjax($rows)
    {
        $html = view('layouts.datagrid._table')
            ->with('rows', $rows)
            ->render();
        $deletes = view('layouts.datagrid.delete-forms')
            ->with('models', Datagrid::deleteForms())
            ->with('params', Datagrid::getActionParams())
            ->render();

        $data = [
            'success' => true,
            'html' => $html,
            'deletes' => $deletes,
        ];

        return response()->json($data);
    }
}
