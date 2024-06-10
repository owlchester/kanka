<?php
$required = !isset($bulk);
$fieldname = $iconFieldName ?? 'icon';
?>
<x-forms.field
    field="icon"
    :label="__('entities/links.fields.icon')">
    @if($campaign->boosted())
        <input type="text" name="{{ $fieldname }}" value="{{ !isset($bulk) ? old($fieldname, $source->{$fieldname} ?? $model->icon ?? null) : null }}" placeholder="{{ $placeholder ?? 'fa-solid fa-users' }}" class="w-full" autocomplete="off" data-paste="fontawesome" maxlength="45" />
        <x-helper>
            {!! __('entities/links.helpers.icon', [
                'fontawesome' => '<a target="_blank" href="' . config('fontawesome.search') .'">FontAwesome</a>',
                'rpgawesome' => '<a target="_blank" href="https://nagoshiashumari.github.io/Rpg-Awesome/">RPGAwesome</a>',
                'docs' => '<a target="_blank" href="https://docs.kanka.io/en/latest/articles/available-icons.html">' . __('footer.documentation') . '</a>'
            ]) !!}
        </x-helper>
    @else
        @if (auth()->user()->hasBoosters())
            <x-helper>
                {!! __('callouts.booster.pitches.icon', ['boosted-campaign' => '<a href="' . route('settings.premium', ['campaign' => $campaign]) . '">' . __('concept.premium-campaign') . '</a>']) !!}
            </x-helper>
        @else
            <x-helper>
                {!! __('callouts.booster.pitches.icon', ['boosted-campaign' => '<a href="https://kanka.io/premium">' . __('concept.premium-campaigns') . '</a>']) !!}
            </x-helper>
        @endif
    @endif
</x-forms.field>
