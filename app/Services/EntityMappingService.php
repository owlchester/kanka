<?php

namespace App\Services;

use App\Models\Campaign;
use App\Models\Entity;
use App\Models\EntityMention;
use App\Models\EntityNote;
use App\Models\MiscModel;

use App\Traits\MentionTrait;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class EntityMappingService
{
    use MentionTrait;

    /**
     * If exceptions should be thrown. Probably not.
     * @var bool
     */
    protected bool $throwExceptions = true;

    /**
     * If the app is verbose
     * @var bool
     */
    public bool $verbose = false;

    /**
     * Set errors and verbose to silent
     * @return $this
     */
    public function silent()
    {
        $this->throwExceptions = false;
        $this->verbose = false;
        return $this;
    }


    /**
     * @param Entity $entity
     * @return int
     * @throws Exception
     */
    public function mapEntity(Entity $entity)
    {
        return $this->map($entity);
    }

    /**
     * @param EntityNote $entityNote
     * @throws Exception
     */
    public function mapEntityNote(EntityNote $entityNote)
    {
        return $this->map($entityNote);
    }

    public function mapCampaign(Campaign $campaign)
    {
        return $this->map($campaign);
    }

    /**
     * @param MiscModel|Entity|EntityNote|Campaign $model
     * @return int
     * @throws Exception
     */
    protected function map($model): int
    {
        $existingTargets = [];
        foreach ($model->mentions as $map) {
            $existingTargets[$map->target_id] = $map;
        }
        $createdMappings = 0;
        $existingMappings = 0;

        $mentions = $this->extract($model instanceof Entity ? $model->child->entry : $model->entry);

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
            // Todo: why can't we use CampaignLocalization? Because this was used by the migration script?
            $campaignId = $model->campaign_id;
            if ($model instanceof Campaign) {
                $campaignId = $model->id;
            } elseif ($model instanceof EntityNote) {
                $campaignId = $model->entity->campaign_id;
            }

            /** @var Entity|null $target */
            $target = Entity::where([
                'type_id' => $singularType, 'id' => $id, 'campaign_id' => $campaignId
            ])->first();
            if ($target) {
                //$this->log("- Mentions " . $model->id);
                // Do we already have this mention mapped?
                if (!empty($existingTargets[$target->id])) {
                    //$this->log("- already have mapping");
                    unset($existingTargets[$target->id]);
                    $existingMappings++;
                    continue;
                }

                $this->createNewMention($model, $target->id);
                $createdMappings++;
            }
        }

        // Existing mappings that are no longer needed
        $deletedMappings = 0;
        foreach ($existingTargets as $targetId => $map) {
            $map->delete();
            $deletedMappings++;
        }

        return $createdMappings;
    }

    /**
     * @param MiscModel|EntityNote|Campaign $model
     * @param int $target
     */
    protected function createNewMention($model, int $target)
    {
        $mention = new EntityMention();

        // Determine what kind of entity this is
        if ($model instanceof Campaign) {
            $mention->campaign_id = $model->id;
        } elseif ($model instanceof EntityNote) {
            $mention->entity_note_id = $model->id;

            // If we are making a reference to ourselves, no need to save it
            if ($model->entity_id == $target) {
                return;
            }
        } else {
            $mention->entity_id = $model->id;

            // If we are making a reference to ourselves, no need to save it
            if ($model->id == $target) {
                return;
            }
        }
        $mention->target_id = $target;
        $mention->save();
    }

    /**
     * @param string|null $message
     */
    protected function log(string $message = null)
    {
        if ($this->verbose === true) {
            echo $message;
            if (app()->runningInConsole()) {
                echo "\n";
            } else {
                echo "<br />";
            }
        }
    }
}
