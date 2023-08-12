@extends('emails.base', [
    'utmSource' => 'first',
    'utmCampaign' => 'inactivity'
])

@section('content')

    <p>
        {{ __('emails/subscriptions/upcoming.dear', ['name' => $user->name]) }},
    </p>

    @if (!empty($campaigns))
        <p>{{ __('emails/purge/first.intro_campaigns', [
            'amount' => config('purge.users.first.limit'),
            'duration' => config('purge.users.first.inactivity'),
        ]) }} {{ __('emails/purge/first.warning.campaigns', [
            'email' => $user->email
        ]) }}</p>

        <ol>
            <?php /** @var \App\Models\Campaign $campaign */?>
            @foreach ($campaigns as $campaign)
                <li>
                    <a href="{{ route('dashboard', $campaign) }}">
                        {{ $campaign->name }}
                    </a>
                </li>
            @endforeach
        </ol>
    @else
        <p>{{ __('emails/purge/first.intro_account', [
            'amount' => config('purge.users.first.limit'),
            'duration' => config('purge.users.first.inactivity')
        ]) }} {{ __('emails/purge/first.warning.account', [
            'email' => $user->email
        ]) }}</p>
    @endif

    <p>{{ __('emails/purge/first.keep', ['amount' => config('purge.users.first.limit')]) }}</p>

    <p>{{ __('emails/purge/first.assure') }}</p>

    <p>{!! __('emails/purge/first.help', [
        'discord' => link_to('https:' . config('social.discord'), 'Discord'),
        'email' => '<a href="mailto:' . config('app.email') . '">' . config('app.email') . '</a>'
    ]) !!}</p>

    <i>Jay & Jon</i>
@endsection
