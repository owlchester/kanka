<?php

namespace App\Services\Campaign;

use App\Facades\CampaignCache;
use App\Jobs\Campaigns\Export;
use App\Models\Entity;
use App\Models\EntityAsset;
use App\Models\Image;
use App\Models\CampaignExport;
use App\Models\Map;
use App\Models\MiscModel;
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

        Export::dispatch($this->campaign, $this->user, $entitiesExport, false)->onQueue('heavy');

        return $this;
    }

    public function export(): self
    {
        try {
            $this
                ->prepare()
                ->info()
                ->campaignJson()
                ->campaignModules()
                ->customCampaignModules()
                ->entities()
                ->customEntities()
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
            Log::error('Campaign export', ['action' => 'export', 'err' => $e->getMessage()]);
            throw $e;
        }

        return $this;
    }

    public function filesize(): int
    {
        return $this->filesize;
    }


    protected function campaignModules(): self
    {
        $modules = [];
        $settings = $this->campaign->setting->toArray();
        unset($settings['id'], $settings['campaign_id'], $settings['created_at'], $settings['updated_at']);
        $entities = config('entities.ids');

        foreach ($settings as $name => $active) {
            $module = ['enabled' => $active];
            try {
                if ($this->campaign->hasModuleName($entities[Str::singular($name)])) {
                    $module['name_singular'] = $this->campaign->moduleName($entities[Str::singular($name)]);
                }
                if ($this->campaign->hasModuleName($entities[Str::singular($name)], true)) {
                    $module['name_plural'] = $this->campaign->moduleName($entities[Str::singular($name)], true);
                }
                if ($this->campaign->hasModuleIcon($entities[Str::singular($name)])) {
                    $module['icon'] = $this->campaign->moduleIcon($entities[Str::singular($name)]);
                }
            } catch (Exception $e) {

            }
            $modules[$name] = $module;

        }
        $this->archive->add(json_encode($modules), 'settings/modules.json', );
        $this->files++;

        return $this;
    }

    protected function customCampaignModules(): self
    {
        $settings = $this->campaign->entityTypes->where('is_special', 1)->select('id', 'code', 'is_enabled', 'singular', 'plural', 'icon')->toArray();
        $this->archive->add(json_encode($settings), 'settings/custom-modules.json', );
        $this->files++;

        return $this;
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
        // We don't want the whole model to be available to the export.
        // It would probably make more sense to have a resource for this.
        $hidden = [
            'boost_count', 'export_date', 'is_featured', 'featured_until',
            'featured_reason', 'visible_entity_count', 'system', 'follower', 'is_hidden'
        ];
        $this->archive->addRaw($this->campaign->makeHidden($hidden)->toJson(), 'campaign.json');
        $this->files++;
        //Log::info("wat", ['path' => 's3://' . config('filesystems.disks.s3.bucket') . '/' . Storage::path($this->campaign->image)]);
        if (!$this->assets) {
            //return $this;
        }
        $image = $this->campaign->image;
        if (!empty($image) && Str::contains($image, '?') && Storage::exists($image)) {
            try {
                $this->archive->add('s3://' . config('filesystems.disks.s3.bucket') . '/' . Storage::path($image), $image);
                $this->files++;
            } catch (Exception $e) {
                Log::warning('Campaign export', ['err' => 'Can\'t get campaign image', 'path' => $image]);
            }

        }
        $image = $this->campaign->header_image;
        if (!empty($image) && Str::contains($image, '?') && Storage::exists($image)) {
            try {
                $this->archive->add('s3://' . config('filesystems.disks.s3.bucket') . '/' . Storage::path($image), $image);
                $this->files++;
            } catch (Exception $e) {
                Log::warning('Campaign export', ['err' => 'Can\'t get campaign header', 'path' => $image]);
            }
        }

        $this->progress();

        return $this;
    }

    protected function entities(): self
    {
        $entityWith = [
            'entity',
            'entity.entityTags', 'entity.relationships',
            'entity.posts', 'entity.posts.postTags', 'entity.abilities', 'entity.abilities.ability',
            'entity.events',
            'entity.image',
            'entity.header',
            'entity.assets',
            'entity.files',
            'entity.mentions',
            'entity.inventories',
            'entity.inventories.item',
            'entity.entityAttributes',
        ];
        $entities = config('entities.classes-plural');
        foreach ($entities as $entity => $class) {
            if (!$this->campaign->enabled($entity) || !method_exists($class, 'export')) {
                continue;
            }
            try {
                $property = Str::camel($entity);
                $smartWith = $this->smartWith($entityWith, $class);
                foreach ($this->campaign->$property()->with($smartWith)->has('entity')->get() as $model) {
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

    protected function customEntities(): self
    {
        $entityWith = [
            'entityTags', 'relationships',
            'posts', 'posts.postTags', 'abilities', 'abilities.ability',
            'events',
            'image',
            'header',
            'assets',
            'files',
            'mentions',
            'inventories',
            'inventories.item',
            'entityAttributes',
        ];

        $entityTypes = $this->campaign->entityTypes->where('is_special', 1)->all();

        foreach ($entityTypes as $entityType) {
            if (!$entityType->isEnabled()) {
                continue;
            }

            try {
                $base = Entity::inTypes($entityType->id)

                    ->with($entityWith)
                    ->get();

                $name = Str::camel($entityType->code) . '_' . $entityType->id;
                foreach ($base as $model) {
                    $this->process($name, $model);
                }
            } catch (Exception $e) {
                Log::error('Campaign export', ['err' => $e->getMessage()]);
                $saveFolder = storage_path($this->exportPath);
                $this->archive->saveTo($saveFolder);
                unlink($this->path);
                throw new Exception(
                    'Missing campaign entity relation: ' . $entityType->singular . '-' . $name . '? '
                    . $e->getMessage()
                );
            }
        }
        return $this;
    }

    protected function smartWith(array $with, string $entityClass): array
    {
        /** @var MiscModel $class */
        $class = app()->make($entityClass);
        // @phpstan-ignore-next-line
        foreach ($class->exportRelations() as $rel) {
            $with[] = $rel;
        }
        return $with;
    }

    protected function gallery(): self
    {
        foreach ($this->campaign->images()->with('imageFolder')->get() as $image) {
            try {
                /** @var Image $image */
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
        
        if ($model instanceof Entity) {
            $modelEntity = $model;
        } else {
            $modelEntity = $model->entity;
        }

        if (!$this->assets) {
            if ($model instanceof Entity) {
                $this->archive->add(json_encode(['entity' => $model->export(true)]), $entity . '/' . Str::slug($model->name) . '.json', );
            } else {
                $this->archive->add($model->export(), $entity . '/' . Str::slug($model->name) . '.json', );
            }
            $this->files++;
            //return $this;
        }

        $path = $modelEntity->image_path;
        if (!empty($path) && !Str::contains($path, '?') && Storage::exists($path)) {
            try {
                $this->archive->add('s3://' . config('filesystems.disks.s3.bucket') . '/' . Storage::path($path), $path);
                $this->files++;
            } catch (Exception $e) {
                Log::warning('Campaign export', ['err' => 'Can\'t get image_path', 'image_path' => $path, 'entity' => $modelEntity->id]);
            }
        }
        $path = $modelEntity->header_image;
        if (!empty($path) && !Str::contains($path, '?') && Storage::exists($path)) {
            try {
                $this->archive->add('s3://' . config('filesystems.disks.s3.bucket') . '/' . Storage::path($path), $path);
                $this->files++;
            } catch (Exception $e) {
                Log::warning('Campaign export', ['err' => 'Can\'t get header_image', 'header_image' => $path, 'entity' => $modelEntity->id]);
            }
        }

        /** @var EntityAsset $file */
        foreach ($modelEntity->files as $file) {
            if (!isset($file->metadata['path'])) {
                continue;
            }
            $path = $file->metadata['path'];
            if (!Storage::exists($path)) {
                continue;
            }
            try {
                $this->archive->add('s3://' . config('filesystems.disks.s3.bucket') . '/' . Storage::path($path), $path);
            } catch (Exception $e) {
                Log::warning('Campaign export', ['err' => 'Can\'t get asset file', 'path' => $path, 'asset' => $file->id]);
            }
        }

        if ($model instanceof Map) {
            foreach ($model->layers as $layer) {
                $path = $layer->image;
                if (!$path || !Storage::exists($path)) {
                    continue;
                }
                try {
                    $this->archive->add('s3://' . config('filesystems.disks.s3.bucket') . '/' . Storage::path($path), $path);
                } catch (Exception $e) {
                    Log::warning('Campaign export', ['err' => 'Can\'t get map layer file', 'path' => $path, 'layer' => $layer->id]);
                }
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
            Log::error('Campaign export', ['action' => 'finish', 'err' => $e->getMessage()]);
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
