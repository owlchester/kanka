<?php

namespace App\Services\Entity;

use App\Models\Entity;
use App\Models\Post;
use App\Models\Relation;
use App\Services\MarkdownMentionsService;
use App\Traits\CampaignAware;
use App\Traits\EntityAware;
use App\Traits\UserAware;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Str;
use League\HTMLToMarkdown\Converter\LinkConverter;
use League\HTMLToMarkdown\Converter\TableConverter;
use League\HTMLToMarkdown\HtmlConverter;

class MarkdownExportService
{
    use CampaignAware;
    use EntityAware;
    use UserAware;

    protected array $index = [];

    protected string $module = '';

    protected bool $isSingle = false;

    public function __construct(
        protected MarkdownMentionsService $markdownMentionsService
    ) {}

    public function single(bool $isSingle = true)
    {
        $this->isSingle = $isSingle;

        return $this;
    }

    /**
     * Main function for the Entity to Markdown conversion.
     *
     * @return string|mixed
     */
    public function markdown()
    {
        $converter = new HtmlConverter;
        $converter->getConfig()->setOption('strip_tags', true);
        $converter->getEnvironment()->addConverter(new TableConverter);
        $converter->getEnvironment()->addConverter(new LinkConverter);
        $entityData = $this->entityData();

        if (! $this->isSingle) {
            $this->addToIndex();
        }

        return Blade::render('entities.markdown.base', ['entity' => $this->entity, 'entityData' => $entityData, 'converter' => $converter, 'campaign' => $this->campaign]);
    }

    public function addToIndex()
    {
        $moduleName = $this->entity->entityType->plural() . '_' . $this->entity->entityType->id;

        if (! isset($this->index[$moduleName])) {
            $this->index[$moduleName] = [];
        }

        $this->index[$moduleName][$this->entity->id] = '* [' . $this->entity->name . '](' . str_replace(' ', '-', $this->module) . '/' . str_replace(' ', '-', Str::slug($this->entity->name)) . '_' . $this->entity->id . ')
';
    }

    public function exportIndex()
    {
        return Blade::render('entities.markdown.index', ['index' => $this->index]);
    }

    public function module(string $module)
    {
        $this->module = $module;

        return $this;
    }

    /**
     * Main function for the Campaign to Markdown conversion.
     *
     * @return string|mixed
     */
    public function campaignMarkdown()
    {
        $converter = new HtmlConverter;
        $converter->getConfig()->setOption('strip_tags', true);
        $converter->getEnvironment()->addConverter(new TableConverter);

        return Blade::render('campaigns.markdown', ['converter' => $converter, 'campaign' => $this->campaign]);
    }

