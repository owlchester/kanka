<?php

namespace App\View\Components\Forms;

use App\Models\Campaign;
use App\Models\Entity;
use App\Models\Post;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Tags extends Component
{
    public string $id;
    public ?string $label;
    public ?string $dropdownParent;
    public mixed $tags;

    /**
     * Create a new component instance.
     */
    public function __construct(
        public Campaign $campaign,
        ?string $id = null,
        ?string $label = null,
        ?string $dropdownParent = null,
        public bool $allowNew = false,
        public bool $allowClear = false,
        public bool $enableAuto = false,
        public mixed $model = null,
        public ?string $helper = null,
        public mixed $options = [],
    ) {
        $this->id = $id ?? 'tags_' . uniqid();
        $this->label = $label ?? __('entities.tags');
        $this->dropdownParent = $dropdownParent ?? '#app';
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $this->prepareOptions();
        return view('components.forms.tags')
            ->with('campaign', $this->campaign)
            ->with('tags', $this->tags);
    }

    protected function prepareOptions(): void
    {
        $this->tags = [];
        if (!empty($this->model) && $this->model instanceof Entity) {
            foreach ($this->model->tags()->with('entity')->get() as $tag) {
                if ($tag->entity) {
                    $this->tags[$tag->id] = $tag;
                }
            }
        } elseif (!empty($this->model) && !empty($this->model->entity) && !$this->model instanceof Post) {
            foreach ($this->model->entity->tags()->with('entity')->get() as $tag) {
                if ($tag->entity) {
                    $this->tags[$tag->id] = $tag;
                }
            }
        } elseif (!empty($this->model) && ($this->model instanceof \App\Models\CampaignDashboardWidget || $this->model instanceof \App\Models\Post || $this->model instanceof \App\Models\Bookmark || $this->model instanceof \App\Models\Webhook)) {
            foreach ($this->model->tags()->with('entity')->get() as $tag) {
                $this->tags[$tag->id] = $tag;
            }
        } elseif (!empty($this->options) && is_array($this->options)) {
            foreach ($this->options as $tagId) {
                if (!empty($tagId) && is_numeric($tagId)) {
                    $tag = \App\Models\Tag::find($tagId);
                    if ($tag && $tag->entity) {
                        $this->tags[$tag->id] = $tag;
                    }
                }
            }
        } elseif (empty($this->model) && $this->enableAuto) {
            $tags = \App\Models\Tag::autoApplied()->with('entity')->get();
            foreach ($tags as $tag) {
                if ($tag && $tag->entity) {
                    $this->tags[$tag->id] = $tag;
                }
            }
        }
    }
}
