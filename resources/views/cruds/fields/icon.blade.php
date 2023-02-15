<?php
$required = !isset($bulk);
$horizontalForm = isset($horizontalForm) ? $horizontalForm : false;
?>
<div class="form-group">
    <label @if($horizontalForm) class="control-label col-sm-3 col-lg-2" @endif>{{ __('entities/links.fields.icon') }}</label>
        @if($campaign->boosted())
            @if($horizontalForm) <div class="col-sm-9 col-lg-10"> @endif
                {!! Form::text(
                    'icon',
                    null,
                    [
                        'placeholder' => 'fa-solid fa-users',
                        'class' => 'form-control',
                        'maxlength' => 45
                    ]
                ) !!}
                @if ($horizontalForm) </div> @endif
                <p class="help-block">
                    {!! __('entities/links.helpers.icon', [
                        'fontawesome' => link_to(config('fontawesome.search'), 'FontAwesome', ['target' => '_blank'])
                    ]) !!}
                </p>
            @else
                @subscriber()
                <p class="help-block">
                    {!! __('callouts.booster.pitches.icon', ['boosted-campaign' => link_to_route('settings.boost', __('concept.boosted-campaign'), ['campaign' => $campaign])]) !!}
                </p>
            @else
                <p class="help-block">
                    {!! __('callouts.booster.pitches.icon', ['boosted-campaign' => link_to_route('front.boosters', __('concept.boosted-campaign'))]) !!}
                </p>
                @endsubscriber

            @endif
        </div>
