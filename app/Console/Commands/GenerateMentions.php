<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Arr;

class GenerateMentions extends Command
{
    /**
     * Redirect string for old links
     */
    const REDIRECT_WHAT = '/redirect?what';

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
                    $this->mapModelMentions($model, $entity);
                }
            });
        }

        $this->info("Updated {$this->count} entities.");

        return true;
    }

    /**
     * @param $model
     * @param $entity
     */
    private function mapModelMentions($model, $entity)
    {
        $attributes = $model->getAttributes();
        $updated = false;
        /** @var $model \App\Models\Character */

        if ($entity == 'App\Models\Campaign') {
            $this->campaignLink = $model->getMiddlewareLink();
        } else {
            $this->campaignLink = $model->campaign->getMiddlewareLink();
        }

        $fields = ['entry'];
        foreach ($fields as $field) {
            if (Arr::has($attributes, $field)) {
                if (strpos($model->$field, self::REDIRECT_WHAT) !== false) {
                    // Fix http to https & www to direct
                    $model->$field = str_replace(
                        [
                            '"/redirect?what',
                            'https://kanka.io' . self::REDIRECT_WHAT
                        ],
                        [
                            '"https://kanka.io/en/' . $this->campaignLink . self::REDIRECT_WHAT,
                            'https://kanka.io/en/' . $this->campaignLink . self::REDIRECT_WHAT,
                        ],
                        $model->$field
                    );

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
}
