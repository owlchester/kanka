<p>{{ __('campaigns.invites.email.subject', ['name' => $user->name, 'campaign' => $invite->campaign->name]) }}</p>

<p>{!! link_to_route('campaigns.join', __('campaigns.invites.email.link_text', ['name' => $user->name]), $invite->token) !!}</p>
