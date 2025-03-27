<x-mail::message>
**Cancellation confirmation**<br><br>
We're sorry to see you go, {{ $user->name }}. You’re always welcome to rejoin our party and renew your subscription at any time to:<br><br>

- Regain access to all your changes, exactly the way you left them
- Ad free experience
- Increased upload size
- [And way more](https:{{ \App\Facades\Domain::toFront('pricing')  }})

This email serves as confirmation that you have cancelled the renewal of your **{{ $user->pledge }}** subscription on Kanka. You will continue to have access to your subscription bonuses until **{{ $user->subscription('kanka')?->ends_at?->isoFormat('MMMM D, Y') }}**.<br><br>

Thank you for being part of our community!<br><br>

Jay & Jon
</x-mail::message>
