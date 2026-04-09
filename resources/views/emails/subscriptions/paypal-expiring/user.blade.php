<x-mail::message>

{{ __('emails/subscriptions/paypal-expiring.dear', ['name' => $user->name]) }},

{{ __('emails/subscriptions/paypal-expiring.intro', ['date' => $expiryDate]) }}

{{ __('emails/subscriptions/paypal-expiring.loss.title') }}

@if ($premiumCampaignName)
- {{ trans_choice('emails/subscriptions/paypal-expiring.loss.campaign', $premiumCampaignCount - 1, ['campaign' => $premiumCampaignName, 'count' => $premiumCampaignCount - 1]) }}
@if ($players > 0)
  - {{ trans_choice('emails/subscriptions/paypal-expiring.loss.players', $players, ['count' => $players]) }}
@endif
@if ($plugins > 0)
  - {{ trans_choice('emails/subscriptions/paypal-expiring.loss.plugins', $plugins, ['count' => $plugins]) }}
@endif
@endif
- {{ __('emails/subscriptions/paypal-expiring.loss.ads') }}
@if ($discord)
- {{ __('emails/subscriptions/paypal-expiring.loss.discord', ['role' => $user->pledge]) }}
@endif

<x-mail::button :url="$renewUrl">
{{ __('emails/subscriptions/paypal-expiring.cta') }}
</x-mail::button>

{{ __('emails/subscriptions/paypal-expiring.closing') }}

__Jay & Jon__

</x-mail::message>
