<?php


namespace App\Http\Controllers\Front;


use App\Http\Controllers\Controller;
use App\Http\Requests\Front\StoreCommunityEventEntry;
use App\Models\CommunityEvent;
use App\Models\CommunityEventEntry;
use App\Services\EntityService;

class CommunityEventEntryController extends Controller
{
    /** @var EntityService */
    protected $service;

    public function __construct(EntityService $entityService)
    {
        $this->middleware(['identity']);
        $this->service = $entityService;
    }

    /**
     * @param StoreCommunityEventEntry $request
     * @param CommunityEvent $communityEvent
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreCommunityEventEntry $request, CommunityEvent $communityEvent)
    {
        $data = $request->only(['link', 'comment']);
        $data['community_event_id'] = $communityEvent->id;
        try {
            $entry = CommunityEventEntry::create($data);

            return redirect()
                ->route('community-events.show', [$communityEvent, '#event-form'])
                ->with('success', __('front/community-events.participate.success.submit'));
        } catch (\Exception $e) {
            // Tried sending a second submission?
            return redirect()
                ->route('community-events.show', [$communityEvent, '#event-form']);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CommunityEventEntry  $communityEventEntry
     * @return \Illuminate\Http\Response
     */
    public function update(StoreCommunityEventEntry $request, CommunityEvent $communityEvent, CommunityEventEntry $communityEventEntry)
    {
        $data = $request->only(['link', 'comment']);
        try {
            $communityEventEntry->update($data);

            return redirect()
                ->route('community-events.show', [$communityEvent, '#event-form'])
                ->with('success', __('front/community-events.participate.success.modified'));
        } catch (\Exception $e) {
            // Tried sending a second submission?
            return redirect()
                ->route('community-events.show', [$communityEvent, '#event-form']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Release  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(CommunityEvent $communityEvent, CommunityEventEntry $communityEventEntry)
    {
        $this->authorize('delete', $communityEventEntry);

        $communityEventEntry->delete();

        return redirect()
            ->route('community-events.show', [$communityEvent, '#event-form'])
            ->with('success', __('front/community-events.participate.success.removed'));
    }

}
