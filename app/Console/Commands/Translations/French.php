<?php

namespace App\Console\Commands\Translations;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class French extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'translate:french';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export french translations.';

    protected string $prompt;
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->prompt = "Task: translate the following laravel translation keys from english to swiss french. Keep laravel's translation variables (:name) as in the original format. Keep laravel's trans_choice format. Always use \"tu\". Don't translate grouping names.\n";

        $translations = DB::select("select * from ltm_translations where locale = 'en' and not exists(select fr.* from ltm_translations as fr where fr.locale = 'fr' and fr.group = ltm_translations.group and fr.key = ltm_translations.key) order by ltm_translations.group ASC, ltm_translations.key ASC");
        $groups = [];
        foreach ($translations as $translation) {
            if (!isset($groups[$translation->group])) {
                $groups[$translation->group] = [];
                $this->prompt .= "\n#" . $translation->group . "\n";
            }
            $this->prompt .= " - " . $translation->value . "\n";
        }
        $this->info($this->prompt);
    }
}
