<?php
$required = !isset($bulk);
?>
<div class="field-icon">
    <label>{{ __('entities/links.fields.icon') }}</label>
    @if($campaignService->campaign()->boosted())

        {!! Form::text(
            $iconFieldName ?? 'icon',
            null,
            [
                'placeholder' => $placeholder ?? 'fa-solid fa-users',
                'class' => 'form-control',
                'maxlength' => 45
            ]
        ) !!}
        <p class="help-block">
            {!! __('entities/links.helpers.icon', [
                'fontawesome' => link_to(config('fontawesome.search'), 'FontAwesome', ['target' => '_blank']),
                'rpgawesome' => link_to('https://nagoshiashumari.github.io/Rpg-Awesome/', 'RPGAwesome', ['target' => '_blank']),
                'docs' => link_to('https://docs.kanka.io/en/latest/features/campaigns/sidebar.html#what-fonts-are-available', __('front.menu.documentation', ['target' => '_blank']))
            ]) !!}
        </p>
    @else
        @subscriber()
        <p class="help-block">
            {!! __('callouts.booster.pitches.icon', ['boosted-campaign' => link_to_route('settings.premium', __('concept.premium-campaigns'), ['campaign' => $campaignService->campaign()])]) !!}
        </p>
    @else
        <p class="help-block">
            {!! __('callouts.booster.pitches.icon', ['boosted-campaign' => link_to_route('front.premium', __('concept.premium-campaigns'))]) !!}
        </p>
        @endsubscriber
    @endif
</div>
