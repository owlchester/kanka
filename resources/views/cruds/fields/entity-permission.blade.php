<?php
/**
 * @var \App\Models\Entity $entity
 * @var \App\Models\Entity $source
 * @var \App\Models\Campaign $campaign
 */
$isPrivate = old('is_private', $source->is_private ?? $model->is_private ?? $campaign->entity_visibility)
?>
<div class="relative" x-data="{private: {{ $isPrivate ? 'true' : 'false' }}, open: false}" @click.outside="open = false">
    <input type="hidden" name="is_private" :value="private ? 1 : 0" />

    <button type="button" class="btn2 btn-outline " @click="open = !open" :aria-expanded="open">
        <i class="fa-regular fa-lock" x-show="private" x-cloak aria-hidden="true"></i>
        <i class="fa-regular fa-eye" x-show="!private" aria-hidden="true"></i>
        <span x-show="private" x-cloak>{{ __('entities/permissions.toggle.private.title') }}</span>
        <span x-show="!private">{{ __('entities/permissions.toggle.public.title') }}</span>
        <x-icon class="fa-regular fa-chevron-down text-xs" />
    </button>

    <div x-show="open" x-cloak class="absolute right-0 z-50 mt-1 w-64 bg-base-100 border border-base-300 rounded-xl shadow-lg p-1 flex flex-col gap-0.5 min-w-sm">
        <button type="button"
            class="text-left px-2 py-2 hover:bg-base-200 rounded-xl transition-all duration-150 flex gap-2"
            :class="!private ? 'bg-base-200' : ''"
            @click="private = false; open = false">

            <div class="bg-base-300 rounded w-7 h-7 flex items-center justify-center flex-none" :class="!private ? 'bg-primary text-primary-content' : ''">
                <x-icon class="fa-regular fa-eye" />
            </div>
            <div class="flex flex-col gap-0">

                <div class="flex items-center gap-2">
                    <span class="font-medium text-sm">{{ __('entities/permissions.toggle.public.title') }}</span>
                    <span x-show="!private" x-cloak class="text-primary bg-primary-content px-1 rounded text-xs">{{ __('entities/permissions.toggle.current') }}</span>
                </div>
                <p class="text-xs text-neutral-content">
                    {{ __('entities/permissions.toggle.public.helper') }}
                </p>
            </div>
        </button>

        <button type="button"
            class="text-left px-2 py-2 hover:bg-base-200 rounded-xl transition-all duration-150 flex gap-2"
            :class="private ? 'bg-base-200' : ''"
            @click="private = true; open = false">

            <div class="bg-base-300 rounded w-7 h-7 flex items-center justify-center flex-none" :class="private ? 'bg-primary text-primary-content' : ''">
                <x-icon class="lock" />
            </div>
            <div class="flex flex-col gap-0">
                <div class="flex items-center gap-2">
                    <span class="font-medium text-sm">
                        {{ __('entities/permissions.toggle.private.title') }}</span>
                    <span x-show="private" x-cloak class="text-primary bg-primary-content px-1 rounded text-xs">{{ __('entities/permissions.toggle.current') }}</span>
                </div>
                <p class="text-xs text-neutral-content">
                {!! __('crud.fields.is_private_v3', [
        'admin-role' => '<a href=\'' . route('campaigns.campaign_roles.admin', $campaign) . '\' class="text-link">' . $campaign->adminRoleName() . '</a>'
        ]) !!} 
                </p>
            </div>
        </button>
    </div>
</div>
