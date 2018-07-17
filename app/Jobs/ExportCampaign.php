<?php

namespace App\Jobs;

use App\Campaign;
use App\Mail\CampaignExportMail;
use App\Notifications\Header;
use App\Services\EntityService;
use App\User;
use http\Url;
use Illuminate\Bus\Queueable;
use Illuminate\Http\File;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Exception;

class ExportCampaign implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Campaign $campaign, User $user, EntityService $entityService)
    {
        $this->campaign = $campaign;
        $this->user = $user;
        $this->entity = $entityService;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // If the campaign already has a backup, remove it.
        if (!empty($this->campaign->export_path)) {
            Storage::delete($this->campaign->export_path);
            $this->campaign->export_path = null;
            $this->campaign->save();
        }

        $zipName = storage_path() . '/exports/campaigns/campaign_' . $this->campaign->id . '_' .  uniqid() . '.zip';
        $zipper = new \Chumper\Zipper\Zipper;
        $zipper->make($zipName);

        $zipper->addString('campaign.json', $this->campaign->toJson());

        foreach ($this->entity->entities() as $entity => $class) {
            if ($this->campaign->enabled($entity) && method_exists($class, 'export')) {
                try {
                    $property = Str::camel($entity);
                    foreach ($this->campaign->$property()->with('entity')->get() as $model) {
                        $zipper->addString($entity . '/' . str_slug($model->name) . '.json', $model->export());
                        if (!empty($model->image) && Storage::exists($model->image)) {
                            $zipper->addString($model->image, Storage::get($model->image));
                        }
                    }
                } catch(Exception $e) {
                    unlink($zipName);
                    throw new Exception('Missing campaign entity relation: ' . $entity . '-' . $class . '? ' . $e->getMessage());
                }
            }
        }

        // Save all the content.
        $zipper->close();

        // Move to ?
        $downloadPath = Storage::putFile('exports/campaigns', new File($zipName), 'public');
        $zipper->delete();
        unlink($zipName);

        // Email ?
        $this->user->notify(new Header(
            'campaign.export',
            'download',
            'green',
            ['link' => Storage::url($downloadPath)]
        ));

        // Save the new path.
        $this->campaign->export_path = $downloadPath;
        $this->campaign->save();

        CampaignExportCleanup::dispatch($this->campaign)->delay(now()->addMinutes(30));
    }

    public function failure()
    {
        // Sentry will handle this
    }
}
