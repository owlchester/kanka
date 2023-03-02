<?php

namespace App\Console\Commands;

use App\Models\EntityAsset;
use App\Models\EntityFile;
use App\Models\EntityLink;
use Illuminate\Console\Command;

class MigrateEntityAssets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'entity:assets';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate entity assets';

    protected $count = 0;
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        EntityAsset::file()->delete();
        $this->count = 0;
        EntityFile::chunk(5000, function ($files): void {
            /** @var EntityFile $file */
            foreach ($files as $file) {
                $this->count++;
                $asset = $this->asset($file, EntityAsset::TYPE_FILE);
                $asset->metadata = ['type' => $file->type, 'path' => $file->path, 'size' => $file->size];
                if (!$asset->save()) {
                    dd('no?');
                }
            }
        });
        $this->info('Migrated ' . $this->count . ' files');

        $this->count = 0;
        EntityAsset::link()->delete();
        EntityLink::chunk(5000, function ($links): void {
            /** @var EntityLink $link */
            foreach ($links as $link) {
                $this->count++;
                $asset = $this->asset($link, EntityAsset::TYPE_LINK);
                $asset->metadata = ['icon' => $link->icon, 'url' => $link->url, 'position' => $link->position];
                if (!$asset->save()) {
                    dd('no?');
                }
            }
        });
        $this->info('Migrated ' . $this->count . ' links');
        return 0;
    }

    /**
     * @param EntityFile|EntityLink $model
     * @param int $type
     * @return EntityAsset
     */
    protected function asset($model, int $type): EntityAsset
    {
        $asset = new EntityAsset();
        $asset->entity_id = $model->entity_id;
        $asset->name = $model->name;
        $asset->visibility_id = $model->visibility_id;
        $asset->created_by = $model->created_by;
        $asset->created_at = $model->created_at;
        $asset->updated_at = $model->updated_at;
        $asset->type_id = $type;
        return $asset;
    }
}
