<?php /** @var \App\Models\User $user */ ?>
<div {{ $attributes->merge(['class' => 'rounded-full cover-background']) }}
     style="background-image: url('{{ $user->getAvatarUrl($size) }}')">
</div>
