<?php

namespace App\Services\Campaign;

use App\Enums\UserAction;
use App\Facades\CampaignCache;
use App\Facades\UserCache;
use App\Jobs\Campaigns\NotifyAdmins;
use App\Models\CampaignRoleUser;
use App\Models\CampaignSubmission;
use App\Models\CampaignUser;
use App\Notifications\Header;
use App\Observers\PurifiableTrait;
use App\Traits\CampaignAware;
use App\Traits\UserAware;
use Exception;
use Illuminate\Support\Arr;

class SubmissionService
{
    use CampaignAware;
    use PurifiableTrait;
    use UserAware;

    protected CampaignSubmission $submission;

    public function submission(CampaignSubmission $submission): self
    {
        $this->submission = $submission;

        return $this;
    }

    public function apply(?string $reason = null): self
    {
        $submission = new CampaignSubmission;
        $submission->text = $reason;
        $submission->user_id = $this->user->id;
        $submission->campaign_id = $this->campaign->id;
        $submission->save();

        CampaignCache::campaign($this->campaign)->clear();

        NotifyAdmins::dispatch(
            $this->campaign,
            'application.new',
            'door-open',
            'yellow',
            [
                'link' => route('campaign_submissions.index', $this->campaign),
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
            $this->submission
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

        $this->submission->delete();
        CampaignCache::campaign($this->campaign)->clear();

        $this->user->campaignLog($this->campaign->id, 'applications', 'rejected', ['id' => $this->submission->user_id]);

        return $return;
    }

    /**
     * @return $this
     */
    protected function approve(int $roleID, string $message = ''): self
    {
        // Add the user to the campaign
        CampaignUser::create([
            'user_id' => $this->submission->user_id,
            'campaign_id' => $this->campaign->id,
        ]);

        // Add the user to the role
        CampaignRoleUser::create([
            'user_id' => $this->submission->user_id,
            'campaign_role_id' => $roleID,
        ]);
        // $message = $this->purify(Arr::get($data, 'message'));
        if ($message == '') {
            $key = 'campaign.application.approved';
        } else {
            $key = 'campaign.application.approved_message';
        }
        // Notify the user
        $this->submission
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
        UserCache::user($this->submission->user)->clear();

        $this->user->campaignLog($this->campaign->id, 'applications', 'approved', ['id' => $this->submission->user_id]);

        return $this;
    }
}
