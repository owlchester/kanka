<?php

namespace App\Renderers\CharacterSheets;

use App\Facades\Avatar;
use App\Facades\Mentions;
use App\Models\Attribute;
use App\Models\CampaignPlugin;
use App\Models\Character;
use App\Models\Entity;
use App\Models\EntityAbility;
use App\Traits\CampaignAware;
use App\Traits\EntityAware;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

abstract class Renderer
{
    use CampaignAware;
    use EntityAware;

    protected CampaignPlugin $campaignPlugin;

    /** @var Collection|Attribute[] */
    protected $entityAttributes;

    /** A list of all the attributes being referenced in the character sheet */
    protected array $templateAttributes = [];

    public function plugin(CampaignPlugin $campaignPlugin): self
    {
        $this->campaignPlugin = $campaignPlugin;

        return $this;
    }

    /**
     * Add the plugin's translations to memory
     */
    protected function loadTranslations(): void
    {
        // Always add the user's locale + en as a fallback
        $userLocale = app()->getLocale();
        $locales = [$userLocale, 'en'];

        foreach ($this->campaignPlugin->version->getTranslationsAttribute() as $translation) {
            if (! in_array($translation['locale'], $locales)) {
                continue;
            }
            $lines['*.' . $translation['base']] = $translation['translation'];

            app('translator')->addLines($lines, $userLocale);
        }
    }

    /**
     * Prepare all the attributes of the entity to be accessible in blade
     */
    protected function prepareEntityData(): array
    {
        $data = [];
        $ids = [];
        $checkboxes = [];
        $this->entityAttributes = $this->entity->allAttributes;
        $allAttributes = [];
        foreach ($this->entityAttributes as $attr) {
            $name = $attr->exposedName(false);
            $data[$name] = $attr->mappedValue();
            $ids[$name] = $attr->id;
            if ($attr->isText()) {
                $data[$name] = nl2br($data[$name]);
            } elseif ($attr->isCheckbox()) {
                $checkboxes[] = $name;
            }
            // dump('mapping ' . $name . ' to ' . $attr->mappedValue());

            // Clean up the name for ranged values
            $allAttributes[$name] = $data[$name];
            unset($this->templateAttributes[$name]);
        }

        // We need this for some blade directives like foreach
        $data['__env'] = app(\Illuminate\View\Factory::class);
        $data['attributes'] = $allAttributes;
        $data['_abilities'] = $this->abilities();

        // Share some attributes to plugin developers
        $data['_locale'] = app()->getLocale();
        $data['_entity_name'] = $this->entity->name;
        $data['_entity_type'] = $this->entity->type;
        $data['_entity_type_name'] = $this->entity->entityType->code;

        if ($this->entity->isCharacter()) {
            /** @var Character $character */
            $character = $this->entity->child;
            $data['_character_title'] = $character->title;
            $data['_character_gender'] = $character->sex;
            $data['_character_age'] = $character->age;
            $data['_character_pronouns'] = $character->pronouns;

            $appearances = $character->appearances;
            $data['_character_appearances'] = $appearances->pluck('entry', 'name')->toArray();
            $traits = $character->personality;
            $data['_character_traits'] = $traits->pluck('entry', 'name')->toArray();
        }

        $tags = [];
        foreach ($this->entity->tags as $tag) {
            $tags[$tag->slug] = $tag->name;
        }
        $data['_tags'] = $tags;

        $data['_superboosted'] = $this->campaign->superboosted();
        $data['_premium'] = $this->campaign->premium();

        // Add any missing attributes to be accessible in blade
        foreach ($this->templateAttributes as $name => $val) {
            if (isset($data[$name])) {
                continue;
            }
            $data[$name] = $val;
        }

        if (! isset($data['openLI'])) {
            $data['openLI'] = '<li>';
        }
        if (! isset($data['closeLI'])) {
            $data['closeLI'] = '</li>';
        }
        if (! isset($data['openOL'])) {
            $data['openOL'] = '<ol>';
        }
        if (! isset($data['closeOL'])) {
            $data['closeOL'] = '</ol>';
        }
        if (! isset($data['openUL'])) {
            $data['openUL'] = '<ul>';
        }
        if (! isset($data['closeUL'])) {
            $data['closeUL'] = '</ul>';
        }

        return [$data, $ids, $checkboxes];
    }

    /**
     * Load abilities of the entity and make them available to blade
     *
     * @throws Exception
     */
    protected function abilities(): array
    {
        $abilities = $this->entity
            ->abilities()
            ->has('ability')
            ->has('ability.entity')
            ->with(['ability', 'ability.parent', 'ability.entity', 'ability.entity.image', 'ability.entity.tags'])
            ->get();
        $data = [];
        /** @var EntityAbility $abi */
        foreach ($abilities as $abi) {
            $tags = [];
            foreach ($abi->ability->entity->tags as $tag) {
                $tags[] = $tag->slug;
            }

            $parent = null;
            if (! empty($abi->ability->parent)) {
                $parent = [
                    'name' => $abi->ability->parent->name,
                    'slug' => Str::slug($abi->ability->parent->name),
                ];
            }

            $ability = [
                'id' => $abi->id,
                'ability_id' => $abi->ability_id,
                'name' => $abi->ability->name,
                'slug' => Str::slug($abi->ability->name),
                'type' => $abi->ability->type,
                'entry' => $abi->ability->entity->parsedEntry(),
                'charges' => $abi->ability->charges,
                'note' => Mentions::mapAny($abi, 'note'),
                'note_raw' => $abi->note,
                'used_charges' => $abi->charges,
                'thumb' => '<img src="' . Avatar::entity($abi->ability->entity)->child($abi->ability)->size(40)->thumbnail() . '" class="ability-thumb"></i>',
                'link' => '<a href="' . $abi->ability->getLink() . '" class="ability-link">' . $abi->ability->name . '</a>',
                'tags' => $tags,
                'parent' => $parent,
            ];
            $data[] = $ability;
        }

        return $data;
    }
}
