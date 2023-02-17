<?php

namespace App\Http\Controllers;

use App\Datagrids\Actions\DeprecatedDatagridActions;
use App\Datagrids\Filters\ConversationFilter;
use App\Facades\CampaignLocalization;
use App\Http\Requests\StoreConversation;
use App\Models\Campaign;
use App\Models\Conversation;

class ConversationController extends CrudController
{
    /**
     * @var string
     */
    protected string $view = 'conversations';
    protected string $route = 'conversations';
    protected $module = 'conversations';

    /** @var string Model */
    protected $model = \App\Models\Conversation::class;

    /** @var string Filter */
    protected $filter = ConversationFilter::class;

    /** @var string  */
    protected $datagridActions = DeprecatedDatagridActions::class;

    /**
     * Controller constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->addNavAction(
            '//docs.kanka.io/en/latest/entities/conversations.html',
            '<i class="fa-solid fa-question-circle"></i> ' . __('crud.actions.help'),
            'default',
            true
        );
    }

    /**
     */
    public function store(StoreConversation $request, Campaign $campaign)
    {
        return $this->campaign($campaign)->crudStore($request);
    }

    public function show(Campaign $campaign, Conversation $conversation)
    {
        // Policies will always fail if they can't resolve the user.
        if (auth()->check()) {
            $this->authorize('view', $conversation);
        } else {
            $this->authorizeForGuest(\App\Models\CampaignPermission::ACTION_READ, $conversation);
        }
        $name = $this->view;
        $ajax = request()->ajax();
        $model = $conversation;

        return view(
            'cruds.show',
            compact('campaign', 'model', 'name', 'ajax')
        );
    }

    public function edit(Campaign $campaign, Conversation $conversation)
    {
        return $this->campaign($campaign)->crudEdit($conversation);
    }

    public function update(StoreConversation $request, Campaign $campaign, Conversation $conversation)
    {
        return $this->campaign($campaign)->crudUpdate($request, $conversation);
    }

    public function destroy(Campaign $campaign, Conversation $conversation)
    {
        return $this->campaign($campaign)->crudDestroy($conversation);
    }
}
