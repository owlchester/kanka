<?php
$required = !isset($bulk);
$fieldname = $iconFieldName ?? 'icon';
?>
<x-forms.field
    field="icon"
    :label="__('entities/links.fields.icon')">
    @if($campaign->boosted())
        <input type="text" name="{{ $fieldname }}" value="{{ !isset($bulk) ? old($fieldname, $source->{$fieldname} ?? $model->icon ?? null) : null }}" placeholder="{{ $placeholder ?? 'fa-solid fa-users' }}" list="link-icon-list" class="w-full" autocomplete="off" data-paste="fontawesome" maxlength="45" />
        <div class="hidden">
            <datalist id="link-icon-list">
                @foreach ($suggestions ?? \App\Facades\EntityAssetCache::iconSuggestion() as $icon)
                    <option value="{{ $icon }}">{{ $icon }}</option>
                @endforeach
            </datalist>
        </div>
        <x-slot name="helper">
            {!! __('entities/links.helpers.icon', [
                'fontawesome' => '<a href="' . config('fontawesome.search') .'">FontAwesome</a>',
                'rpgawesome' => '<a href="https://nagoshiashumari.github.io/Rpg-Awesome/">RPGAwesome</a>',
                'docs' => '<a href="https://docs.kanka.io/en/latest/articles/available-icons.html">' . __('footer.documentation') . '</a>',
                'example' => '<i class="fa-solid fa-horse" aria-hidden="true"></i> <code>fa-solid fa-horse</code>',
            ]) !!}
        </x-slot>
    @else
        <x-slot name="helper">
        @can('boost', auth()->user())
            {!! __('callouts.booster.pitches.icon', [
                'boosted-campaign' => '<a href="' . route('settings.premium', ['campaign' => $campaign]) . '">' . __('concept.premium-campaign') . '</a>',
                'fontawesome' => '<a href="' . config('fontawesome.search') .'">FontAwesome</a>',
            ]) !!}
        @else
            {!! __('callouts.booster.pitches.icon', [
                'boosted-campaign' => '<a href="https://kanka.io/premium">' . __('concept.premium-campaign') . '</a>',
                'fontawesome' => '<a href="' . config('fontawesome.search') .'">FontAwesome</a>',
            ]) !!}
        @endif
        </x-slot>
    @endif
</x-forms.field>
