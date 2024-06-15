<?php

namespace App\Services\Attributes;

use App\Models\Attribute;
use App\Models\AttributeTemplate;
use App\Models\CampaignPlugin;
use App\Traits\CampaignAware;
use App\Traits\EntityAware;

class ApiService
{
    use CampaignAware;
    use EntityAware;

    protected array $attributes = [];


    public function build(): array
    {
        foreach ($this->entity->attributes()->ordered()->get() as $attribute) {
            $this->parseAttribute($attribute);
        }
        return [
            'attributes' => $this->attributes,
            'i18n' => $this->i18n(),
            'meta' => $this->meta(),
            'templates' => $this->templates(),
        ];
    }

    protected function i18n(): array
    {
        return [
            'actions' => [
                'toggle' => __('entities/attributes.actions.toggle_privacy'),
                'load' => __('entities/attributes.template.load.title'),
                'help' => __('crud.actions.help'),
                'search' => __('crud.search'),
                'filters' => __('bookmarks.fields.filters'),
            ],
            'columns' => [
                'attribute' => __('entities/attributes.fields.attribute'),
                'value' => __('entities/attributes.fields.value'),
                'pinned' => __('entities/attributes.fields.is_star'),
                'private' => __('crud.fields.is_private'),
                'delete' => __('crud.permissions.actions.delete'),
                'preferences' => __('entities/attributes.fields.preferences'),
            ],
            'types' => [
                'attribute' => __('entities/attributes.types.attribute'),
                'multiline' => __('entities/attributes.types.text'),
                'number' => __('entities/attributes.types.number'),
                'section' => __('entities/attributes.types.section'),
                'checkbox' => __('entities/attributes.types.checkbox'),
                'random' => __('entities/attributes.types.random'),
            ],
            'filters' => [
                'show_hidden' => __('entities/attributes.actions.show_hidden'),
                'no_results' => __('No results.')
            ],
            'placeholders' => [
                'name' => __('entities/attributes.labels.name'),
                'checkbox_name' => __('entities/attributes.labels.checkbox'),
                'section_name' => __('entities/attributes.labels.section'),
                'multiline_name' => __('entities/attributes.placeholders.block'),
                'value' => __('entities/attributes.placeholders.attribute'),
                'number_value' => __('entities/attributes.placeholders.number'),
            ],
            'toasts' => [
                'no_attributes_selected' => __('entities/attributes.errors.no_attribute_selected'),
                'toggle_deleted' => __('entities/attributes.toasts.bulk_deleted'),
                'toggled_privacy' => __('entities/attributes.toasts.bulk_privacy'),
                'template' => __('entities/attributes.template.load.success'),
            ],
            'templates' => [
                'title' => __('entities/attributes.template.load.title'),
                'template' => __('entities/attributes.fields.template'),
                'load' => __('entities/attributes.actions.load'),
            ]
        ];
    }

    protected function meta(): array
    {
        return [
            'has_hidden' => false,
            'is_admin' => auth()->check() && auth()->user()->isAdmin(),
            'template' => route('templates.load-attributes', $this->campaign)
        ];
    }

    protected function parseAttribute(Attribute $attribute): void
    {
        $formatted = [
            'id' => $attribute->id,
            'name' => $attribute->name,
            'value' => $attribute->value,
            'is_section' => $attribute->isSection(),
            'is_number' => $attribute->isNumber(),
            'is_multiline' => $attribute->isText(),
            'is_checkbox' => $attribute->isCheckbox(),
            'is_random' => $attribute->isRandom(),
            'is_private' => (bool) $attribute->is_private,
            'is_pinned' => $attribute->isPinned(),
            'is_hidden' => (bool) $attribute->is_hidden,
            'is_checked' => false,
            'is_deleted' => false,
        ];

        if ($attribute->isList()) {
            $formatted['values'] = $attribute->listRange();
        }

        $this->attributes[] = $formatted;
    }

    protected function templates(): array
    {
        $templates = [];

        // Campaign templates
        $campaignTemplates = AttributeTemplate::has('entity')
            ->orderBy('name', 'ASC')
            ->pluck('name', 'id');
        $key = __('attributes/templates.list.campaign');
        foreach ($campaignTemplates as $id => $name) {
            $templates[$key][$id] = $name;
        }

        // Kanka templates - deprecated as of 1.30
        //        $key = __('attributes/templates.list.kanka');
        //        foreach (config('attribute-templates.templates') as $code => $class) {
        //            $template = new $class();
        //            $templates[$key][$code] = $template->name();
        //        }

        // If the campaign isn't boosted, or the marketplace isn't enable, end here
        if (!$this->campaign->boosted() || !config('marketplace.enabled')) {
            return $templates;
        }

        // Marketplace campaigns
        $key = __('attributes/templates.list.marketplace');
        // @phpstan-ignore-next-line
        foreach (CampaignPlugin::templates($this->campaign)->with(['plugin', 'plugin.user'])->get() as $plugin) {
            if (empty($plugin->plugin)) {
                continue;
            }
            $templates[$key][$plugin->plugin->uuid] = __('campaigns/plugins.templates.name', [
                'name' => $plugin->name,
                'user' => $plugin->plugin->author()
            ]);
        }

        return $templates;
    }
}
