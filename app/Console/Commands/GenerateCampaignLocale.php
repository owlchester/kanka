<?php

namespace App\Console\Commands;

use App\Models\Campaign;
use Illuminate\Console\Command;

class GenerateCampaignLocale extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'campaign:locale';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change the locale of campaigns';

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

        $count = 0;
        foreach (Campaign::with('members')->where(['locale' => 'en'])->get() as $campaign) {
            $locale = false;
            //$this->info("Campaign '" . $campaign->name . "'");
            foreach ($campaign->members()->with('user')->with('roles')->get() as $member) {
                if ($member->isAdmin()) {
                    //$this->info("- " . $member->user->name . ':' . $member->user->locale);
                    if ($locale !== false && $locale != $member->user->locale) {
                        $this->warn("Conflict between members on campaign #" . $campaign->id);
                        $locale = false;
                    } elseif ($locale === false) {
                        $locale = $member->user->locale;
                    }
                }
            }

            if ($locale != $campaign->locale && $locale !== false) {
                if (!in_array($locale, ['en', 'en-US', 'pt-BR', 'fr', 'es', 'de'])) {
                    $this->warn("Locale error on campaign #" . $campaign->id);
                    $locale = 'en';
                }
                $count++;
                $campaign->locale = $locale;
                $campaign->save();
            }
        }

        $this->info("Update $count campaigns.");

        return true;
    }
}
