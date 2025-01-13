<?php /**
 * @var \App\Models\Entity $entity
 * @var \App\Models\MiscModel $model
 * @var \App\Models\Campaign $campaign
 * */?>
@if (auth()->guest() || auth()->user()->created_at->isAfter(\Carbon\Carbon::create('2025-01-01')))
    <?php return; ?>
@endif

<div class="dropdown entity-actions flex items-center">
    <div role="button" tabindex="0" aria-expanded="false" class="cursor-pointer" data-pulse=".entity-actions-button" data-content="{{ __('entities/actions.new-action-button') }}" data-placement="top">
        <span class="sr-only">{{ __('entities/permissions.quick.screen-reader') }}</span>
        <div class="entity-icons transition-all hover:rotate-45 h-7 w-7 fill-current">
            @include('icons.svg.cog')
        </div>

    </div>
</div>
