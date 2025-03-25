<?php

namespace App\Jobs\Copyright;

use App\Facades\Avatar;
use App\Facades\Images;
use App\Models\Campaign;
use App\Models\Entity;
use App\Services\Campaign\Notifications\ImageRemoveService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class DeleteEntityImage implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    protected $entityId;

    protected $removeHeader;

    protected $removeImage;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->entityId = $data['entity'];
        $this->removeHeader = $data['remove_header'];
        $this->removeImage = $data['remove_image'];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Most basic setup, the child has an image, otherwise, might have a gallery image
        if ($this->removeImage) {
            $this->deleteImage('image');
        }
        if ($this->removeHeader) {
            $this->deleteImage('header_image');
        }
        Log::info('Removed image or header from entity #' . $this->entityId . ' for copyright reasons');
    }

    private function deleteImage(string $field)
    {
        /** @var Entity $entity */
        $entity = Entity::find($this->entityId);

        if (empty($entity) || empty($entity->child)) {
            // Entity was deleted
            return;
        }
        /** @var ImageRemoveService $service */
        $service = app()->make(ImageRemoveService::class);
        $campaign = Campaign::find($entity->campaign_id);

        $service->campaign($campaign)->entity($entity)->notify();

        if ($campaign->superboosted() && $entity->image && $field == 'image') {
            $entity->image->delete();
        } elseif (! empty($entity->image_path) && $field == 'image') {
            Images::cleanup($entity, $field);
            $entity->updateQuietly(['image_path' => '']);
        }

        if ($campaign->superboosted() && $entity->header && $field == 'header_image') {
            $entity->header->delete();
        } elseif (! empty($entity->header_image) && $field == 'header_image') {
            Images::cleanup($entity, $field);
            $entity->update(['header_image' => $entity->header_image]);
        }

        // Whenever an entity is updated, we always want to re-calculate the cached image.
        Avatar::entity($entity)->forget();
    }
}
