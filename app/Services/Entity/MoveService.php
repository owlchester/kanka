<?php

namespace App\Services\Entity;

use App\Exceptions\TranslatableException;
use App\Facades\CampaignLocalization;
use App\Models\Campaign;
use App\Models\MiscModel;
use App\Models\Note;
use App\Services\Gallery\StorageService;
use App\Services\MentionsService;
use App\Traits\CampaignAware;
use App\Traits\EntityAware;
use App\Traits\UserAware;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MoveService
{
    use CampaignAware;
    use EntityAware;
    use UserAware;

    protected Campaign $to;

    protected StorageService $storageService;

    protected CopyService $copyService;

    protected MentionsService $mentionsService;

    protected bool $copy = false;

    protected int $count = 0;

    public function __construct(StorageService $storageService, CopyService $copyService, MentionsService $mentionsService)
    {
        $this->storageService = $storageService;
        $this->copyService = $copyService;
        $this->mentionsService = $mentionsService;
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
        /** @var ?Campaign $campaign */
        $campaign = $this->user->campaigns()->where('campaign_id', $this->to->id)->first();
        if (empty($campaign)) {
            throw new TranslatableException('entities/move.errors.unknown_campaign');
        }

        // Check that the new campaign is different from the current one.
        if ($campaign->id == $this->entity->campaign_id) {
            throw new TranslatableException('entities/move.errors.same_campaign');
        }

        // Can the user create an entity of that type on the new campaign?
        // UserCache::campaign($campaign);
        if (! $this->user->can('create', [$this->entity->entityType, $campaign])) {
            throw (new TranslatableException('entities/move.errors.permission'))->setOptions([
                'type' => $this->entity->entityType->name(),
                'target' => '<a href="' . route('dashboard', $campaign) . '">' . $campaign->name . '</a>',
            ]);
        }

        // UserCache::campaign($this->entity->campaign);
        // Trying to move (not copy) but can't update the original entity
        if (! $this->copy && ! $this->user->can('update', $this->entity)) {
            throw new TranslatableException('entities/move.errors.permission_update');
        }

        return $this;
    }

    protected function copyEntity(): bool
    {
        DB::beginTransaction();
        try {
            if ($this->entity->hasChild()) {
                $newModel = $this->entity->child->replicate(['campaign_id']);
                // Remove any foreign keys that wouldn't make any sense in the new campaign
                foreach ($newModel->getAttributes() as $attribute => $value) {
                    if (str_contains($attribute, '_id')) {
                        $newModel->$attribute = null;
                    }
                }
            } else {
                $newModel = new Note;
                $newModel->name = $this->entity->name;
                $newModel->is_private = $this->entity->is_private;
            }

            $newModel->campaign_id = $this->to->id;
            $image = $this->entity->image; // Load the image before switching campaigns
            $newEntry = $this->mentionsService->campaign($this->campaign)->mapCopiedEntry($this->entity->entry);

            CampaignLocalization::forceCampaign($this->to);

            // The model is ready to be saved.
            $newModel->saveQuietly();
            $newModel->createEntity();

            $newModel->entity->entry = $newEntry;
            // Copy the gallery image over
            if (! empty($image)) {
                // If there is enough space in the target campaign gallery
                $available = $this->storageService->campaign($this->campaign)->available();
                if ($available > $image->size) {
                    $newImage = $image->replicate(['id', 'campaign_id']);
                    $newImage->campaign_id = $this->to->id;
                    $newImage->save();

                    Storage::copy($image->path, $newImage->path);

                    $newModel->entity->image_uuid = $newImage->id;
                }
            }
            $newModel->entity->saveQuietly();

            $this->copyService
                ->entity($newModel->entity)
                ->source($this->entity)
                ->force()
                ->posts()
                ->inventory()
                ->attributes()
                ->character()
                ->timeline()
                ->map();

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
            $this->entity->reminders()->delete();
            $this->entity->imageMentions()->delete();

            // Get the child of the entity (the actual Location, Character etc) and remove the permissions, since they
            // won't make sense on the new campaign either.
            /* @var MiscModel $child */
            if ($this->entity->hasChild()) {
                $child = $this->entity->child;
            }
            $this->entity->permissions()->delete();

            // Detach is a custom function on a child to remove itself from where it is parent to other entities.
            if ($this->entity->hasChild()) {
                $this->cleanupChild($child);
            }

            // Update Entity first, as there are no hooks on the Entity model.
            CampaignLocalization::forceCampaign($this->to);
            $this->entity->campaign_id = $this->to->id;
            $this->entity->parent_id = null;
            if (! empty($this->entity->image_path)) {
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
            if ($this->entity->hasChild()) {
                $child->campaign_id = $this->to->id;
                $child->saveQuietly();
            }

            DB::commit();
            $success = true;
        } catch (Exception $e) {
            DB::rollBack();
            if (config('app.debug')) {
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
            if (Str::endsWith($attribute, '_id') && $attribute != 'campaign_id') {
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
