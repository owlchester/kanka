<?php

namespace App\Mail\Subscription\User;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class PaypalExpiringMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public User $user;

    public string $expiryDate;

    public ?string $premiumCampaignName;

    public int $premiumCampaignCount;

    public int $players;

    public int $plugins;

    public bool $discord;

    public string $renewUrl;

    public function __construct(User $user)
    {
        $this->user = $user;

        $subscription = $user->subscription('kanka');
        $this->expiryDate = $subscription?->ends_at?->isoFormat('MMMM D, Y') ?? '';
        $this->renewUrl = route('paypal.renew');

        $this->discord = (bool) $user->discord();

        /** @var Collection $premiumCampaigns */
        $premiumCampaigns = $user->boosts()
            ->with([
                'campaign' => fn ($sub) => $sub->select('campaigns.id', 'campaigns.name'),
                'campaign.members',
                'campaign.plugins',
            ])
            ->groupBy('campaign_id')
            ->get();

        $firstCampaign = $premiumCampaigns->first();
        $this->premiumCampaignName = $firstCampaign?->campaign?->name;
        $this->premiumCampaignCount = $premiumCampaigns->count();

        $members = new Collection;
        $this->plugins = 0;

        if ($firstCampaign) {
            foreach ($firstCampaign->campaign->members as $member) {
                $members->push($member->user_id);
            }
            $this->plugins = $firstCampaign->campaign->plugins->count();
        }

        $this->players = $members->unique()->reject(fn ($userId) => $userId === $user->id)->count();
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: __('emails/subscriptions/paypal-expiring.title'),
            tags: ['user', 'paypal-expiring'],
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.subscriptions.paypal-expiring.user',
        );
    }
}
