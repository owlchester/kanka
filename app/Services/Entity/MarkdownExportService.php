<?php

namespace App\Services\Entity;

use App\Traits\CampaignAware;
use App\Traits\EntityAware;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Str;
use League\HTMLToMarkdown\Converter\TableConverter;
use League\HTMLToMarkdown\HtmlConverter;

class MarkdownExportService
{
    use CampaignAware;
    use EntityAware;

    protected array $index = [];

    protected string $module = '';

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

        $entityData = $this->entityData();

        $this->addToIndex();

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
        $entityData['tags'] = '**Tags:** ';
        $entityData['attributes'] = '';
        $entityData['relations'] = '';

        foreach ($this->entity->tags as $tag) {
            $entityData['tags'] .= '[' . $tag->name . '](tags/' . str_replace(' ', '-', $tag->name) . '_' . $tag->id . '),';
        }
        foreach ($this->entity->attributes as $attribute) {
            $entityData['attributes'] .= '* **' . $attribute->name . '**: ' . $attribute->value . '
';
        }

        foreach ($this->entity->relationships as $relation) {
            if ($relation->target->entityType->isCustom()) {
                $entityData['relations'] .= '* [' . $relation->target->name . '](' . str_replace(' ', '-', Str::camel($relation->target->entityType->code)) . '_' . $relation->target->entityType->id . '/' . str_replace(' ', '-', Str::slug($relation->target->name)) . '_' . $relation->target_id . ')
';
            } else {
                $entityData['relations'] .= '* [' . $relation->target->name . '](' . str_replace(' ', '-', $relation->target->entityType->code) . '/' . str_replace(' ', '-', Str::slug($relation->target->name)) . '_' . $relation->target_id . ')
';
            }

        }

        return $entityData;
    }
}
