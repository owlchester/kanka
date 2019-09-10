<?php

namespace App\Console\Commands;

use App\Models\EntityMention;
use App\Models\MiscModel;
use Illuminate\Console\Command;

class UpdateMentions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mentions:v3';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update all old mentions to v3';

    protected $entityCount = 0;
    protected $mentionCount = 0;

    protected $entityIds = [];

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
     * @return mixed
     */
    public function handle()
    {
        EntityMention::with(['target', 'entity'])->entity()->chunk(1000, function ($mentions) {
            /** @var EntityMention $mention */
            foreach ($mentions as $mention) {
                $this->update($mention, $mention->entity);
            }
        });
        EntityMention::with(['target', 'entityNote'])->entityNote()->chunk(1000, function ($mentions) {
            /** @var EntityMention $mention */
            foreach ($mentions as $mention) {
                $this->update($mention, $mention->entityNote);
            }
        });
        EntityMention::with(['target', 'campaign'])->campaign()->chunk(1000, function ($mentions) {
            /** @var EntityMention $mention */
            foreach ($mentions as $mention) {
                $this->update($mention, $mention->campaign);
            }
        });

        $this->info('Updated ' . $this->mentionCount . ' mentions to ' . $this->entityCount . ' entities.');
    }

    /**
     * @param EntityMention $mention
     */
    protected function update(EntityMention $mention, $child)
    {
        /** @var MiscModel $child */
        $child = $mention->target->child;
        $text = $child->entry;
        $link = str_replace('campaign/0', 'campaign/' . $mention->target->campaign_id, $child->getLink());
        //<a href="https://kanka.io/en/campaign/1/characters/1" tooltip="aaa" toggle="tooltip"
        $search = '<a title="([^"]*)" href="' . $link . '" data-toggle="tooltip" data-html="true">(.*?)</a>';
        $search = '<a (.*?) data-toggle="tooltip" data-html="true">' . e($child->name) . '</a>';
        $replace = '[' . $mention->target->type . ':' . $mention->target->id .']';

//        $this->info('replacing for ' . $mention->target->name);
//        dump($text);
//        dump($search);

//        $this->info('replace with: ' . $replace);
        //$text = str_replace($search, $replace, $text);
        $text = preg_replace("`$search`i", $replace, $text);

        /*$this->info('new text');
        dump($text);
        dd("end");*/

        $child->entry = $text;
        if ($child->isDirty('entry')) {
            $this->mentionCount++;
            $child->timestamps = false;
            $child->save();

            if (!in_array($mention->target_id, $this->entityIds)) {
                $this->entityIds[] = $mention->target->id;
                $this->entityCount++;
            }
        }

    }
}
