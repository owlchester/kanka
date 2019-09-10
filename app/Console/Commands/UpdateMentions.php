<?php

namespace App\Console\Commands;

use App\Models\EntityMention;
use App\Models\MiscModel;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;

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
                $this->update($mention, $mention->entity->child);
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
     * @param Model $source entity, entity note
     * @throws \Exception
     */
    protected function update(EntityMention $mention, $source)
    {
        /** @var MiscModel $child */
        $child = $mention->target->child;
        $text = $source->entry;

        $link = str_replace('campaign/0', 'campaign/' . $mention->target->campaign_id, $child->getLink());
        //<a href="https://kanka.io/en/campaign/1/characters/1" tooltip="aaa" toggle="tooltip"
        $search = '<a title="([^"]*)" href="' . $link . '" data-toggle="tooltip" data-html="true">(.*?)</a>';
        $search = '<a (.*?) data-toggle="tooltip" data-html="true">' . $child->name . '</a>';
        $replace = '[' . $mention->target->type . ':' . $mention->target->id .']';

        $this->info('replacing \'' . $mention->target->name . '\' with ' . $replace);
//        dump($text);
//        dump($search);

//        $this->info('replace with: ' . $replace);
        //$text = str_replace($search, $replace, $text);
        $text = preg_replace("`$search`i", $replace, $text);

        if ($source->id == 168) {
            dd($search);
            dd($replace);
            dd($text);
        }

//        $this->info('new text');
//        dump($text);
//        dd("end");

        // update the source
        $source->entry = $text;
        if ($source->isDirty('entry')) {
            $this->mentionCount++;
            $source->timestamps = false;
            $source->save();

            if (!in_array($mention->target_id, $this->entityIds)) {
                $this->entityIds[] = $mention->target->id;
                $this->entityCount++;
            }
        }

    }
}
