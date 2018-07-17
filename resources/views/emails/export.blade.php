<p>{{ trans('campaigns.export.email.subject', ['name' => $user->name, 'campaign' => $invite->campaign->name]) }}</p>

<p>{!! trans('campaigns.export.email.link', ['link' => route('campaigns.join', $invite->token), 'name' => e($user->name)]) !!}</p>