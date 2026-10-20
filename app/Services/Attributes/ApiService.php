<?php

namespace App\Services\Attributes;

use App\Models\Attribute;
use App\Models\AttributeTemplate;
use App\Models\CampaignPlugin;
use App\Models\Entity;
use App\Traits\CampaignAware;
use App\Traits\EntityAware;
use App\Traits\EntityTypeAware;
use App\Traits\UserAware;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Number;
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
            'sheets' => $this->sheets(),
            'available_sheets' => $this->availableSheets(),
        ];
    }

    protected function sheets(): array
    {
        if (! isset($this->entity)) {
            return [];
        }
        $sheets = $this->entity->sheets;
        $references = $sheets->where('source', 'marketplace')->pluck('reference');
        $plugins = $references->isEmpty() || ! Schema::hasTable('plugin_versions') ? collect() : DB::table('plugin_versions')
            ->join('plugins', 'plugins.id', '=', 'plugin_versions.plugin_id')
            ->whereIn('plugin_versions.uuid', $references)
            ->get(['plugin_versions.uuid', 'plugins.uuid as plugin_uuid', 'plugins.name'])
            ->keyBy('uuid');

        return $sheets->map(function ($sheet) use ($plugins): array {
            $plugin = $plugins->get($sheet->reference);
            $name = $plugin?->name;
            if ($sheet->source === 'legacy') {
                $template = app(TemplateService::class)->communityTemplate($sheet->reference);
                $name = $template ? $template->name() : $sheet->reference;
            }

            return [
                'id' => $sheet->id,
                'source' => $sheet->source,
                'reference' => $sheet->reference,
                'name' => $name ?: $sheet->reference,
                'plugin_uuid' => $plugin?->plugin_uuid,
            ];
        })->values()->all();
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
                'attribute' => __('entities/attributes.fields.property'),
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
                'templates' => __('entities/attributes.types.kits'),
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
                    'max' => Number::format($this->maxFields()),
                ]),
            ],
            'templates' => [
                'title' => __('entities/attributes.template.load.title'),
                'template' => __('entities/attributes.fields.kit'),
                'load' => __('entities/attributes.actions.load'),
                'helper' => __('entities/attributes.template.pitch'),
            ],
            'sheets' => [
                'title' => __('entities/attributes.sheets.title'),
                'remove' => __('entities/attributes.sheets.remove'),
                'reorder' => __('entities/attributes.sheets.reorder'),
                'description' => __('entities/attributes.sheets.description'),
                'add' => __('entities/attributes.sheets.add'),
                'choose' => __('entities/attributes.sheets.choose'),
                'none_installed' => __('entities/attributes.sheets.none_installed'),
                'all_added' => __('entities/attributes.sheets.all_added'),
                'library' => __('entities/attributes.sheets.library'),
            ],
        ];
    }

    protected function meta(): array
    {
        return [
            'has_hidden' => false,
            'is_admin' => isset($this->user) && $this->user->can('admin', $this->campaign),
            'template' => route('templates.load-attributes', $this->campaign),
            'mentions' => route('search.live', $this->campaign),
            'max' => $this->maxFields(),
            'sheet_library' => config('marketplace.url') . '/character-sheets',
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
            ->with(['entity', 'entity.attributes', 'entity.ancestors'])
            ->enabled()
            ->has('entity')
            ->get();
        /** @var AttributeTemplate $template */
        foreach ($templates as $template) {
            $this->addTemplate($template);
            /** @var AttributeTemplate $child */
            foreach ($template->entity->ancestors()->with('attributeTemplate')->get() as $child) {
                /** @var Entity $child */
                if (! $child->attributeTemplate->isEnabled()) {
                    continue;
                }
                /*if (!in_array($child->id, $ids)) {
                    $ids[] = $child->id;
                    $attributeTemplates[] = $child;
                }*/
                $this->addTemplate($child->attributeTemplate);
            }
        }
    }

    protected function buildPlaceholders(): void
    {
        if (! isset($this->entity)) {
            return;
        }

        foreach ($this->entity->sheets as $sheet) {
            if ($sheet->source !== 'marketplace' || ! Str::isUuid($sheet->reference)) {
                continue;
            }
            $plugin = CampaignPlugin::templates($this->campaign)
                ->whereHas('version', fn ($query) => $query->where('uuid', $sheet->reference))
                ->first();
            if (empty($plugin) || ! $plugin->renderable()) {
                continue;
            }
            foreach ($plugin->version->attributes as $attribute) {
                if (empty($attribute['placeholder'])) {
                    continue;
                }
                $index = $this->attributes->search(fn ($item) => $item['name'] === $attribute['name']);
                if ($index !== false) {
                    $ex = $this->attributes->get($index);
                    if (empty($ex['placeholder'])) {
                        $ex['placeholder'] = $attribute['placeholder'];
                        $this->attributes->put($index, $ex);
                    }
                }
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
                'url' => route('entities.show', [$this->campaign, $template->entity]),
                'text' => trans_choice(
                    'attribute_templates.hints.automatic',
                    $templateTotalAttributes,
                    [
                        'link' => '<a href="' . route('entities.show', [$this->campaign, $template->entity]) . '" class="text-link">' . $template->name . '</a>',
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
            ->orderBy('name', 'asc')
            ->pluck('name', 'id');
        $key = __('entities.attribute_templates');
        foreach ($campaignTemplates as $id => $name) {
            $templates[$key][$id] = $name;
        }

        return $templates;
    }

    protected function availableSheets(): array
    {
        if (! $this->campaign->boosted()
            || ! config('marketplace.enabled')) {
            return [];
        }

        return CampaignPlugin::templates($this->campaign)
            ->select('campaign_plugins.*')
            ->with(['plugin', 'plugin.user'])
            ->get()
            ->filter(fn (CampaignPlugin $plugin) => ! empty($plugin->plugin))
            ->map(fn (CampaignPlugin $plugin) => [
                'id' => $plugin->plugin->uuid,
                'reference' => $plugin->version->uuid,
                'name' => $plugin->plugin->name,
                'author' => $plugin->plugin->author(),
            ])
            ->values()
            ->all();
    }

    /**
     * Get the max amount of fields a form can have
     */
    protected function maxFields(): int
    {
        return app()->isProduction() ? ini_get('max_input_vars') : 200;
    }
}
