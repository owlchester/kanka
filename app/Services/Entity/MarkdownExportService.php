<?php

namespace App\Services\Entity;

use App\Models\Post;
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
        $converter->getEnvironment()->addConverter(new TableConverter, new LinkConverter);

        $entityData = $this->entityData();

        if (!$this->isSingle) {
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
        $entityData['pinnedAliases'] = [];
        $entityData['entry'] = $this->markdownEntry();
        $entityData['posts'] = [];

        if ($this->isSingle) {
            foreach ($this->entity->tags as $tag) {
                $entityData['tags'][] = '[' . $tag->name . '](' . $tag->entity->url() . ')';
            }
        } else {
            foreach ($this->entity->tags as $tag) {
                $entityData['tags'][] = '[' . $tag->name . '](tags/' . Str::slug($tag->name) . '_' . $tag->entity->id . ')';
            }
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
            $entityData['attributes'] .= '* **' . $attribute->name . '**: ' . $attribute->value . '
';
        }

        if ($this->isSingle) {
            foreach ($this->entity->relationships as $relation) {
                    $entityData['relations'] .= '* [' . $relation->target->name . '](' . $relation->target->url() . ')
';
            }
        } else {
            foreach ($this->entity->relationships as $relation) {
                if ($relation->target->entityType->isCustom()) {
                    $moduleName = $relation->target->entityType->code . '_' . $relation->target->entityType->id;

                    $entityData['relations'] .= '* [' . $relation->target->name . '](' . Str::slug($moduleName) . '/' . Str::slug($relation->target->name) . '_' . $relation->target_id . ')
';
                } else {
                    $entityData['relations'] .= '* [' . $relation->target->name . '](' . str_replace(' ', '-', $relation->target->entityType->pluralCode()) . '/' . Str::slug($relation->target->name) . '_' . $relation->target_id . ')
';
                }
            }
        }

        return $entityData;
    }

    /**
     * Get the entry where mentions are made to look nice for the text editor
     */
    public function markdownEntry(): string
    {
        return $this->markdownMentionsService->user($this->user)->single($this->isSingle)->parseForMarkdown($this->entity);
    }

    /**
     * Get the entry where mentions are made to look nice for the text editor
     */
    public function markdownPost(Post $post): string
    {
        return $this->markdownMentionsService->user($this->user)->single($this->isSingle)->parseForMarkdown($post);
    }
}
