<?php /** @var \App\Models\EntityAsset $alias */?>
@php $firstAlias = true @endphp
<div class="element profile-family">
    <div class="title text-uppercase text-xs">
        {{ __('entities/profile.aliases') }}
    </div>
    <div class="comma-separated">
    @foreach ($entity->aliases as $alias)
        <span class="element">
            <a
                href="#"
                class="text-link"
                data-clipboard="[{{ $entity->entityType->code }}:{{ $entity->id }}|alias:{{ $alias->id }}]"
                data-toast="{{ __('entities/assets.copy_alias.success') }}"
                data-title="{{ __('entities/assets.copy_alias.title') }}"
                data-toggle="tooltip"
                data-asset="{{ \Illuminate\Support\Str::slug($alias->name) }}"
                data-target="{{ $alias->id }}" data-visibility="{{ $alias->visibility_id }}"
            >
                {!! $alias->name !!}
            </a>
            @includeWhen(!$alias->isVisibleAll(), 'icons.visibility', ['icon' => $alias->visibilityIcon()])
        </span>
    @endforeach
    </div>
</div>
