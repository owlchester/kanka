<?php

namespace App\Http\Controllers;

use App\Datagrids\Sorters\QuestElementSorter;
use App\Models\Quest;
use App\Models\QuestElement;
use App\Http\Requests\StoreQuestElement;
use App\Facades\CampaignLocalization;
use App\Services\MultiEditingService;
use App\Traits\GuestAuthTrait;
use Illuminate\Support\Facades\Auth;

class QuestElementController extends Controller
{
    /** For unlogged user permissions */
    use GuestAuthTrait;

    /**
     * @var string
     */
    protected $model = \App\Models\QuestElement::class;

    /**
     * @param Quest $quest
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Quest $quest)
    {
        if (empty($quest->entity)) {
            abort(404);
        }
        // Policies will always fail if they can't resolve the user.
        if (Auth::check()) {
            $this->authorize('view', $quest);
        } else {
            $this->authorizeEntityForGuest(\App\Models\CampaignPermission::ACTION_READ, $quest);
        }

        $datagridSorter = new QuestElementSorter();
        $datagridSorter->request(request()->all());

        $ajax = request()->ajax();
        $model = $quest;
        $elements = $quest
            ->elements()
            ->with('entity')
            ->simpleSort($datagridSorter)
            ->paginate();

        return view('quests.elements.index', compact(
            'ajax',
            'model',
            'elements',
            'datagridSorter'
        ));
    }

    /**
     * @param Quest $quest
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(Quest $quest)
    {
        $this->authorize('update', $quest);

        return view('quests.elements.create', compact(
            'quest'
        ));
    }

    /**
     * @param StoreQuestElement $request
     * @param Quest $quest
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreQuestElement $request, Quest $quest)
    {
        $this->authorize('update', $quest);

        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        $data = $request->only([
            'entity_id', 'name', 'role', 'description', 'colour', 'visibility_id'
        ]);
        $data['quest_id'] = $quest->id;

        $element = new QuestElement();
        $element = $element->create($data);

        if ($request->has('submit-update')) {
            return redirect()
                ->route('quests.quest_elements.edit', ['quest_element' => $element, 'quest' => $quest])
                ->with('success', __('quests.elements.create.success', [
                    'entity' => $element->name()
                ]));
        } elseif ($request->has('submit-new')) {
            return redirect()
                ->route('quests.quest_elements.create', [$quest])
                ->with('success', __('quests.elements.create.success', [
                    'entity' => $element->name()
                ]));
        }
        return redirect()
            ->route('quests.quest_elements.index', $quest)
            ->with('success', __('quests.elements.create.success', [
                'entity' => $element->name()
            ]));
    }

    /**
     * For crawlers/bots
     * @param Quest $quest
     * @param QuestElement $questElement
     */
    public function show(Quest $quest, QuestElement $questElement)
    {
        abort(404);
    }


    /**
     * @param Quest $quest
     * @param QuestElement $questElement
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Quest $quest, QuestElement $questElement)
    {
        $this->authorize('update', $quest);
        $model = $questElement;

        /** @var MiscModel $model */
        $campaign = CampaignLocalization::getCampaign();
        $editingUsers = null;

        if ($campaign->hasEditingWarning()) {
            /** @var MultiEditingService $editingService */
            $editingService = app()->make(MultiEditingService::class);
            $editingUsers = $editingService->model($questElement)->user(auth()->user())->users();
            // If no one is editing the quest element, we are now editing it
            if (empty($editingUsers)) {
                $editingService->edit();
            }
        }

        return view('quests.elements.update', compact(
            'quest',
            'model',
            'editingUsers'
        ));
    }

    /**
     * @param StoreQuestElement $request
     * @param Quest $quest
     * @param QuestElement $questElement
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(StoreQuestElement $request, Quest $quest, QuestElement $questElement)
    {
        $this->authorize('update', $quest);

        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        $data = $request->only(['entity_id', 'name', 'role', 'description', 'colour', 'visibility_id']);

        $questElement->update($data);
        $questElement->refresh();

        /** @var MultiEditingService $editingService */
        $editingService = app()->make(MultiEditingService::class);
        $editingService->model($questElement)
            ->user($request->user())
            ->finish();


        if ($request->has('submit-update')) {
            return redirect()
                ->route('quests.quest_elements.edit', ['quest_element' => $questElement, 'quest' => $quest])
                ->with('success', __('quests.elements.edit.success', [
                    'entity' => $questElement->name()
                ]));
        } elseif ($request->has('submit-new')) {
            return redirect()
                ->route('quests.quest_elements.create', [$quest])
                ->with('success', __('quests.elements.create.success', [
                    'entity' => $questElement->name()
                ]));
        }
        return redirect()
            ->route('quests.quest_elements.index', $quest)
            ->with('success', __('quests.elements.edit.success', [
                'entity' => $questElement->name()
            ]));
    }

    /**
     * @param Quest $quest
     * @param QuestElement $questElement
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Quest $quest, QuestElement $questElement)
    {
        $this->authorize('update', $quest);

        $questElement->delete();

        return redirect()
            ->route('quests.quest_elements.index', $quest)
            ->with('success', __('quests.elements.destroy.success', [
                'entity' => $questElement->name()
            ]));
    }
}
