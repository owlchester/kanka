<?php

namespace App\Console\Commands;

use App\Campaign;
use App\Models\CampaignRole;
use App\Models\Character;
use App\Models\CharacterTrait;
use App\Models\MapPoint;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

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
            'App\Campaign',
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
            'App\Models\Section',
        ];

        $this->url = rtrim(getenv('APP_URL'), '/');

        foreach ($entities as $entity) {
            $model = new $entity;
            $model->chunk(200, function ($models) {
                foreach ($models as $model) {
                    $attributes = $model->getAttributes();
                    $campaignId = $model->campaign_id;
                    $updated = false;
                    /** @var $model \App\Models\Character */

                    $fields = ['history', 'description', 'entry'];
                    foreach ($fields as $field) {
                        if (array_has($attributes, $field)) {
                            // Does it have an old link?
                            if (strpos($model->$field, 'data-toggle="tooltip"') !== false) {
                                if (strpos($model->$field, '/campaign-' . $campaignId) === false) {
                                    // Fix!
                                    $model->$field = preg_replace("`" . $this->url . '\/(.*?)\/(.*?)`i', $this->url . "/$1/campaign-$campaignId/$2", $model->$field);
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
}
