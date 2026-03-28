<?php

namespace App\Livewire\Posts;

use App\Models\Campaign;
use App\Models\Image;
use App\Models\Post;
use Illuminate\Support\Arr;
use Livewire\Attributes\Locked;
use Livewire\Component;

class GalleryCarousel extends Component
{
    #[Locked]
    public array $images = [];

    #[Locked]
    public bool $showName = false;

    public function mount(Post $post, Campaign $campaign): void
    {
        $this->showName = (bool) Arr::get($post->settings, 'show_name', false);

        $folderId = Arr::get($post->settings, 'folder_id');
        if (empty($folderId)) {
            return;
        }

        $images = Image::where('campaign_id', $campaign->id)
            ->where('folder_id', $folderId)
            ->where('is_folder', false)
            ->acl(true)
            ->orderBy('name', 'asc')
            ->limit(30)
            ->get();

        $this->images = $images
            ->filter(fn (Image $image) => $image->hasThumbnail())
            ->map(fn (Image $image) => [
                'url' => $image->getUrl(800, 600),
                'full' => $image->getUrl(),
                'name' => $image->name,
            ])
            ->values()
            ->toArray();
    }

    public function render()
    {
        return view('livewire.posts.gallery-carousel');
    }
}
