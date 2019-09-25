<?php

namespace App\Console\Commands;

use App\Models\Entity;
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
    protected $campaignIds = [];
    protected $noteIds = [];

    protected $errors = [];

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
        define('MISCELLANY_SKIP_ENTITY_CREATION', true);

        EntityMention::with(['target', 'entity'])->entity()->chunk(10000, function ($mentions) {
            $bar = $this->output->createProgressBar(count($mentions));
            $bar->start();
            /** @var EntityMention $mention */
            foreach ($mentions as $mention) {
                if (empty($mention->entity) || empty($mention->entity->child)) {
                    $this->warn('mention #' . $mention->id . ' missing entity');
                    $mention->delete();
                    continue;
                }
                $this->update($mention, $mention->entity->child);
                $bar->advance();
            }
            $bar->finish();
            $this->info('');
        });
        EntityMention::with(['target', 'entityNote'])->entityNote()->chunk(10000, function ($mentions) {
            $bar = $this->output->createProgressBar(count($mentions));
            $bar->start();
            /** @var EntityMention $mention */
            foreach ($mentions as $mention) {
                if (empty($mention->entityNote)) {
                    $this->warn('mention #' . $mention->id . ' missing entity_note');
                    $mention->delete();
                    continue;
                }
                $this->update($mention, $mention->entityNote);
                $bar->advance();
            }
            $bar->finish();
            $this->info('Finished batch.');
        });
        EntityMention::with(['target', 'campaign'])->campaign()->chunk(5000, function ($mentions) {
            $bar = $this->output->createProgressBar(count($mentions));
            $bar->start();
            /** @var EntityMention $mention */
            foreach ($mentions as $mention) {
                if (empty($mention->campaign)) {
                    $this->warn('mention #' . $mention->id . ' missing campaign');
                    $mention->delete();
                    continue;
                }
                $this->update($mention, $mention->campaign);
                $bar->advance();
            }
            $bar->finish();
            $this->info('Finished batch.');
        });

        foreach ($this->errors as $error) {
            $this->error($error);
        }

        $this->info('Updated ' . $this->mentionCount . ' mentions to ' . count($this->entityIds) . ' entities, '
            . count($this->noteIds) . ' notes and ' . count($this->campaignIds) . ' campaigns.');
    }

    /**
     * @param EntityMention $mention
     * @param Model $source entity, entity note
     * @throws \Exception
     */
    protected function update(EntityMention $mention, $source)
    {
        /** @var Entity $target */
        $target = $mention->target;
        $text = $source->entry;

        $link = str_replace('campaign/0/', 'campaign/' . $target->campaign_id . '/', $target->url());
//        $search = '<a title="([^"]*)" href="' . $link . '" data-toggle="tooltip" data-html="true">(.*?)</a>';
        $name = str_replace(['(', ')', '`', '*', '[', ']'], ['\(', '\)', '\`', '\*', '\[', '\]'], $target->name);
        $search = '<a (.*?) data-toggle="tooltip" data-html="true">' . $name . '</a>';
        $replace = '[' . $target->type . ':' . $target->id .']';

//        $this->info('replacing \'' . $mention->target->name . '\' with ' . $replace);
//        dump($text);
//        dump($search);

//        $this->info('replace with: ' . $replace);
        //$text = str_replace($search, $replace, $text);
        try {
            $text = preg_replace("`$search`i", $replace, $text);
            // update the source
            $source->entry = $text;
            if ($source->isDirty('entry')) {
                $this->mentionCount++;
                $source->timestamps = false;
                $source->save();

                if ($mention->isEntity()) {
                    if (!in_array($source->id, $this->entityIds)) {
                        $this->entityIds[] = $source->id;
                        $this->entityCount++;
                    }
                } elseif ($mention->isEntityNote()) {
                    if (!in_array($source->id, $this->noteIds)) {
                        $this->noteIds[] = $source->id;
                    }
                } elseif ($mention->isCampaign()) {
                    if (!in_array($source->id, $this->campaignIds)) {
                        $this->campaignIds[] = $source->id;
                    }
                }
            }
        } catch (\Exception $e) {
            $this->errors[] = "Error with the following check.\nLooking to replace '$search' with '$replace' on mention #"
                . $mention->id . "\n" . $e->getMessage();
        }

//        $this->info('new text');
//        dump($text);
//        dd("end");

    }
}