    public function entityData()
    {
        // Move to service
        $entityData = [];
        $entityData['tags'] = [];
        $entityData['attributes'] = '';
        $entityData['relations'] = '';
        $entityData['locations'] = [];
        $entityData['pinnedAliases'] = [];
        $entityData['entry'] = $this->markdownEntry();
        $entityData['posts'] = [];
        $entityData['parent'] = '';
        $entityData['characterFamilies'] = [];
        $entityData['characterRaces'] = [];
        $entityData['characterOrganisations'] = [];

        if ($this->entity->parent) {
            $parent = $this->entity->parent;
            $parentName = html_entity_decode($parent->name, ENT_QUOTES, 'UTF-8');

            if ($this->isSingle) {
                $entityData['parent'] = '[' . $parentName . '](' . $parent->url() . ')';
            } elseif ($parent->entityType->isCustom()) {
                $moduleName = $parent->entityType->code . '_' . $parent->entityType->id;
                $entityData['parent'] = '[' . $parentName . '](' . Str::slug($moduleName) . '/' . Str::slug($parent->name) . '_' . $parent->id . ')';
            } else {
                $entityData['parent'] = '[' . $parentName . '](' . str_replace(' ', '-', $parent->entityType->pluralCode()) . '/' . Str::slug($parent->name) . '_' . $parent->id . ')';
            }
        }

        if ($this->isSingle) {
            foreach ($this->entity->tags as $tag) {
                $entityData['tags'][] = '[' . html_entity_decode($tag->entity->name, ENT_QUOTES, 'UTF-8') . '](' . $tag->entity->url() . ')';
            }
        } else {
            foreach ($this->entity->tags as $tag) {
                $entityData['tags'][] = '[' . html_entity_decode($tag->entity->name, ENT_QUOTES, 'UTF-8') . '](tags/' . Str::slug($tag->entity->name) . '_' . $tag->entity->id . ')';
            }
        }

        foreach ($this->entity->locations as $location) {
            $locationName = html_entity_decode($location->entity->name, ENT_QUOTES, 'UTF-8');
            $entityData['locations'][] = $this->isSingle
                ? '[' . $locationName . '](' . $location->entity->url() . ')'
                : $locationName;
        }

        foreach ($this->entity->pinnedAliases as $asset) {
            $entityData['pinnedAliases'][] = $asset->name;
        }

        foreach ($this->entity->posts as $post) {
            if (! $post->layout_id) {
                $entityData['posts'][$post->id] = $this->markdownPost($post);
            }
        }

        foreach ($this->entity->attributes as $attribute) {
            $entityData['attributes'] .= '* **' . $attribute->name . '**: ' . html_entity_decode($attribute->value, ENT_QUOTES, 'UTF-8') . '
';
        }

        foreach ($this->entity->allRelationships as $relation) {
            $entityData['relations'] .= $this->markdownRelation($relation);
        }

        if ($this->entity->isCharacter() && $this->entity->child) {
            $character = $this->entity->child;

            foreach ($character->characterFamilies->unique('family_id') as $characterFamily) {
                if ($characterFamily->family?->entity) {
                    $entityData['characterFamilies'][] = $this->entityLink($characterFamily->family->entity);
                }
            }

            foreach ($character->characterRaces->unique('race_id') as $characterRace) {
                if ($characterRace->race?->entity) {
                    $entityData['characterRaces'][] = $this->entityLink($characterRace->race->entity);
                }
            }

            $character->loadMissing('organisationMemberships.organisation.entity');
            foreach ($character->organisationMemberships as $membership) {
                if (! $membership->organisation?->entity) {
                    continue;
                }

                $organisation = $this->entityLink($membership->organisation->entity);
                if (! empty($membership->role)) {
                    $organisation .= ' (' . html_entity_decode($membership->role, ENT_QUOTES, 'UTF-8') . ')';
                }
                $entityData['characterOrganisations'][] = $organisation;
            }
        }

        return $entityData;
    }

    protected function markdownRelation(Relation $relation): string
    {
        if (! $relation->target) {
            return '';
        }

        $role = html_entity_decode($relation->relation, ENT_QUOTES, 'UTF-8');

        return '* **' . $role . '**: ' . $this->entityLink($relation->target) . "\n";
    }

    protected function entityLink(Entity $entity): string
    {
        $name = html_entity_decode($entity->name, ENT_QUOTES, 'UTF-8');
        if ($this->isSingle) {
            return '[' . $name . '](' . $entity->url() . ')';
        }

        if ($entity->entityType->isCustom()) {
            $moduleName = $entity->entityType->code . '_' . $entity->entityType->id;
        } else {
            $moduleName = $entity->entityType->pluralCode();
        }

        return '[' . $name . '](' . str_replace(' ', '-', Str::slug($moduleName)) . '/' . Str::slug($entity->name) . '_' . $entity->id . ')';
    }

    /**
     * Get the entry where mentions are made to look nice for the text editor
     */
    public function markdownEntry(): string
    {
        if (isset($this->user)) {
            $this->markdownMentionsService->user($this->user);
        }

        return $this->markdownMentionsService->single($this->isSingle)->parseForMarkdown($this->entity);
    }

    /**
     * Get the entry where mentions are made to look nice for the text editor
     */
    public function markdownPost(Post $post): string
    {
        if (isset($this->user)) {
            $this->markdownMentionsService->user($this->user);
        }

        return $this->markdownMentionsService->single($this->isSingle)->parseForMarkdown($post);
    }
}
