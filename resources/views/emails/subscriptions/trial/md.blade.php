<x-mail::message layout="admin">
# New subscription trial accepted

New subscription trial for user [{{ $user->name }}](https://admin.kanka.io/users/{{ $user->id }}) (#{{ $user->id }}) {{ $user->email }}.

Account created {{ $user->created_at->diffForHumans() }} ({{ $user->created_at->format('d.m.Y') }}).

@if ($discord = $user->apps->where('app', 'discord')->first())
Discord: {{ $discord->settings['username'] }}

@endif

</x-mail::message>
