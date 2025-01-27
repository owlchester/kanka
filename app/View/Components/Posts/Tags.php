<?php

namespace App\View\Components\Posts;

use App\Models\Campaign;
use App\Models\Post;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Tags extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public Post $post,
        public Campaign $campaign
    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.posts.tags')
            ->with('tags', $this->post->visibleTags);
    }
}
