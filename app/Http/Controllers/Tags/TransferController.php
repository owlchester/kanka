<?php

namespace App\Http\Controllers\Tags;

use App\Exceptions\TranslatableException;
use App\Http\Controllers\Controller;
use App\Http\Requests\TransferTag;
use App\Models\Campaign;
use App\Models\Tag;
use App\Services\TagService;

class TransferController extends Controller
{
    protected TagService $service;

    public function __construct(TagService $service)
    {
        $this->service = $service;
    }

    public function index(Campaign $campaign, Tag $tag)
    {
        $this->authorize('update', $tag->entity);

        return view('tags.transfer', compact('campaign', 'tag'));
    }

    public function postIndex(Campaign $campaign, Tag $tag)
    {
        $this->authorize('update', $tag->entity);

        return view('tags.transfer_posts', compact('campaign', 'tag'));
    }

    public function process(TransferTag $request, Campaign $campaign, Tag $tag)
    {
        $this->authorize('update', $tag->entity);
        $newTag = Tag::where('id', $request->tag_id)->first();
        try {
            $this->service->transfer($tag, $newTag);
            return redirect()
                ->route('entities.show', [$campaign, $tag->entity])
                ->with('success_raw', __('tags.transfer.success', ['tag' => $tag->name, 'newTag' => $newTag->name]));
        } catch (TranslatableException $ex) {
            return redirect()
                ->route('entities.show', [$campaign, $tag->entity])
                ->with('error', __('tags.transfer.fail', ['tag' => $tag->name, 'newTag' => $newTag->name]));
        }
    }

    public function processPosts(TransferTag $request, Campaign $campaign, Tag $tag)
    {
        $this->authorize('update', $tag->entity);
        $newTag = Tag::where('id', $request->tag_id)->first();
        try {
            $this->service->transferPosts($tag, $newTag);
            return redirect()
                ->route('entities.show', [$campaign, $tag->entity])
                ->with('success_raw', __('tags.transfer.success_post', ['tag' => $tag->name, 'newTag' => $newTag->name]));
        } catch (TranslatableException $ex) {
            return redirect()
                ->route('entities.show', [$campaign, $tag->entity])
                ->with('error', __('tags.transfer.fail_post', ['tag' => $tag->name, 'newTag' => $newTag->name]));
        }
    }
}
