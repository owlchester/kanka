<?php

namespace App\Services\Attributes;

use App\Models\Attribute;
use App\Models\AttributeTemplate;
use App\Models\CampaignPlugin;
use App\Traits\CampaignAware;
use App\Traits\EntityAware;
use App\Traits\EntityTypeAware;
use App\Traits\UserAware;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class ApiService
{
    use CampaignAware;
    use EntityAware;
    use EntityTypeAware;
    use UserAware;

    protected Collection $attributes;

    protected bool $copy = false;

    protected bool $template = false;

    public function copy(): self
    {
        $this->copy = true;

        return $this;
    }

    public function build(): array
    {
        $this->buildAttributes();

        return [
            'attributes' => $this->attributes->toArray(),
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
                'no_results' => __('No results.'),
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
                'max_reached' => __('entities/attributes.errors.too_many_v2', [
                    'max' => number_format($this->maxFields()),
                ]),
            ],
            'templates' => [
                'title' => __('entities/attributes.template.load.title'),
                'template' => __('entities/attributes.fields.template'),
                'load' => __('entities/attributes.actions.load'),
                'helper' => __('entities/attributes.template.pitch', [
                    'plugin' => '<a href="' . config('marketplace.url') . '/character-sheets">' . __('footer.plugins') . '</a>',
                ]),
            ],
        ];
    }

    protected function meta(): array
    {
        return [
            'has_hidden' => false,
            'is_admin' => isset($this->user) && $this->user->isAdmin(),
            'template' => route('templates.load-attributes', $this->campaign),
            'mentions' => route('search.live', $this->campaign),
            'max' => $this->maxFields(),
        ];
    }

    protected function buildAttributes(): void
    {
        $this->attributes = new Collection;
        if (isset($this->entity)) {
            foreach ($this->entity->attributes()->ordered()->get() as $attribute) {
                $this->parseAttribute($attribute);
            }
        }
        $this->buildAutoTemplates();
        $this->buildPlaceholders();
    }

    protected function buildAutoTemplates(): void
    {
        if (! isset($this->entityType)) {
            return;
        }
        $templates = $this->entityType
            ->attributeTemplates()
            ->with(['entity', 'entity.attributes', 'ancestors'])
            ->has('entity')
            ->get();
        /** @var AttributeTemplate $template */
        foreach ($templates as $template) {
            $this->addTemplate($template);
            /** @var AttributeTemplate $child */
            foreach ($template->ancestors as $child) {
                /*if (!in_array($child->id, $ids)) {
                    $ids[] = $child->id;
                    $attributeTemplates[] = $child;
                }*/
                $this->addTemplate($child);
            }
        }
    }

    protected function buildPlaceholders(): void
    {
        /** @var ?Attribute $layout */
        $layout = $this->attributes->where('name', '_layout')->first();
        if (! $layout || ! Str::isUuid($layout['value'])) {
            return;
        }

        /** @var ?CampaignPlugin $plugin */
        $plugin = CampaignPlugin::templates($this->campaign)
            ->select('campaign_plugins.*')
            ->leftJoin('plugin_versions as pv', 'pv.plugin_id', 'campaign_plugins.plugin_id')
            ->where('pv.uuid', $layout['value'])
            ->has('plugin')
            ->first();

        // If the plugin is published, we're good. Otherwise, it's
        if (empty($plugin) || ! $plugin->renderable()) {
            return;
        }

        foreach ($plugin->version->attributes as $attribute) {
            if (! isset($attribute['placeholder']) || empty($attribute['placeholder'])) {
                continue;
            }
            $index = $this->attributes->search(function ($item) use ($attribute) {
                return $item['name'] === $attribute['name'];
            });
            if ($index !== false) {
                $ex = $this->attributes->get($index);
                $ex['placeholder'] = $attribute['placeholder'];
                $this->attributes->put($index, $ex);
            }
        }
    }

    protected function addTemplate(AttributeTemplate $template): void
    {
        if (! $template->entity) {
            return;
        }
        $first = true;
        $count = $template->entity->attributes->count();
        $this->template = true;
        foreach ($template->entity->attributes()->ordered()->get() as $attribute) {
            $this->parseAttribute($attribute, $first ? $template : null, $count);
            $first = false;
        }
        $this->template = false;

        // Update the helper text of the attribute
    }

    protected function parseAttribute(Attribute $attribute, ?AttributeTemplate $template = null, int $templateTotalAttributes = 0): void
    {
        // If an attribute with the same name already exists, don't add it again
        $existing = $this->attributes->where('name', $attribute->name)->first();
        if ($existing) {
            return;
        }
        $formatted = [
            'id' => $this->copy ? null : $attribute->id,
            'source_id' => $this->template ? $attribute->id : null,
            'name' => $attribute->name,
            'value' => $attribute->isCheckbox() ? (bool) $attribute->value : $attribute->value,
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

        if ($template) {
            $formatted['template'] = [
                'id' => $template->id,
                'name' => $template->name,
                'url' => $template->getLink(),
                'text' => trans_choice(
                    'attribute_templates.hints.automatic',
                    $templateTotalAttributes,
                    [
                        'link' => '<a href="' . $template->getLink() . '">' . $template->name . '</a>',
                        'count' => "<strong>{$templateTotalAttributes}</strong>",
                    ]
                ),
            ];
        }

        $this->attributes->add($formatted);
    }

    protected function templates(): array
    {
        $templates = [];

        // Campaign templates
        $campaignTemplates = AttributeTemplate::has('entity')
            ->enabled()
            ->orderBy('name', 'ASC')
            ->pluck('name', 'id');
        $key = __('attributes/templates.list.campaign');
        foreach ($campaignTemplates as $id => $name) {
            $templates[$key][$id] = $name;
        }

        // If the campaign isn't boosted, or the marketplace isn't enable, end here
        if (! $this->campaign->boosted() || ! config('marketplace.enabled')) {
            return $templates;
        }

        // Marketplace campaigns
        $key = __('attributes/templates.list.sheets');
        foreach (CampaignPlugin::templates($this->campaign)->with(['plugin', 'plugin.user'])->get() as $plugin) {
            if (empty($plugin->plugin)) {
                continue;
            }
            $templates[$key][$plugin->plugin->uuid] = __('campaigns/plugins.templates.name', [
                'name' => $plugin->name,
                'user' => $plugin->plugin->author(),
            ]);
        }

        return $templates;
    }

    /**
     * Get the max amount of fields a form can have
     */
    protected function maxFields(): int
    {
        return app()->isProduction() ? ini_get('max_input_vars') : 200;
    }
}
