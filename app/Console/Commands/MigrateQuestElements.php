<?php

namespace App\Console\Commands;

use App\Models\Entity;
use App\Models\MiscModel;
use App\Models\QuestAbstract;
use App\Models\QuestCharacter;
use App\Models\QuestElement;
use App\Models\QuestItem;
use App\Models\QuestLocation;
use App\Models\QuestOrganisation;
use Illuminate\Console\Command;

class MigrateQuestElements extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'quests:migrate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate quest elements from the old to the new structure';

    /** @var int How many items were imported */
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
        $this->info('Start importing characters');
        $chunk = 500;
        QuestCharacter::with('character', 'character.entity', 'quest', 'quest.entity')
            ->chunk($chunk, function ($elements) {
                $this->info('New chunk');
                foreach ($elements as $element) {
                    $this->importElement($element);
                }
            });
        $this->info('Migrated ' . $this->count . ' characters');

        $this->info('Start importing locations');
        $this->count = 0;
        QuestLocation::with('location', 'location.entity', 'quest', 'quest.entity')
            ->chunk($chunk, function ($elements) {
                $this->info('New chunk');
                foreach ($elements as $element) {
                    $this->importElement($element);
                }
            });
        $this->info('Migrated ' . $this->count . ' locations');

        $this->info('Start importing ite s');
        $this->count = 0;
        QuestItem::with('item', 'item.entity', 'quest', 'quest.entity')
            ->chunk($chunk, function ($elements) {
                $this->info('New chunk');
                foreach ($elements as $element) {
                    $this->importElement($element);
                }
            });
        $this->info('Migrated ' . $this->count . ' items');

        $this->info('Start importing organisations');
        $this->count = 0;
        QuestOrganisation::with('organisation', 'organisation.entity', 'quest', 'quest.entity')
            ->chunk($chunk, function ($elements) {
                $this->info('New chunk');
                foreach ($elements as $element) {
                    $this->importElement($element);
                }
            });
        $this->info('Migrated ' . $this->count . ' organisation');
        return 0;
    }

    /**
     * @param QuestAbstract $model
     */
    protected function importElement($model)
    {
        // Figure out the entity
        $key = 'character';
        if (isset($model->location_id)) {
            $key = 'location';
        } elseif (isset($model->item_id)) {
            $key = 'item';
        } elseif (isset($model->organisation_id)) {
            $key = 'organisation';
        }

        try {
            $entity = $model->$key->entity;
            /*Entity::select('id')
                ->withTrashed()
                ->where('entity_id', $model->{$key . '_id'})
                ->where('type', $key)
                ->first();*/

            if (empty($entity)) {
                // No idea what this is supposed to be, junk
                $this->error("Unknown $key #" . $model->{$key . '_id'});
                return;
            }

            $quest = null;
            if (empty($model->quest)) {

                $quest = Entity::withTrashed()
                    ->where('entity_id', $model->quest_id)
                    ->where('type', 'quest')
                    ->first();
                $this->info('Quest #' . $model->quest_id . ' was deleted');
            } else {
                $quest = $model->quest->entity;
            }
            $entityId = $entity->id;
            unset($entity);


            $new = new QuestElement();
            $new->quest_id = $model->quest_id;
            $new->entity_id = $entityId;
            $new->visibility = $model->is_private ? 'admin' : 'all';
            $new->description = $model->description;
            $new->colour = $model->colour;
            $new->role = $model->role;
            $new->created_by = $quest->created_by;
            $new->save();

            $this->count++;

            unset($new);
        } catch (\Exception $e) {
            $this->error('Error: ' . $model->getTable() . '#' . $model->id . 'd key(' . $key . ') ' . $e->getMessage());
        }
    }
}
