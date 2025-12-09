<?php /** @var \App\Models\User $user */ ?>
<a href="{{  route('users.profile', $user) }}" class="flex items-center gap-2 text-link">
    @if ($user->hasAvatar())
        <img src="{{ $user->getAvatarUrl($size) }}" loading="lazy" class="rounded-full w-10 h-10" />
    @endif
    {!! $user->name !!}
</a>
