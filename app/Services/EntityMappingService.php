<?php

namespace App\Services;

use App\Models\Campaign;
use App\Models\Entity;
use App\Models\Image;
use App\Models\ImageMention;
use App\Models\EntityMention;
use App\Models\Post;
use App\Models\QuestElement;
use App\Models\TimelineElement;

use App\Traits\MentionTrait;
use Exception;
use Illuminate\Database\Eloquent\Model;

class EntityMappingService
{
    use MentionTrait;

    protected Model|Post|Entity|QuestElement|TimelineElement|Campaign $model;

    protected int $entities;
    protected int $createdImages = 0;
    protected int $updatedImages = 0;
    protected int $deletedImages = 0;

    /**
     * If exceptions should be thrown. Probably not.
     */
    protected bool $throwExceptions = true;

    /**
     * If the app is verbose
     */
    public bool $verbose = false;

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

    /**
     */
    protected function createNewMention(int $target): void
    {
        $mention = new EntityMention();

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
        if (!method_exists($this->model, 'imageMentions')) {
            return $this;
        }
        $images = [];
        if ($this->model instanceof Entity) {
            $images = $this->extractImages($this->entity()->child->entry);
        } elseif ($this->model instanceof Post) {
            $images = $this->extractImages($this->post()->entry);
        }
        $existingTargets = [];
        if ($this->model instanceof Entity) {
            /** @var ImageMention $map */
            foreach ($this->model->imageMentions()->whereNull('post_id')->get() as $map) {
                $existingTargets[$map->image_id] = $map;
            }
        } else {
            foreach ($this->model->imageMentions as $map) {
                $existingTargets[$map->image_id] = $map;
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
                'campaign_id' => $campaignId
            ])->first();
            if (!$target) {
                continue;
            }
            // Don't map the same image multiple times
            if (!empty($existingTargets[$target->id])) {
                if ($this->model instanceof Post && $existingTargets[$target->id]->post_id == $this->model->id) {
                    unset($existingTargets[$target->id]);
                    $this->updatedImages++;
                    continue;
                } elseif ($this->model instanceof Entity && !$existingTargets[$target->id]->post_id) {
                    unset($existingTargets[$target->id]);
                    $this->updatedImages++;
                    continue;
                }
            }
            $this->createNewImageMention($target->id);
        }

        // Existing mappings that are no longer needed
        foreach ($existingTargets as $targetId => $map) {
            $map->delete();
            $this->deletedImages++;
        }

        return $this;
    }

    protected function entry(): self
    {
        $existingTargets = [];
        // @phpstan-ignore-next-line
        foreach ($this->model->mentions as $map) {
            $existingTargets[$map->target_id] = $map;
        }
        $createdMappings = 0;
        $existingMappings = 0;

        if ($this->model instanceof Entity) {
            $mentions = $this->extract($this->entity()->child->entry);
        } else {
            // @phpstan-ignore-next-line
            $mentions = $this->extract($this->model->{$this->model->entryFieldName()});
        }

        foreach ($mentions as $data) {
            $type = $data['type'];
            $id = $data['id'];

            // Old redirects or mapping to something else (like the map of a location) that doesn't have a tooltip
            // But a link to a mention without a title will also break here.
            if ($id == 'redirect') {
                continue;
            }

            $singularType = $type;

            // If we're targeting a campaign, no support for auto-updates
            if ($singularType == 'campaign') {
                continue;
            }
            $singularType = config('entities.ids.' . $singularType);

            // Determine the real campaign id from the model.
            $campaignId = $this->campaignID();

            /** @var ?Entity $target */
            $target = Entity::where([
                'type_id' => $singularType,
                'id' => $id,
                'campaign_id' => $campaignId
            ])->first();
            if (!$target) {
                continue;
            }
            // Do we already have this mention mapped?
            if (!empty($existingTargets[$target->id])) {
                //$this->log("- already have mapping");
                unset($existingTargets[$target->id]);
                $existingMappings++;
                continue;
            }

            $this->createNewMention($target->id);
            $createdMappings++;
        }

        // Existing mappings that are no longer needed
        $deletedMappings = 0;
        foreach ($existingTargets as $targetId => $map) {
            $map->delete();
            $deletedMappings++;
        }

        return $this;
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

    /**
     */
    protected function createNewImageMention(string $target): void
    {
        $mention = new ImageMention();

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

    /**
     */
    protected function log(?string $message = null)
    {
        if (!$this->verbose) {
            return;
        }
        echo $message;
        if (app()->runningInConsole()) {
            echo "\n";
        } else {
            echo "<br />";
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
}
