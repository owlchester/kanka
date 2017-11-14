<p>{{ trans('campaigns.invites.email.subject', ['name' => $user->name, 'campaign' => $invite->campaign->name]) }}</p>

<p>{!! trans('campaigns.invites.email.link', ['link' => route('campaigns.join', $invite->token), 'name' => e($user->name)]) !!}</p>