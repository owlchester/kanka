<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GenerateDescriptionMerge extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'description-merge';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Merge history into description';

    /**
     * @var int
     */
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
     * @return mixed
     */
    public function handle()
    {
        $entities = [
            'App\Models\Item',
            'App\Models\Location',
        ];

        foreach ($entities as $entity) {
            $model = new $entity;
            $model->with('campaign')->chunk(500, function ($models) use ($entity) {
                foreach ($models as $model) {

                    $updated = false;
                    /** @var $model \App\Models\Item */
                    if (!empty(strip_tags($model->history))) {
                        $updated = true;

                        $model->description .= '<h3>'
                            . trans('crud.fields.history', [], $model->campaign->locale)
                            . '</h3>'
                            . $model->history;
                        $model->history = null;
                    }

                    if ($updated) {
                        $this->count++;
                        $model->save();
                    }
                }
            });
        }

        $this->info("Updated {$this->count} entities.");

        return true;
    }

    private function fixUrls($segments)
    {
        if ($segments[2] === 'campaign') {
            return $segments[0]; // Good
        }

        // Redirect?
        if (empty($segments[1])) {
            dd($segments);
        }

        return $this->url . "/" . $segments[1] . "/" . $this->campaignLink . "/" . $segments[2] . "/";
    }
}
