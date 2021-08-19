<?php


namespace App\Services\Campaign;


use App\Facades\CampaignCache;
use App\Facades\UserCache;
use App\Models\Campaign;
use App\Models\CampaignRoleUser;
use App\Models\CampaignSubmission;
use App\Models\CampaignUser;
use App\Notifications\Header;
use App\Observers\PurifiableTrait;
use Illuminate\Support\Arr;

class SubmissionService
{
    use PurifiableTrait;

    /** @var Campaign */
    protected $campaign;

    /** @var CampaignSubmission */
    protected $submission;

    /**
     * @param Campaign $campaign
     * @return $this
     */
    public function campaign(Campaign $campaign): self
    {
        $this->campaign = $campaign;
        return $this;
    }

    /**
     * @param CampaignSubmission $submission
     * @return $this
     */
    public function submission(CampaignSubmission $submission): self
    {
        $this->submission = $submission;
        return $this;
    }

    /**
     * @param array $data
     * @return string
     * @throws \Exception
     */
    public function process(array $data): string
    {
        $return = 'approved';
        if (Arr::get($data, 'action') === 'reject') {
            $return = 'rejected';

            // Notify the user
            $rejection = $this->purify(Arr::get($data, 'rejection'));

            $this->submission
                ->user
                ->notify(
                    new Header('campaign.application.rejected', 'user', 'red', [
                        'campaign' => $this->campaign->name,
                        'reason' => $rejection
                    ]));
        } else {
            $this->approve((int) Arr::get($data, 'role_id'));
        }

        $this->submission->delete();

        return $return;
    }

    public function notifyAdmins(): self
    {
        // Notify the admins of a new application
        // Notify all admins
        foreach ($this->campaign->admins() as $user) {
            $user->notify(new Header(
                'campaign.application.new',
                'door-open',
                'yellow',
                [
                    'link' => route('campaign_submissions.index'),
                    'campaign' => $this->campaign->name
                ]
            ));
        }

        return $this;
    }

    /**
     * @param int $roleID
     * @return $this
     */
    protected function approve(int $roleID): self
    {

        // Add the user to the campaign
        $user = CampaignUser::create([
            'user_id' => $this->submission->user_id,
            'campaign_id' => $this->campaign->id,
        ]);

        // Add the user to the role
        $role = CampaignRoleUser::create([
            'user_id' => $this->submission->user_id,
            'campaign_role_id' => $roleID
        ]);

        // Notify the user
        $this->submission
            ->user
            ->notify(
                new Header(
                    'campaign.application.approved',
                    'user',
                    'green',
                    [
                        'campaign' => $this->campaign->name,
                        'link' => route('dashboard'),
                    ]
                )
            );


        // Update the campaign members cache when a user was added
        CampaignCache::campaign($this->campaign)->clearMembers();

        // Clear the user's campaign cache
        UserCache::user($this->submission->user)->clearCampaigns();


        return $this;
    }
}
