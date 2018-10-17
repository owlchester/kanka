<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GenerateMentions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mentions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update all the mentions to the new url format.';

    /**
     * @var int
     */
    protected $count = 0;

    /**
     * @var string
     */
    protected $url = '';

    /**
     * @var string
     */
    protected $campaignLink = '';

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
            'App\Models\Campaign',
            'App\Models\Character',
            'App\Models\Calendar',
            'App\Models\DiceRoll',
            'App\Models\Event',
            'App\Models\Family',
            'App\Models\Item',
            'App\Models\Journal',
            'App\Models\Location',
            'App\Models\Note',
            'App\Models\Organisation',
            'App\Models\Quest',
            'App\Models\Tag',
        ];

        $this->url = "https://kanka.io"; // console doesn't properly read ENV on cloudways

        foreach ($entities as $entity) {
            $model = new $entity;
            $model->with('campaign')->chunk(500, function ($models) use ($entity) {
                foreach ($models as $model) {
                    $attributes = $model->getAttributes();
                    $campaignId = $model->campaign_id;
                    $updated = false;
                    /** @var $model \App\Models\Character */

                    if ($entity == 'App\Models\Campaign') {
                        $this->campaignLink = $model->getMiddlewareLink();
                    } else {
                        $this->campaignLink = $model->campaign->getMiddlewareLink();
                    }

                    $fields = ['entry'];
                    foreach ($fields as $field) {
                        if (array_has($attributes, $field)) {
                            if (strpos($model->$field, '/redirect?what') !== false) {
                                // Fix http to https & www to direct
                                $model->$field = str_replace(
                                    [
                                        '"/redirect?what',
                                        'https://kanka.io/redirect?what'
                                    ],
                                    [
                                        '"https://kanka.io/en/' . $this->campaignLink . '/redirect?what',
                                        'https://kanka.io/en/' . $this->campaignLink . '/redirect?what',
                                    ],
                                    $model->$field
                                );
                                //$model->$field = preg_replace_callback("`" . $this->url . '\/(.*?)\/(.*?)\/(.*?)`i', [$this, 'fixUrls'], $model->$field);

                                if ($model->isDirty($field)) {
                                    $updated = true;
                                }

                            }
                        }
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
