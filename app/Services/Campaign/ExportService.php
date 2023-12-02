<?php

namespace App\Services\Campaign;

use App\Facades\CampaignCache;
use App\Jobs\Campaigns\Export;
use App\Models\Entity;
use App\Models\EntityAsset;
use App\Models\Image;
use App\Models\CampaignExport;
use App\Models\Map;
use App\Notifications\Header;
use App\Traits\CampaignAware;
use App\Traits\UserAware;
use Exception;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Zip;

class ExportService
{
    use CampaignAware;
    use UserAware;

    protected string $exportPath;

    protected string $path;
    protected string $file;

    protected $archive;

    protected bool $assets = false;

    protected int $files = 0;
    protected int $filesize = 0;

    protected string $version = '3.0.0';

    protected CampaignExport $log;

    protected int $totalElements;
    protected int $currentElements;

    public function exportPath(): string
    {
        return $this->exportPath;
    }

    public function log(CampaignExport $campaignExport): self
    {
        $this->log = $campaignExport;
        return $this;
    }

    public function assets(bool $assets): self
    {
        $this->assets = $assets;
        return $this;
    }

    public function queue(): self
    {
        $this->campaign->export_date = date('Y-m-d');
        $this->campaign->saveQuietly();

        $entitiesExport = CampaignExport::create([
            'campaign_id' => $this->campaign->id,
            'created_by' => $this->user->id,
            'type' => CampaignExport::TYPE_ENTITIES,
            'status' => CampaignExport::STATUS_SCHEDULED,
        ]);

        Export::dispatch($this->campaign, $this->user, $entitiesExport, false);

        return $this;
    }

    public function export(): self
    {
        try {
            $this
                ->prepare()
                ->info()
                ->campaignJson()
                ->entities()
                ->gallery()
                ->finish()
                ->notify();

            $this->log
                ->update([
                    'status' => CampaignExport::STATUS_FINISHED,
                    'size' => $this->filesize(),
                    'path' => $this->exportPath(),
                ]);
        } catch (Exception $e) {
            $this->log
                ->update([
                    'status' => CampaignExport::STATUS_FAILED,
                ]);
            throw $e;
        }

        return $this;
    }

    public function filesize(): int
    {
        return $this->filesize;
    }

    protected function prepare(): self
    {
        $this->exportPath = '/exports/campaigns/';
        $saveFolder = storage_path($this->exportPath);
        File::ensureDirectoryExists($saveFolder);

        // We want the full path for jobs running in the queue.
        $this->file = $this->campaign->id . '_' . date('Ymd_His') . ($this->assets ? '_assets' : null) . '.zip';
        CampaignCache::campaign($this->campaign);
        $this->path = $saveFolder . $this->file;
        $this->archive = Zip::create($this->file);

        // Count the number of elements to export to get a rough idea of progress
        $this->totalElements =
            Entity::where('campaign_id', $this->campaign->id)->count() +
            Image::where('campaign_id', $this->campaign->id)->count() +
            1 // Campaign json;
        ;
        $this->currentElements = 0;

        return $this;
    }

    protected function info(): self
    {
        $info = [
            'kanka_version' => config('app.version'),
            'export_version' => $this->version,
            'started' => date('Y-m-d H:i:s'),
        ];
        $this->archive->addRaw(json_encode($info), 'info.json');
        return $this;
    }
    protected function campaignJson(): self
    {
        $this->archive->addRaw($this->campaign->toJson(), 'campaign.json');
        $this->files++;
        //Log::info("wat", ['path' => 's3://' . config('filesystems.disks.s3.bucket') . '/' . Storage::path($this->campaign->image)]);
        if (!$this->assets) {
            //return $this;
        }
        if (!empty($this->campaign->image) && Storage::exists($this->campaign->image)) {
            $this->archive->add('s3://' . config('filesystems.disks.s3.bucket') . '/' . Storage::path($this->campaign->image), $this->campaign->image);
            $this->files++;
        }
        if (!empty($this->campaign->header_image) && Storage::exists($this->campaign->header_image)) {
            $this->archive->add('s3://' . config('filesystems.disks.s3.bucket') . '/' . Storage::path($this->campaign->header_image), $this->campaign->header_image);
            $this->files++;
        }

        $this->progress();

        return $this;
    }

    protected function entities(): self
    {
        $entityWith = [
            'entity',
            'entity.entityTags', 'entity.relationships',
            'entity.posts', 'entity.abilities', 'entity.abilities.ability',
            'entity.events',
            'entity.image',
            'entity.header',
            'entity.assets',
            'entity.mentions',
            'entity.inventories',
            'entity.entityAttributes',
        ];
        $entities = config('entities.classes-plural');
        foreach ($entities as $entity => $class) {
            if (!$this->campaign->enabled($entity) || !method_exists($class, 'export')) {
                continue;
            }
            try {
                $property = Str::camel($entity);
                foreach ($this->campaign->$property()->with($entityWith)->has('entity')->get() as $model) {
                    $this->process($entity, $model);
                }
            } catch (Exception $e) {
                Log::error('Campaign export', ['err' => $e->getMessage()]);
                $saveFolder = storage_path($this->exportPath);
                $this->archive->saveTo($saveFolder);
                unlink($this->path);
                throw new Exception(
                    'Missing campaign entity relation: ' . $entity . '-' . $class . '? '
                    . $e->getMessage()
                );
            }
        }
        return $this;
    }

