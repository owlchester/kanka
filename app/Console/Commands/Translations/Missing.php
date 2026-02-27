<?php

namespace App\Console\Commands\Translations;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class Missing extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'translate:missing {locale : The target locale to find missing translations for}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export missing translations for a given locale.';

    protected string $prompt;

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $locale = $this->argument('locale');

        $this->prompt = '';

        $translations = DB::select(
            "select * from ltm_translations where locale = 'en' and not exists(select t.* from ltm_translations as t where t.locale = ? and t.group = ltm_translations.group and t.key = ltm_translations.key) order by ltm_translations.group ASC, ltm_translations.key ASC",
            [$locale]
        );

        $groups = [];
        foreach ($translations as $translation) {
            if (! isset($groups[$translation->group])) {
                $groups[$translation->group] = [];
                $this->prompt .= "\n#" . $translation->group . "\n";
            }
            $this->prompt .= ' - ' . $translation->value . "\n";
        }
        $this->info($this->prompt);
    }
}
