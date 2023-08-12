<?php

namespace App\View\Components\Forms;

use App\Models\Campaign;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Tags extends Component
{
    public string $id;
    public bool $allowNew;
    public bool $allowClear;
    public bool $enableAuto;
    public ?string $label;
    public ?string $helper;
    public ?string $dropdownParent;
    public mixed $options;
    public mixed $tags;
    public mixed $model;

    /**
     * Create a new component instance.
     */
    public function __construct(
        Campaign $campaign,
        string $id = null,
        bool $allowNew = false,
        bool $allowClear = false,
        bool $enableAuto = false,
        string $label = null,
        mixed $model = null,
        string $helper = null,
        string $dropdownParent = null,
        mixed $options = [],
    ) {
        $this->campaign = $campaign;
        $this->id = $id ?? 'tags_' . uniqid();
        $this->allowNew = $allowNew;
        $this->allowClear = $allowClear;
        $this->enableAuto = $enableAuto;
        $this->label = $label ?? __('entities.tags');
        $this->helper = $helper;
        $this->dropdownParent = $dropdownParent ?? '#app';
        $this->options = $options;
        $this->model = $model;
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
        if (!empty($this->model) && !empty($this->model->entity)) {
            foreach ($this->model->entity->tags()->with('entity')->get() as $tag) {
                if ($tag->entity) {
                    $this->tags[$tag->id] = $tag;
                }
            }
        } elseif (!empty($this->model) && ($this->model instanceof \App\Models\CampaignDashboardWidget || $this->model instanceof \App\Models\MenuLink)) {
            foreach ($this->model->tags()->get() as $tag) {
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
                if ($tag && $tag->entity) {// @phpstan-ignore-line
                    $this->tags[$tag->id] = $tag;
                }
            }
        }
    }
}
