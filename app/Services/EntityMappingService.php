<?php

namespace App\Services;

use App\Models\Campaign;
use App\Models\Entity;
use App\Models\EntityMention;
use App\Models\EntityType;
use App\Models\Image;
use App\Models\ImageMention;
use App\Models\Post;
use App\Models\QuestElement;
use App\Models\TimelineElement;
use App\Traits\MentionTrait;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class EntityMappingService
{
    use MentionTrait;

    protected Model|Post|Entity|QuestElement|TimelineElement|Campaign $model;

    protected int $entities;

    protected int $createdImages = 0;

    protected int $updatedImages = 0;

    protected int $deletedImages = 0;

    protected array $entityTypes;

    /**
     * If exceptions should be thrown. Probably not.
     */
    protected bool $throwExceptions = true;

    /**
     * If the app is verbose
     */
    public bool $verbose = false;

    protected array $existingTargets = [];

    /**
     * Set errors and verbose to silent
     */
    public function silent(): self
    {
        $this->throwExceptions = false;
        $this->verbose = false;

        return $this;
    }

    public function with(Model|Post|Entity|QuestElement|TimelineElement|Campaign $model): self
    {
        $this->model = $model;

        return $this;
    }

    /**
     * @throws Exception
     */
    public function map(): self
    {
        return $this
            ->images()
            ->entry();
    }

    protected function createNewMention(int $target): void
    {
        $mention = new EntityMention;

        // Determine what kind of entity this is
        // Todo: should be the model that gives us this info, not for the service to figure out
        if ($this->model instanceof Campaign) {
            $mention->campaign_id = $this->model->id;
        } elseif ($this->model instanceof Post) {
            $mention->post_id = $this->post()->id;
            $mention->entity_id = $this->post()->entity_id;

            // If we are making a reference to ourselves, no need to save it
            if ($this->model->entity_id == $target) {
                return;
            }
        } elseif ($this->model instanceof TimelineElement) {
            $mention->timeline_element_id = $this->model->id;
            $mention->entity_id = $this->model->timeline->entity->id;

            // If we are making a reference to ourselves, no need to save it
            if ($this->model->timeline_id == $target) {
                return;
            }
        } elseif ($this->model instanceof QuestElement) {
            $mention->quest_element_id = $this->model->id;
            $mention->entity_id = $this->model->quest->entity->id;

            // If we are making a reference to ourselves, no need to save it
            if ($this->model->quest_id == $target) {
                return;
            }
        } else {
            // @phpstan-ignore-next-line
            $mention->entity_id = $this->model->id;

            // If we are making a reference to ourselves, no need to save it
            if ($this->model->id == $target) { // @phpstan-ignore-line
                return;
            }
        }
        $mention->target_id = $target;
        $mention->save();
    }

    /**
     * Entities and Posts will track gallery images uses in their text
     */
    protected function images(): self
    {
        if (! method_exists($this->model, 'imageMentions')) {
            return $this;
        }
        $images = [];
        if ($this->model instanceof Entity) {
            $images = $this->extractImages($this->entity()->entry);
        } elseif ($this->model instanceof Post) {
            $images = $this->extractImages($this->post()->entry);
        }
        $this->existingTargets = [];
        if ($this->model instanceof Entity) {
            /** @var ImageMention $map */
            foreach ($this->model->imageMentions()->whereNull('post_id')->get() as $map) {
                $this->existingTargets[$map->image_id] = $map;
            }
        } else {
            foreach ($this->model->imageMentions as $map) {
                $this->existingTargets[$map->image_id] = $map;
            }
        }

        foreach ($images as $data) {
            $id = $data;

            // Determine the real campaign id from the model.
            if ($this->model instanceof Post) {
                $campaignId = $this->post()->entity->campaign_id;
            } else {
                $campaignId = $this->entity()->campaign_id;
            }

            /** @var ?Image $target */
            $target = Image::where([
                'id' => $id,
                'campaign_id' => $campaignId,
            ])->first();
            if (! $target) {
                continue;
            }
            // Don't map the same image multiple times
            if (! empty($this->existingTargets[$target->id])) {
                if ($this->model instanceof Post && $this->existingTargets[$target->id]->post_id == $this->model->id) {
                    unset($this->existingTargets[$target->id]);
                    $this->updatedImages++;

                    continue;
                } elseif ($this->model instanceof Entity && ! $this->existingTargets[$target->id]->post_id) {
                    unset($this->existingTargets[$target->id]);
                    $this->updatedImages++;

                    continue;
                }
            }
            $this->createNewImageMention($target->id);
        }

        // Existing mappings that are no longer needed
        foreach ($this->existingTargets as $targetId => $map) {
            $map->delete();
            $this->deletedImages++;
        }

        return $this;
    }

    protected function entry(): self
    {
        // Build a list of existing targets, so that we delete the unused ones
        $this->existingTargets = $alreadyMentioned = [];
        // @phpstan-ignore-next-line
        foreach ($this->model->mentions as $map) {
            $this->existingTargets[$map->target_id] = $map;
        }

        // @phpstan-ignore-next-line
        $entryMentions = $this->extract($this->model->{$this->model->entryFieldName()});
        // @phpstan-ignore-next-line
        $tooltipMentions = $this->extract($this->model->{$this->model->tooltipFieldName()});
        $mentions = array_merge($tooltipMentions, $entryMentions);
        foreach ($mentions as $data) {
            $type = $data['type'];
            $id = $data['id'];

            // Old redirects or mapping to something else (like the map of a location) that doesn't have a tooltip
            // But a link to a mention without a title will also break here.
            if ($id == 'redirect') {
                continue;
            }
            $id = (int) $id;
            if (empty($id)) {
                continue;
            }

            $singularType = $type;

            // If we're targeting a campaign, no support for auto-updates
            if ($singularType == 'campaign') {
                continue;
            }
            $target = null;

            // Validate that it's either targeting a post, or a valid entity type
            $entityType = $this->getEntityTypeID($singularType);
            if (! $entityType && $singularType !== 'post') {
                continue;
            }

            /** @var ?Entity $target */
            $target = $this->getTarget($id, $entityType);
            if (! $target) {
                continue;
            }

            // If already mentioned, don't create more mentions
            if (in_array($target->id, $alreadyMentioned)) {
                $alreadyMentioned[] = $target->id;

                continue;
            }
            // Do we already have this mention mapped?
            if (! empty($this->existingTargets[$target->id])) {
                $alreadyMentioned[] = $target->id;
                // $this->log("- already have mapping");
                unset($this->existingTargets[$target->id]);

                continue;
            }
            $alreadyMentioned[] = $target->id;

            // If a same target is mentioned multiple times, don't create a new mention each time
            $this->createNewMention($target->id);
        }

        // Existing mappings that are no longer needed
        foreach ($this->existingTargets as $targetId => $map) {
            $map->delete();
        }

        return $this;
    }

    protected function getTarget(int $id, ?int $entityType): ?Entity
    {
        if (! isset($entityType)) {
            $post = Post::with('entity')->where([
                'id' => $id,
            ])->first();
            if ($post && $post->entity && $post->entity->campaign_id === $this->campaignID()) {
                return $post->entity;
            }

            return null;
        }

        return Entity::where([
            'type_id' => $entityType,
            'id' => $id,
            'campaign_id' => $this->campaignID(),
        ])->first();
    }

    protected function campaignID(): int
    {
        // Todo: should be a method on the object or something, not the service's job to figure out
        if ($this->model instanceof Campaign) {
            return $this->model->id;
        } elseif ($this->model instanceof Post) {
            return $this->model->entity->campaign_id;
        } elseif ($this->model instanceof TimelineElement) {
            return $this->model->timeline->campaign_id;
        } elseif ($this->model instanceof QuestElement) {
            return $this->model->quest->campaign_id;
        }

        // @phpstan-ignore-next-line
        return $this->model->campaign_id;
    }

    protected function createNewImageMention(string $target): void
    {
        $mention = new ImageMention;

        // Determine what kind of entity this is
        if ($this->model instanceof Post) {
            $mention->post_id = $this->model->id;
            $mention->entity_id = $this->model->entity_id;
        } elseif ($this->model instanceof Entity) {
            $mention->entity_id = $this->model->id;
        }
        $mention->image_id = $target;
        $mention->save();
        $this->createdImages++;
    }

    protected function log(?string $message = null)
    {
        if (! $this->verbose) {
            return;
        }
        echo $message;
        if (app()->runningInConsole()) {
            echo "\n";
        } else {
            echo '<br />';
        }
    }

    protected function post(): Post
    {
        // @phpstan-ignore-next-line
        return $this->model;
    }

    protected function entity(): Entity
    {
        // @phpstan-ignore-next-line
        return $this->model;
    }

    protected function getEntityTypeID(string $code): ?int
    {
        $this->loadEntityTypes();

        return Arr::get($this->entityTypes, $code);
    }

    protected function loadEntityTypes(): void
    {
        if (isset($this->entityTypes)) {
            return;
        }
        $this->entityTypes = [];
        foreach (EntityType::inCampaign($this->campaignID())->get() as $entityType) {
            $this->entityTypes[$entityType->code] = $entityType->id;
        }
    }
}
