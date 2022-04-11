<?php


namespace App\Jobs;


use App\Models\Campaign;
use App\Services\DiscordService;
use App\Services\EntityService;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class DiscordRoleJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 3;

    /** @var User  */
    public $user;

    /** @var bool if to add or remove roles */
    public $add;

    /** @var DiscordService */
    public $discord;

    /**
     * CampaignExport constructor.
     * @param Campaign $campaign
     * @param User $user
     * @param EntityService $entityService
     */
    public function __construct(User $user, bool $add = true)
    {
        $this->user = $user;
        $this->add = $add;
    }

    /**
     * Execute the job
     * @throws \Exception
     */
    public function handle()
    {
        $this->discord = app()->make('App\Services\DiscordService');
        try {
            if ($this->add) {
                $this->discord->user($this->user)->addRoles();
            } else {
                $this->discord->user($this->user)->removeRoles();
            }
        } catch (\Exception $e) {
            Log::error("DiscordRoleJob:: " . $e->getMessage());
            // Silence errors and ignore
        }
    }
}
