@extends('emails.base', [
    'utmSource' => 'subscription',
    'utmCampaign' => 'cancellation'
])

@section('content')

    <p>
        <strong>Cancellation confirmation</strong>
    </p>
    <p>
        We're sorry to see you go, {{ $user->name }}. You’re always welcome to rejoin our party and renew your subscription at any time to:
    </p>
    <ul>
        <li>Regain access to all your changes, exactly the way you left them</li>
        <li>Ad free experience</li>
        <li>Increased upload size</li>
        <li><a href="{{ \App\Facades\Domain::toFront('pricing')  }}">And way more</a></li>
    </ul>

    <p>This email serves as confirmation that you have cancelled the renewal of your <strong>{{ $user->pledge }}</strong> subscription on Kanka. You will continue to have access to your subscription bonuses until <strong>{{ $user->subscription('kanka')?->ends_at->isoFormat('MMMM D, Y') }}</strong>.
    </p>

    <p>
        Thank you for being part of our community !
    </p>

    <p>Jay & Jon</p>

@endsection
