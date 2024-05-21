<?php
$required = !isset($bulk);
?>
<x-forms.field
    field="icon"
    :label="__('entities/links.fields.icon')">
    @if($campaign->boosted())

        {!! Form::text(
            $iconFieldName ?? 'icon',
            null,
            [
                'placeholder' => $placeholder ?? 'fa-solid fa-users',
                'class' => 'w-full',
                'data-paste' => 'fontawesome',
                'maxlength' => 45
            ]
        ) !!}
        <x-helper>
            {!! __('entities/links.helpers.icon', [
                'fontawesome' => link_to(config('fontawesome.search'), 'FontAwesome', ['target' => '_blank']),
                'rpgawesome' => link_to('https://nagoshiashumari.github.io/Rpg-Awesome/', 'RPGAwesome', ['target' => '_blank']),
                'docs' => link_to('https://docs.kanka.io/en/latest/articles/available-icons.html', __('footer.documentation', ['target' => '_blank']))
            ]) !!}
        </x-helper>
    @else
        @if (auth()->user()->hasBoosters())
            <x-helper>
                {!! __('callouts.booster.pitches.icon', ['boosted-campaign' => link_to_route('settings.premium', __('concept.premium-campaigns'), ['campaign' => $campaign])]) !!}
            </x-helper>
        @else
            <x-helper>
                {!! __('callouts.booster.pitches.icon', ['boosted-campaign' => link_to('https://kanka.io/premium', __('concept.premium-campaigns'))]) !!}
            </x-helper>
        @endif
    @endif
</x-forms.field>
