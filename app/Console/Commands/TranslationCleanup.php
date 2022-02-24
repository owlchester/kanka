<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class TranslationCleanup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'translations:cleanup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cleanup translations not present in english';

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
        $oldKeys = [];
        $translations = DB::table('ltm_translations', 'a')
            ->select(['a.locale', 'a.group', 'a.key', 'a.value', 'b.value'])
            ->leftJoin('ltm_translations as b', function ($join) {
                $join->on('b.key', '=', 'a.key')
                    ->on('b.group', '=', 'a.group')
                    ->on('b.locale', '=', DB::raw("'en'"))
                ;
            })
            ->whereNull('b.value')
            ->where('a.locale', '!=', 'en')
            ->whereNotIn('a.group', ['auth'])
            ->get();

        foreach ($translations as $translation) {
            if (!isset($oldKeys[$translation->group])) {
                $oldKeys[$translation->group] = [];
            }
            if (in_array($translation->key, $oldKeys[$translation->group])) {
                continue;
            }
            $oldKeys[$translation->group][] = $translation->key;
        }

        if (empty($oldKeys)) {
            $this->info('No old keys, good job!');
            return 0;
        }

        foreach ($oldKeys as $group => $keys) {
            $this->info('Group ' . $group . ' with ' . count($keys) . ' keys.');

            $query = "DELETE from ltm_translations where `group` = '" . $group . "' and `key` in ('" . implode("', '", array_values($keys)). "')";
            DB::statement($query);
        }

        $this->info('Deleted ' . count($oldKeys) . ' old keys.');
        return 0;
    }
}
