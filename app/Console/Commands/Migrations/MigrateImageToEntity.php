<?php

namespace App\Console\Commands\Migrations;

use App\Models\EntityType;
use App\Models\MiscModel;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrateImageToEntity extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:image-to-entity';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate the image from misc to the entity';

    protected int $count = 0;

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info(Carbon::now());

        $types = EntityType::get();
        /** @var EntityType $type */
        foreach ($types as $type) {
            /** @var MiscModel $model */
            $model = $type->getClass();
            if (!$model->isFillable('image')) {
                continue;
            }
            $statement = "update entities as e set image_path = (select c.image from " . $model->getTable() . " as c where c.id = e.entity_id) where e.type_id = " . $type->id;

            $count = DB::update($statement);
            $this->info("Migrated " . $count . " " . $model->getTable());
        }
    }
}
