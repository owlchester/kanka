<?php
/**
 * @var string $id
 * @var string $url
 * @var int $selected
 * @var array $options
 * @var array $iconMap
 * @var string $adminUrl
 * @var string $adminName
 * @var string $entityName
 * @var \App\Models\Campaign $campaign
 * @var \App\Models\Entity $entity
 */

$visibilityKeys = [
    \App\Enums\Visibility::All->value => 'all',
    \App\Enums\Visibility::Admin->value => 'admin',
    \App\Enums\Visibility::AdminSelf->value => 'admin-self',
    \App\Enums\Visibility::Self->value => 'self',
    \App\Enums\Visibility::Member->value => 'member',
];

$adminLink = '<a href="' . e($adminUrl) . '" class="text-link">' . e($adminName) . '</a>';
?>
<span id="{{ $id }}" class="visibility-picker" data-selected="{{ $selected }}" data-url="{{ $url }}">
    <button class="btn2 btn-ghost btn-sm visibility-picker-trigger" type="button">
        <i class="{{ $iconMap[$selected] ?? 'fa-regular fa-eye' }}" aria-hidden="true"></i>
        <span class="sr-only">{{ __('visibilities.title') }}</span>
    </button>

    <div class="visibility-picker-dropdown hidden" role="radiogroup" aria-label="{{ __('visibilities.title') }}">
        <div class="flex flex-col gap-0.5 p-1 min-w-72">
            @foreach ($options as $value => $name)
                <button
                    type="button"
                    role="radio"
                    aria-checked="{{ $value === $selected ? 'true' : 'false' }}"
                    class="visibility-picker-option flex items-start gap-2.5 p-2 px-3 rounded-lg cursor-pointer text-left transition-colors hover:bg-base-200/50 {{ $value === $selected ? 'bg-primary/5 ring-1 ring-primary/30' : '' }}"
                    data-value="{{ $value }}"
                    data-icon="{{ $iconMap[$value] }}"
                    @if(count($options) === 1) disabled @endif
                >
                    <x-icon class="{{ $iconMap[$value] }} text-neutral-content mt-0.5 w-5 text-center shrink-0" />
                    <div class="flex flex-col gap-0.5 flex-1 min-w-0">
                        <span class="text-sm font-semibold">{{ $name }}</span>
                        <span class="text-xs text-neutral-content leading-relaxed">
                            {!! __('visibilities.picker.' . $visibilityKeys[$value], [
                                'entity' => e($entityName),
                                'admin' => $adminLink,
                            ]) !!}
                        </span>
                    </div>
                    <div class="visibility-picker-status w-5 shrink-0 mt-0.5 text-center">
                        @if ($value === $selected)
                            <i class="fa-regular fa-check text-primary" aria-hidden="true"></i>
                        @endif
                    </div>
                </button>
            @endforeach
        </div>
    </div>
</span>
