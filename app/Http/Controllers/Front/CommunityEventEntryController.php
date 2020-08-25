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

    public function store(StoreCommunityEventEntry $request, CommunityEvent $communityEvent)
    {
        $data = $request->only(['link', 'comment']);
        $entry = CommunityEventEntry::create($data);

        return redirect()
            ->route('community-events.show', $communityEvent)
            ->with('success', __('front/community-events.participate.success.submit'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CommunityEventEntry  $communityEventEntry
     * @return \Illuminate\Http\Response
     */
    public function update(StoreCommunityEventEntry $request, CommunityEventEntry $communityEventEntry)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Release  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Release $post)
    {
        //
    }

}
