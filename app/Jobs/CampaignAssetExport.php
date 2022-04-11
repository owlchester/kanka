<?php

namespace App\Jobs;

use App\Facades\CampaignCache;
use App\Models\Campaign;
use App\Models\MiscModel;
use App\Notifications\Header;
use App\Services\EntityService;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Http\File;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use ZipArchive;
use Exception;

class CampaignAssetExport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 1;

    /**
     * @var Campaign
     */
    protected $campaign;

    /**
     * @var User
     */
    protected $user;

    /**
     * @var EntityService
     */
    protected $entity;

    /**
     * CampaignExport constructor.
     * @param Campaign $campaign
     * @param User $user
     */
    public function __construct(Campaign $campaign, User $user)
    {
        $this->campaign = $campaign;
        $this->user = $user;
    }

    /**
     * Execute the job
     * @throws Exception
     */
    public function handle()
    {
        $this->entity = app()->make(EntityService::class);

        // We want the full path for jobs running in the queue.
        $zipName = 'campaign_' . $this->campaign->id . '_' .  uniqid() . '_' . date('Ymd_His') . '_assets.zip';
        CampaignCache::campaign($this->campaign);
        $pathName = storage_path() . '/exports/campaigns/' . $zipName;
        $zip = new ZipArchive();
        $zip->open($pathName, ZipArchive::CREATE);

        $files = 0;
        foreach ($this->entity->entities() as $entity => $class) {
            if (!$this->campaign->enabled($entity) || !method_exists($class, 'export')) {
                continue;
            }
            try {
                /** @var MiscModel $model */
                $property = Str::camel($entity);
                foreach ($this->campaign->$property()->with('entity')->get() as $model) {
                    if (!empty($model->image) && Storage::exists($model->image)) {
                        $zip->addFromString($model->image, Storage::get($model->image));
                        $files++;
                    }

                    // Boosted image?
                    if (!empty($model->entity->header_image) && Storage::exists($model->entity->header_image)) {
                        $zip->addFromString($model->entity->header_image, Storage::get($model->entity->header_image));
                        $files++;
                    }

                    // Locations have maps
                    if ($model->getEntityType() == 'location' && !empty($model->map)
                        && Storage::exists($model->map)) {
                        $zip->addFromString($model->map, Storage::get($model->map));
                        $files++;
                    }
                }
            } catch (Exception $e) {
                $zip->close();
                unlink($pathName);
                throw new Exception(
                    'Missing campaign entity relation: ' . $entity . '-' . $class . '? '
                    . $e->getMessage()
                );
            }
        }

        // Save all the content.
        try {
            $zip->close();
        } catch (Exception $e) {
            // The export might fail if the zip is too big.
            $files = 0;
        }

        // No files generated? End the process
        if ($files === 0) {
            return;
        }

        // Move to ?
        $downloadPath = Storage::putFileAs('exports/campaigns', new File($pathName), $zipName, 'public');
        unlink($pathName);

        $this->user->notify(new Header(
            'campaign.asset_export',
            'download',
            'green',
            ['link' => Storage::url($downloadPath), 'time' => 60]
        ));

        // Don't delete in "sync" mode as there is no delay.
        $queue = config('queue.default');
        if ($queue != 'sync') {
            CampaignAssetExportCleanup::dispatch($downloadPath)->delay(now()->addMinutes(60));
        }
    }

    /**
     *
     */
    public function failed(Exception $exception)
    {
        // Notify the user that something went wrong
        $this->user->notify(new Header(
            'campaign.asset_export_error',
            'times',
            'red'
        ));
    }
}
