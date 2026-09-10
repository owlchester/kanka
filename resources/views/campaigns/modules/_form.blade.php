<?php /**
 * @var \App\Models\Campaign $campaign
 * @var \App\Models\EntityType $entityType
 */
?>
<x-grid type="1/1">
    <x-helper>
        <p>
            {{ __('campaigns/modules.rename.helper') }}
        </p>
    </x-helper>

    <x-forms.field
        field="status"
        :label="__('campaigns/modules.fields.status')"
    >
        <div class="flex flex-col gap-2">
            <div class="rounded-xl border border-base-300 p-2 flex gap-2 items-start cursor-pointer hover:shadow-sm">
                <input type="radio" name="enabled" id="status-enabled" value="1" class="mt-1" @if ($campaign->enabled($entityType)) checked="checked" @endif />
                <label for="status-enabled" class="w-full cursor-pointer">
                    {{ __('campaigns/modules.states.enabled') }}
                </label>
            </div>
            <div class="rounded-xl border border-base-300 p-2 flex gap-2 items-start cursor-pointer hover:shadow-sm">
                <input type="radio" name="enabled" id="status-disabled" value="0" class="mt-1" @if (!$campaign->enabled($entityType)) checked="checked" @endif />
                <label for="status-disabled" class="w-full cursor-pointer">
                    {{ __('campaigns/modules.states.disabled') }}
                    <p class="text-xs text-neutral-content">
                        {{ __('campaigns/modules.helpers.status') }}
                    </p>
                </label>
            </div>
        </div>
    </x-forms.field>

    @if (!$campaign->boosted())
        <div class="rounded-xl border border-warning-content/40 bg-warning/20 p-4 flex flex-col gap-4">
            <div class="flex items-start gap-3">
                <div class="flex h-10 w-10 flex-none items-center justify-center rounded-lg bg-warning text-warning-content">
                    <x-icon class="premium" />
                </div>
                <div class="flex flex-col gap-2">
                    <div class="flex flex-col gap-1">
                        <h4 class="font-bold leading-tight">{{ __('campaigns/modules.rename.premium.title') }}</h4>
                        <p class="text-xs text-base-content mb-1">
                            {{ __('campaigns/modules.rename.premium.description') }}
                        </p>
                    </div>
                    @can('boost', auth()->user())
                        <a href="{{ route('settings.premium', ['campaign' => $campaign]) }}" class="btn2 btn-primary btn-sm self-start">
                            {{ __('campaigns/modules.rename.premium.upgrade', ['campaign' => $campaign->name]) }}
                        </a>
                    @else
                        <a href="{{ route('settings.subscription', ['f' => 'cta', 'w' => $campaign->id]) }}" class="btn2 btn-primary btn-sm self-start">
                            {{ __('callouts.actions.subscription') }}
                        </a>
                    @endcan
                </div>
            </div>
    @endif

    <x-forms.field
        field="singular"
        :helper="__('campaigns/modules.helpers.singular')">
        <x-slot:label>
            {{ __('campaigns/modules.fields.singular') }}
            @if (!$campaign->boosted())
                <x-icon class="lock" />
            @endif
        </x-slot:label>
        <input type="text" name="singular" value="{!! old('singular', $singular) !!}" maxlength="45" class="w-full @if (!$campaign->boosted()) form-control @endif" placeholder="{{ $entityType->name() }}" @if (!$campaign->boosted()) disabled="disabled" @endif" />
    </x-forms.field>

    <x-forms.field
        field="plural"
        :helper="__('campaigns/modules.helpers.plural')">
        <x-slot:label>
            {{ __('campaigns/modules.fields.plural') }}
            @if (!$campaign->boosted())
                <x-icon class="lock" />
            @endif
        </x-slot:label>
        <input type="text" name="plural" value="{!! old('plural', $plural) !!}" maxlength="45" class="w-full @if (!$campaign->boosted()) form-control @endif" placeholder="{{ $entityType->plural() }}" @if (!$campaign->boosted()) disabled="disabled" @endif />
    </x-forms.field>

    <x-forms.field
        field="icon"
        :helper="__('campaigns/modules.helpers.icon', [
        'fontawesome' => '<a href=\'' . config('fontawesome.search') . '\' class=\'text-link\'>FontAwesome</a>',
        'example' => '<i class=\'fa-solid fa-horse\' aria-hidden=\'true\'></i> <span class=\'font-bold\'>fa-solid fa-horse</span>',
        ])">
        <x-slot:label>
            {{ __('campaigns/modules.fields.icon') }}
            @if (!$campaign->boosted())
                <x-icon class="lock" />
            @endif
        </x-slot:label>
        <input type="text" name="icon" value="{{ old('icon', $icon) }}" maxlength="60" class="w-full @if (!$campaign->boosted()) form-control @endif" list="module-icon-list" placeholder="{{ $entityType->icon() }}" @if (!$campaign->boosted()) disabled="disabled" @endif />
    </x-forms.field>

    @if (!$campaign->boosted())
        </div>
    @endif

    @includeWhen(!$entityType->isBookmark() && $campaign->boosted(), 'cruds.fields.image-old', ['model' => $entityType ?? null, 'campaignImage' => true, 'imageLabel' => 'campaigns/modules.fields.image', 'isModule' => true, 'image' => isset($image) ? Img::crop(96, 96)->url($image['path']) : null])

</x-grid>
