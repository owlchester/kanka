<?php

namespace App\Services\Entity;

use App\Http\Resources\EntityResource;
use App\Http\Resources\Public\CampaignResource;
use App\Traits\CampaignAware;
use App\Traits\EntityAware;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class MarkdownExportService
{
    use CampaignAware;
    use EntityAware;

    protected bool $exportedCampaign = false;

    /**
     * Main function for the Resource to Markdown conversion.
     * 
     * @return string|mixed
     */
    public function markdown()
    {
        //Check if we're exporting a campaign, if so, then export the campaign.
        if (isset($this->campaign) && !$this->exportedCampaign) {
            $resource = new CampaignResource($this->campaign);
            $this->exportedCampaign = true;

            return $this->resourceToMarkdown($resource->toArray(request()));
        }

        //Get the model's resource.
        $child = Str::studly($this->entity->entityType->code);
        $className = 'App\Http\Resources\\' . $child . 'Resource';

        //If its a normal entity type, export it using its own resource, if its a custom, use the entity resource.
        if (class_exists($className)) {
            $resource = new $className($this->entity->child);

            return $this->resourceToMarkdown($resource->withRelated()->toArray(request()));

        } elseif ($this->entity->entityType->isCustom()) {
            $resource = new EntityResource($this->entity);

            return $this->resourceToMarkdown($resource->toArray(request()));

        } else {
            return ['error' => 'unknown resource ' . $className];
        }
    }


    /**
     * Converts a JsonResource to Markdown format
     * 
     * @return string
     */
    protected function resourceToMarkdown(array $data): string
    {
        $markdown = '';

        // If there's a clear title field, adjust accordingly
        if (isset($data['name'])) {
            $markdown .= '## ' . $data['name'] . "\n\n";
            unset($data['name']);
        } else {
            $markdown .= "## Export\n\n";
        }

        if (isset($data['image_full'])) {
            $markdown .= '![avatar](' . $data['image_full'] . ")\n\n";
            unset($data['image_full']);
        }

        //Iterate on each data entry to convert it into a list.
        foreach ($data as $key => $value) {
            $markdown .= '### ' . Str::title(str_replace('_', ' ', $key)) . "\n\n";
            $markdown .= $this->markdownList($value);
            $markdown .= "\n";
        }

        return trim($markdown);
    }

    /**
     * Generate a nested list, according to the array depth.
     * 
     * @return string
     */
    protected function markdownList($data, int $depth = 0): string
    {
        if (empty($data)) {
            return str_repeat('    ', $depth) . "* empty \n";
        }
        // Convert Resource or ResourceCollection to array
        if ($data instanceof JsonResource || $data instanceof AnonymousResourceCollection) {
            $data = $data->toArray(request());
        }

        // Convert Collections
        if ($data instanceof Collection) {
            $data = $data->toArray();
        }

        // Convert Models
        if ($data instanceof Model) {
            $data = $data->toArray();
        }

        // If still not array, now it's safe to render it as a string
        if (! is_array($data)) {
            return str_repeat('    ', $depth) . '* ' . (string) $data . "\n";
        }

        // Determine if associative array
        $isAssoc = array_keys($data) !== range(0, count($data) - 1);

        $markdown = '';

        foreach ($data as $key => $value) {

            // Normalize nested values early
            if ($value instanceof JsonResource || $value instanceof AnonymousResourceCollection) {
                $value = $value->toArray(request());
            }
            if ($value instanceof Collection || $value instanceof Model) {
                $value = $value->toArray();
            }

            // Enums
            if ($value instanceof \BackedEnum) {
                $value = $value->value;
            } elseif ($value instanceof \UnitEnum) {
                $value = $value->name;
            }

            $indent = str_repeat('    ', $depth);

            if (is_array($value)) {
                // Nested section
                if (isset($value['name'])) {
                    $markdown .= "{$indent}* **{$value['name']}**\n";
                    unset($value['name']);
                } else {
                    $markdown .= "{$indent}* **{$key}**\n";
                }
                $markdown .= $this->markdownList($value, $depth + 1);

            } else {
                // Simple value
                if ($isAssoc) {
                    $markdown .= "{$indent}* **{$key}:** " . (string) $value . "\n";
                } else {
                    $markdown .= "{$indent}* " . (string) $value . "\n";
                }
            }
        }

        return $markdown;
    }
}
