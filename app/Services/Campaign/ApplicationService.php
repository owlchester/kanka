<?php

namespace App\Services\Campaign;

use App\Facades\CampaignCache;
use App\Facades\UserCache;
use App\Jobs\Campaigns\NotifyAdmins;
use App\Models\Application;
use App\Models\CampaignRoleUser;
use App\Models\CampaignUser;
use App\Notifications\Header;
use App\Observers\PurifiableTrait;
use App\Traits\CampaignAware;
use App\Traits\UserAware;
use Exception;
use Illuminate\Support\Arr;

class ApplicationService
{
    use CampaignAware;
    use PurifiableTrait;
    use UserAware;

    protected Application $application;

    public function application(Application $application): self
    {
        $this->application = $application;

        return $this;
    }

    public function apply(?string $reason = null): self
    {
        $application = new Application;
        $application->text = $reason;
        $application->user_id = $this->user->id;
        $application->campaign_id = $this->campaign->id;
        $application->save();

        CampaignCache::campaign($this->campaign)->clear();

        NotifyAdmins::dispatch(
            $this->campaign,
            'application.new',
            'door-open',
            'yellow',
            [
                'link' => route('applications.index', $this->campaign),
                'campaign' => $this->campaign->name,
            ]
        );

        return $this;
    }

    /**
     * @throws Exception
     */
    public function process(array $data): string
    {
        $return = 'approved';
        if (Arr::get($data, 'action') === 'reject') {
            $return = 'rejected';

            // Notify the user
            $rejection = $this->purify(Arr::get($data, 'reason'));
            if ($rejection == '') {
                $key = 'campaign.application.rejected_no_message';
            } else {
                $key = 'campaign.application.rejected';
            }
            $this->application
                ->user
                ->notify(
                    new Header($key, 'user', 'red', [
                        'campaign' => $this->campaign->name,
                        'reason' => $rejection,
                    ])
                );
        } else {
            $this->approve((int) Arr::get($data, 'role_id'), $this->purify(Arr::get($data, 'reason')));
        }

        $this->application->delete();
        CampaignCache::campaign($this->campaign)->clear();

        $this->user->campaignLog($this->campaign->id, 'applications', 'rejected', ['id' => $this->application->user_id]);

        return $return;
    }

    protected function approve(int $roleID, string $message = ''): self
    {
        // Add the user to the campaign
        CampaignUser::create([
            'user_id' => $this->application->user_id,
            'campaign_id' => $this->campaign->id,
        ]);

        // Add the user to the role
        CampaignRoleUser::create([
            'user_id' => $this->application->user_id,
            'campaign_role_id' => $roleID,
        ]);
        // $message = $this->purify(Arr::get($data, 'message'));
        if ($message == '') {
            $key = 'campaign.application.approved';
        } else {
            $key = 'campaign.application.approved_message';
        }
        // Notify the user
        $this->application
            ->user
            ->notify(
                new Header(
                    $key,
                    'user',
                    'green',
                    [
                        'campaign' => $this->campaign->name,
                        'reason' => $message,
                        'link' => route('dashboard', $this->campaign),
                    ]
                )
            );

        // Update the campaign members cache when a user was added
        CampaignCache::campaign($this->campaign)->clear();

        // Clear the user's campaign cache
        UserCache::user($this->application->user)->clear();

        $this->user->campaignLog($this->campaign->id, 'applications', 'approved', ['id' => $this->application->user_id]);

        return $this;
    }
}
