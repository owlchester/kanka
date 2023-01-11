<div class="form-group">
    <label>{{ __('maps/markers.fields.custom_icon') }}</label>
    {!! Form::text(
        $fieldname ?? 'custom_icon',
        \App\Facades\FormCopy::field('custom_icon')->string(),
        ['class' => 'form-control',
        'placeholder' => __('maps/markers.placeholders.custom_icon', ['example1' => '"fa-solid fa-gem"', 'example2' => '"ra ra-aura"']),
        'list' => 'map-marker-icon-list',
        'autocomplete' => 'off',
        'data-paste' => 'fontawesome',
        ($campaignService->campaign()->boosted() ? null : 'disabled')])
    !!}
    <p class="help-block">{!! __('maps/markers.helpers.custom_icon_v2', [
        'rpgawesome' => '<a href="https://nagoshiashumari.github.io/Rpg-Awesome/" target="_blank">RPG Awesome</a>',
        'fontawesome' => '<a href="' . config('fontawesome.search') . '" target="_blank">Font Awesome</a>',
        'docs' => link_to('https://docs.kanka.io/en/latest/entities/maps/markers.html#custom-icon', __('front.menu.documentation'), ['target' => '_blank'])
        ]) !!}</p>
    @if (!$campaignService->campaign()->boosted())
        @subscriber()
        <p class="help-block">
            <i class="fa-solid fa-rocket" aria-hidden="true"></i> {!! __('crud.errors.boosted_campaigns', ['boosted' => link_to_route('settings.boost', __('concept.boosted-campaign'), ['campaign' => $campaignService->campaign()])]) !!}
        </p>
    @else
        <p class="help-block">
            <i class="fa-solid fa-rocket" aria-hidden="true"></i> {!! __('crud.errors.boosted_campaigns', ['boosted' => link_to_route('front.boosters', __('concept.boosted-campaign'))]) !!}
        </p>
        @endsubscriber
    @endif
</div>
<div class="hidden">
    <datalist id="map-marker-icon-list">
        @foreach (\App\Facades\MapMarkerCache::iconSuggestion() as $icon)
            <option value="{{ $icon }}">{{ $icon }}</option>
        @endforeach
    </datalist>
</div>
