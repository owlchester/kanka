<x-mail::message layout="admin">
# [{{ $feature->name }}](https://admin.kanka.io/features/{{ $feature->id }})

[{{ $feature->user->name }}](https://admin.kanka.io/users/{{ $feature->user->id }}) @if ($feature->user->isSubscriber()) (_{{ $feature->user->pledge }}_) @endif submitted a new idea to the roadmap.

> {!! nl2br($feature->description) !!}

[View the feature request](https://admin.kanka.io/features/{{ $feature->id }})
</x-mail::message>
