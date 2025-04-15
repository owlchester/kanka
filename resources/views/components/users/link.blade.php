<?php /** @var \App\Models\User $user */ ?>
<a href="{{  route('users.profile', $user) }}" class="flex items-center gap-2">
    @if ($user->hasAvatar())
        <div {{ $attributes->merge(['class' => 'rounded-full cover-background']) }} style="background-image: url('{{ $user->getAvatarUrl($size) }}')"></div>
    @endif
    {!! $user->name !!}
</a>
