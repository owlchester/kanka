<?php

namespace App\Console\Commands\Migrations;

use App\Models\Ability;
use App\Models\Calendar;
use App\Models\Character;
use App\Models\Conversation;
use App\Models\Creature;
use App\Models\Event;
use App\Models\Family;
use App\Models\Item;
use App\Models\Journal;
use App\Models\Location;
use App\Models\Map;
use App\Models\MiscModel;
use App\Models\Note;
use App\Models\Organisation;
use App\Models\Quest;
use App\Models\Race;
use App\Models\Tag;
use App\Models\Timeline;
use Illuminate\Console\Command;

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
        $models = [
            Ability::class,
            Calendar::class,
            Character::class,
            Conversation::class,
            Creature::class,
            Event::class,
            Family::class,
            Item::class,
            Journal::class,
            Location::class,
            Map::class,
            Note::class,
            Organisation::class,
            Quest::class,
            Race::class,
            Tag::class,
            Timeline::class,
        ];
        foreach ($models as $class) {
            $model = new $class();
            $model->select('id', 'image')
                ->with('entity')->has('entity')
                ->whereNotNull('image')
                ->chunk(5000, function ($characters) use ($class) {
                    $this->count = 0;
                    foreach ($characters as $character) {
                        $this->process($character);
                    }
                    $this->info('Migrated ' . $this->count . ' ' . $class);
                });
        }
    }

    protected function process(MiscModel $model)
    {
        if (empty($model->image)) {
            $this->error('Empty image for ' . get_class($model) . ' #' . $model->id);
            return;
        }
        if (mb_strlen($model->image) > 85) {
            $this->error('Image too long (' . mb_strlen($model->image) . ') for ' . get_class($model) . ' #' . $model->id);
            return;
        }

        $model->entity->image_path = $model->image;
        $model->entity->saveQuietly();
        $this->count++;
    }
}
