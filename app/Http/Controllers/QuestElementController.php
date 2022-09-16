<?php

namespace App\Http\Controllers;

use App\Datagrids\Sorters\QuestElementSorter;
use App\Models\Quest;
use App\Models\QuestElement;
use App\Http\Requests\StoreQuestElement;
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
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\QuestElement  $element
     * @return \Illuminate\Http\Response
     */
    public function edit(Quest $quest, QuestElement $questElement)
    {
        $this->authorize('update', $quest);
        $model = $questElement;

        return view('quests.elements.update', compact(
            'quest',
            'model'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Quest  $quest
     * @param  \App\Models\QuestElement  $questElement
     * @return \Illuminate\Http\Response
     */
    public function update(StoreQuestElement $request, Quest $quest, QuestElement $questElement)
    {
        $this->authorize('update', $quest);

        $data = $request->only(['entity_id', 'name', 'role', 'description', 'colour', 'visibility_id']);

        $questElement->update($data);
        $questElement->refresh();

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
