<?php

namespace App\Console\Commands\Migrations;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class Cdn extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cdn:migrate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate cdn urls';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tables = [
            //            'posts' => 'entry',
            //            'timeline_eras' => 'entry',
            //            'timeline_elements' => 'entry',
            //            'quest_elements' => 'entry',
            //            'attributes' => 'value',
            //            'campaigns' => 'entry',
            //            'entities' => 'entry',
            //            'map_layers' => 'entry',
            //            'character_traits' => 'entry',
            'plugin_versions' => 'content',
        ];
        $old = 'https://kanka-user-assets.s3.eu-central-1.amazonaws.com/';
        $new = 'https://cdn-ugc.kanka.io/';
        $batchSize = 1000;

        foreach ($tables as $tableName => $column) {
            $this->info("Migrating $tableName ($column)...");
            do {
                $affected = DB::update("
            UPDATE `$tableName`
            SET `$column` = REPLACE(`$column`, ?, ?)
            WHERE `$column` LIKE ?
            LIMIT $batchSize
        ", [$old, $new, "%$old%"]);

                $this->info(" Updated $affected rows...");

            } while ($affected > 0);

        }

        $tableName = 'plugin_versions';
        $column = 'json';
        $old = 'kanka-user-assets.s3.eu-central-1.amazonaws.com';
        $new = 'cdn-ugc.kanka.io';
        $this->info("Migrating $tableName ($column)...");
        do {
            $affected = DB::update("

                UPDATE `$tableName`
                SET `$column` = REPLACE(`$column`, ?, ?)
                WHERE `$column` LIKE ?
                LIMIT $batchSize
            ", [$old, $new, "%$old%"]);
            $this->info(" Updated $affected rows...");
        } while ($affected > 0);

        $this->info('URL replacement completed.');
    }
}
