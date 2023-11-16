<?php

namespace App\Services\Campaign\Import;

use App\Facades\ImportIdMapper;
use App\Models\ImageMention;
use App\Models\Post;
use Illuminate\Support\Str;

trait ImportMentions
{
    protected array $imageMentions = [];
    protected function mentions(string|null $text): string|null
    {
        if (empty($text)) {
            return $text;
        }

        $text = preg_replace_callback(
            '`\[([a-z_]+):(.*?)\]`i',
            function ($matches) {
                $segments = explode('|', $matches[2]);
                $oldEntityID = (int) $segments[0];
                $entityType = $matches[1];

                if (!ImportIdMapper::hasEntity($oldEntityID)) {
                    return $matches[0];
                }
                $entityID = ImportIdMapper::getEntity($oldEntityID);

                if (Str::contains($matches[2], '|')) {
                    return '[' . $entityType . ':' . Str::replace($oldEntityID . '|', $entityID . '|', $matches[2] . ']');
                }
                return '[' . $entityType . ':' . $entityID . ']';
            },
            $text
        );

        $images = [];
        preg_match_all('/data-gallery-id="[0-9A-Fa-f]{8}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{12}"/i', $text, $segments);
        foreach ($segments[0] as $key => $type) {
            $id = mb_substr($type, 17, -1);
            if (!in_array($id, $images)) {
                $images[$key] = $id;
            }
        }
        $this->imageMentions = [];
        foreach ($images as $uuid) {
            if (!ImportIdMapper::hasGallery($uuid)) {
                continue;
            }
            $newUuid = ImportIdMapper::getGallery($uuid);
            $text = Str::replace($uuid, $newUuid, $text);
            $text = Str::replace(
                '/campaigns/' . $this->data['campaign_id'] . '/',
                '/campaigns/' . $this->campaign->id . '/',
                $text
            );
            $this->imageMentions[] = $newUuid;
        }

        return $text;
    }

    public function imageMentions(): array
    {
        return $this->imageMentions;
    }

    protected function mapImageMentions(mixed $model): self
    {
        if (empty($this->imageMentions)) {
            return $this;
        }

        foreach ($this->imageMentions as $uuid) {
            $men = new ImageMention();
            $men->entity_id = $this->entity->id;
            $men->image_id = $uuid;
            if ($model instanceof Post) {
                $men->post_id = $model->id;
            }

            $men->save();
        }
        return $this;
    }
}
