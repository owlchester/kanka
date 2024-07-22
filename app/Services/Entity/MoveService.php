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
use App\Services\Campaign\GalleryService;
use App\Traits\CampaignAware;
use App\Traits\EntityAware;
use App\Traits\UserAware;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Exception;
use Illuminate\Support\Str;

class MoveService
{
    use CampaignAware;
    use EntityAware;
    use UserAware;


    protected Campaign $to;

    protected GalleryService $galleryService;

    protected bool $copy = false;

    protected int $count = 0;

    public function __construct(GalleryService $galleryService)
    {
        $this->galleryService = $galleryService;
    }

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

        // Check that the new campaign is different from the current one.
        if ($campaign->id == $this->entity->campaign_id) {
            throw new TranslatableException('entities/move.errors.same_campaign');
        }

        // Can the user create an entity of that type on the new campaign?
        //UserCache::campaign($campaign);
        if (!$this->user->can('create', [get_class($this->entity->child), null, $campaign])) {
            throw new TranslatableException('entities/move.errors.permission');
        }

        //UserCache::campaign($this->entity->campaign);
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
            // Remove any foreign keys that wouldn't make any sense in the new campaign
            foreach ($newModel->getAttributes() as $attribute => $value) {
                if (str_contains($attribute, '_id')) {
                    $newModel->$attribute = null;
                }
            }
            $newModel->campaign_id = $this->to->id;
            $image = $this->entity->image; // Load the image before switching campaigns

            CampaignLocalization::forceCampaign($this->to);

            // The model is ready to be saved.
            $newModel->saveQuietly();
            $newModel->createEntity();

            // Copy the image to avoid issues when deleting/replacing one image
            //            if (!empty($this->entity->image_path)) {
            //                $uniqid = uniqid();
            //                // If the image is in the w folder, just copy the image to the new world folder
            //                if (Str::contains('w/' . $this->entity->campaign_id, $this->entity->image_path)) {
            //                    $newPath = Str::replace(
            //                        'w/' . $this->entity->campaign_id,
            //                        'w/' . $this->to->id,
            //                        $this->entity->image_path
            //                    );
            //                } else {
            //                    $newPath = Str::replace('.', $uniqid . '.', $this->entity->image_path);
            //                }
            //                $newModel->entity->image_path = $newPath;
            //                $newModel->entity->saveQuietly();
            //                if (!Storage::exists($newPath)) {
            //                    Storage::copy($this->entity->image_path, $newPath);
            //                }
            //            }

            // Copy the gallery image over
            if (!empty($image)) {
                // If there is enough space in the target campaign gallery
                $available = $this->galleryService->campaign($this->campaign)->available();
                if ($available > $image->size) {
                    $newImage = $image->replicate(['campaign_id']);
                    $newImage->campaign_id = $this->to->id;
                    $newImage->id = Str::uuid()->toString();
                    $newImage->save();

                    Storage::copy($image->path, $newImage->path);

                    $newModel->entity->image_uuid = $newImage->id;
                    $newModel->entity->saveQuietly();
                }
            }

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

            if (
                request()->has('copy_related_elements') &&
                request()->filled('copy_related_elements') &&
                method_exists($this->entity->child, 'copyRelatedToTarget')) {
                $this->entity->child->copyRelatedToTarget($newModel);
            }

            DB::commit();
            $success = true;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }

        CampaignLocalization::forceCampaign($this->campaign);
        return $success;
    }

    protected function moveEntity(): bool
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
            $this->cleanupChild($child);

            // Update Entity first, as there are no hooks on the Entity model.
            CampaignLocalization::forceCampaign($this->to);
            $this->entity->campaign_id = $this->to->id;
            if (!empty($this->entity->image_path)) {
                $oldImagePath = $this->entity->image_path;
                $this->entity->image_path = Str::replace(
                    'w/' . $this->campaign->id . '/',
                    'w/' . $this->to->id . '/',
                    $oldImagePath
                );
                Storage::move($oldImagePath, $this->entity->image_path);
            }
            $this->entity->saveQuietly();

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
            if (app()->isLocal()) {
                throw $e;
            }
        }

        CampaignLocalization::forceCampaign($this->campaign);
        return $success;
    }

    protected function cleanupChild(MiscModel $model)
    {
        // Loop on children attributes and detach.
        $attributes = $model->getAttributes();
        foreach ($attributes as $attribute => $value) {
            if (Str::endsWith($attribute, '_id')  && $attribute != 'campaign_id') {
                $model->$attribute = null;
            }
        }

        // If they have nested children, look for the direct children
        if (method_exists($model, 'children') && method_exists($this, 'getParentKeyName')) {
            // @phpstan-ignore-next-line
            foreach ($model->children as $child) {
                $parentField = $child->getParentKeyName();
                $child->$parentField = null;
                $child->saveQuietly();
            }
        }

        if (method_exists($model, 'detach')) {
            $model->detach();
        }
        $model->saveQuietly();
    }
}