    protected function gallery(): self
    {
        foreach ($this->campaign->images()->with('imageFolder')->get() as $image) {
            try {
                $this->processImage($image);
            } catch (Exception $e) {
                $saveFolder = storage_path($this->exportPath);
                $this->archive->saveTo($saveFolder);
                unlink($this->path);
                throw new Exception(
                    $e->getMessage()
                );
            }
        }
        return $this;
    }

    protected function processImage(Image $image): self
    {
        if (!$this->assets) {
            $this->archive->add($image->export(), 'gallery/' . $image->id . '.json');
            $this->files++;
            //return $this;
        }

        if (!$image->isFolder()) {
            $this->archive->add('s3://' . config('filesystems.disks.s3.bucket') . '/' . Storage::path($image->path), 'gallery/' . $image->id . '.' . $image->ext);
            $this->files++;
        }
        $this->progress();
        return $this;
    }

    protected function process(string $entity, $model): self
    {
        if (!$this->assets) {
            $this->archive->add($model->export(), $entity . '/' . Str::slug($model->name) . '.json', );
            $this->files++;
            //return $this;
        }

        $path = $model->entity->image_path;
        if (!empty($path) && !Str::contains($path, '?') && Storage::exists($path)) {
            $this->archive->add('s3://' . config('filesystems.disks.s3.bucket') . '/' . Storage::path($path), $path);
            $this->files++;
        }
        $path = $model->entity->header_image;
        if (!empty($path) && !Str::contains($path, '?') && Storage::exists($path)) {
            $this->archive->add('s3://' . config('filesystems.disks.s3.bucket') . '/' . Storage::path($path), $path);
            $this->files++;
        }

        /** @var EntityAsset $file */
        foreach ($model->entity->files as $file) {
            $path = $file->metadata['path'];
            if (!Storage::exists($path)) {
                continue;
            }
            $this->archive->add('s3://' . config('filesystems.disks.s3.bucket') . '/' . Storage::path($path), $path);
        }

        if ($model instanceof Map) {
            foreach ($model->layers as $layer) {
                $path = $layer->image;
                if (!Storage::exists($path)) {
                    continue;
                }
                $this->archive->add('s3://' . config('filesystems.disks.s3.bucket') . '/' . Storage::path($path), $path);
            }
        }

        $this->progress();
        return $this;
    }

    protected function notify(): self
    {
        $this->user->notify(new Header(
            'campaign.' . ($this->assets ? 'asset_export' : 'export'),
            'download',
            'green',
            [
                'link' => route('campaign.export', $this->campaign),
                'time' => 60,
                'campaign' => $this->campaign->name,
            ]
        ));
        return $this;
    }

    protected function finish(): self
    {
        // Save all the content.
        try {
            $saveFolder = storage_path($this->exportPath);
            Log::info('Campaign export', ['path' => $saveFolder, 'exportPath' => $this->exportPath]);
            $this->archive->saveTo($saveFolder);
            $this->filesize = (int) floor(filesize($this->path) / pow(1024, 2));
        } catch (Exception $e) {
            Log::error('Campaign export', ['err' => $e->getMessage()]);
            // The export might fail if the zip is too big.
            $this->files = 0;
            throw new Exception($e->getMessage());
        }
        if ($this->files === 0) {
            return $this;
        }

        // Move to ?
        $this->exportPath = Storage::putFileAs('exports/campaigns/' . $this->campaign->id, $this->path, $this->file, 'public');
        unlink($this->path);

        return $this;
    }

    /**
     * Track that the export had an issue
     * @return $this
     */
    public function fail(): self
    {
        if (!$this->assets) {
            $this->campaign->updateQuietly([
                'export_date' => null,
            ]);
        }

        // Notify the user that something went wrong
        $this->user->notify(new Header(
            $this->assets ? 'campaign.asset_export_error' : 'campaign.export_error',
            'circle-exclamation',
            'red',
            [
                'campaign' => $this->campaign->name,
            ]
        ));

        return $this;
    }

    /**
     * Each time an element is added to the zip, there is a chance that the progress is increased
     */
    protected function progress(): void
    {
        $this->currentElements++;

        $total = round($this->currentElements / $this->totalElements, 2) * 100;

        // Only track in 1 percentage point increments
        if ($total < ($this->log->progress + 1)) {
            return;
        }
        $this->log->progress = $total;
        $this->log->save();
    }
}
