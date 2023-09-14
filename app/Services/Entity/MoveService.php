<?php

namespace App\Services\Entity;

use App\Exceptions\TranslatableException;
use App\Facades\CampaignLocalization;
use App\Models\Attribute;
use App\Models\Campaign;
use App\Models\Character;
use App\Models\CharacterTrait;
use App\Models\Post;
use App\Models\MiscModel;
use App\Models\Timeline;
use App\Models\TimelineEra;
use App\Traits\CampaignAware;
use App\Traits\CanFixTree;
use App\Traits\EntityAware;
use App\Traits\UserAware;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Exception;
use Illuminate\Support\Str;

class MoveService
{
    use CampaignAware;
    use CanFixTree;
    use EntityAware;
    use UserAware;


    protected Campaign $to;

    protected bool $copy = false;

    protected int $count = 0;

    public function to(Campaign|int $campaign): self
    {
        if ($campaign instanceof Campaign) {
            $this->to = $campaign;
        } else {
            $this->to = Campaign::findOrFail($campaign);
        }
        return $this;
    }

    public function copy(bool $copy): self
    {
        $this->copy = $copy;
        return $this;
    }

    public function process(): bool
    {
        if ($this->copy) {
            return $this->copyEntity();
        } else {
            return $this->moveEntity();
        }
    }

    public function count(): int
    {
        return $this->count;
    }

    public function target(): Campaign
    {
        return $this->to;
    }

    public function validate(): self
    {
        // First we make sure we have access to the new campaign.
        /** @var Campaign|null $campaign */
        $campaign = $this->user->campaigns()->where('campaign_id', $this->to->id)->first();
        if (empty($campaign)) {
            throw new TranslatableException('entities/move.errors.unknown_campaign');
        }

        // Check that the new campaign is different than the current one.
        if ($campaign->id == $this->entity->campaign_id) {
            throw new TranslatableException('entities/move.errors.same_campaign');
        }

        // Can the user create an entity of that type on the new campaign?
        if (!$this->user->can('create', [get_class($this->entity->child), null, $campaign])) {
            throw new TranslatableException('entities/move.errors.permission');
        }

        // Trying to move (not copy) but can't update the original entity
        if (!$this->copy && !$this->user->can('update', $this->entity->child)) {
            throw new TranslatableException('entities/move.errors.permission_update');
        }

        return $this;
    }

    protected function copyEntity(): bool
    {
        $success = false;

        DB::beginTransaction();
        try {
            $newModel = $this->entity->child->replicate(['campaign_id']);
            $newModel->campaign_id = $this->to->id;
            // Remove any foreign keys that wouldn't make any sense in the new campaign
            foreach ($newModel->getAttributes() as $attribute) {
                if (str_contains($attribute, '_id')) {
                    $newModel->$attribute = null;
                }
            }

            // Copy the image to avoid issues when deleting/replacing one image
            if (!empty($this->entity->child->image)) {
                $uniqid = uniqid();
                $newPath = str_replace('.', $uniqid . '.', $this->entity->child->image);
                $newModel->image = $newPath;
                if (!Storage::exists($newPath)) {
                    Storage::copy($this->entity->child->image, $newPath);
                }
            }

            CampaignLocalization::forceCampaign($this->to);
            $this->fixTree($newModel);

            // The model is ready to be saved.
            $newModel->saveQuietly();
            $newModel->createEntity();

            // Copy posts over
            foreach ($this->entity->posts as $note) {
                /** @var Post $newNote */
                $newNote = $note->replicate(['entity_id', 'created_by', 'updated_by']);
                $newNote->entity_id = $newModel->entity->id;
                $newNote->created_by = auth()->user()->id;
                $newNote->saveQuietly();
            }

            // Attributes please
            foreach ($this->entity->attributes as $attribute) {
                /** @var Attribute $newAttribute */
                $newAttribute = $attribute->replicate(['entity_id']);
                $newAttribute->entity_id = $newModel->entity->id;
                $newAttribute->saveQuietly();
            }

            // Characters: copy traits
            if ($this->entity->child instanceof Character) {
                /** @var CharacterTrait $trait */
                foreach ($this->entity->child->characterTraits as $trait) {
                    $newTrait = $trait->replicate(['character_id']);
                    $newTrait->character_id = $newModel->id;
                    $newTrait->saveQuietly();
                }
            }

            // Timeline: copy eras
            if ($this->entity->child instanceof Timeline) {
                foreach ($this->entity->child->eras as $era) {
                    /** @var TimelineEra $newEra **/
                    $newEra = $era->replicate(['timeline_id']);
                    $newEra->timeline_id = $newModel->id;
                    $newEra->saveQuietly();
                }
            }

            if (request()->has('copy_related_elements') && request()->filled('copy_related_elements')) {
                $this->entity->child->copyRelatedToTarget($newModel);
            }

            DB::commit();
            $success = true;
        } catch (Exception $e) {
            DB::rollBack();
        }

        CampaignLocalization::forceCampaign($this->campaign);
        return $success;
    }

    protected function moveEntity()
    {
        $success = false;
        DB::beginTransaction();
        try {
            // Made it so far, we can move the entity's campaign_id. We first need to remove all the
            // relations and, since they won't make sense on the new campaign.
            $this->entity->relationships()->delete();
            $this->entity->targetRelationships()->delete();
            $this->entity->events()->delete();
            $this->entity->imageMentions()->delete();

            // Get the child of the entity (the actual Location, Character etc) and remove the permissions, since they
            // won't make sense on the new campaign either.
            /* @var MiscModel $child */
            $child = $this->entity->child;
            $this->entity->permissions()->delete();

            // Detach is a custom function on a child to remove itself from where it is parent to other entities.
            $child->detach();

            // Update Entity first, as there are no hooks on the Entity model.
            CampaignLocalization::forceCampaign($this->to);
            $this->entity->campaign_id = $this->to->id;
            $this->entity->saveQuietly();

            $this->fixTree($child);
            // Update child second. We do this otherwise we'll have an old entity and a new one
            $child->campaign_id = $this->to->id;
            if (empty($child->slug)) {
                $child->slug = Str::slug($child->name, '');
            }
            $child->saveQuietly();

            DB::commit();
            $success = true;
        } catch (Exception $e) {
            DB::rollBack();
        }

        CampaignLocalization::forceCampaign($this->campaign);
        return $success;
    }
}
