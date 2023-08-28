@php $helper = __('maps/markers.helpers.custom_icon_v2', [
        'rpgawesome' => '<a href="https://nagoshiashumari.github.io/Rpg-Awesome/" target="_blank">RPG Awesome</a>',
'fontawesome' => '<a href="' . config('fontawesome.search') . '" target="_blank">Font Awesome</a>',
'docs' => link_to('https://docs.kanka.io/en/latest/entities/maps/markers.html#custom-icon', __('footer.documentation'), ['target' => '_blank'])
]); @endphp
<x-forms.field
    field="icon"
    :label="__('maps/markers.fields.custom_icon')"
    :helper="$helper"
    >
    {!! Form::text(
        $fieldname ?? 'custom_icon',
        \App\Facades\FormCopy::field($fieldname ?? 'custom_icon')->string(),
        ['class' => 'form-control',
        'placeholder' => __('maps/markers.placeholders.custom_icon', ['example1' => '"fa-solid fa-gem"', 'example2' => '"ra ra-aura"']),
        'list' => 'map-marker-icon-list',
        'autocomplete' => 'off',
        'data-paste' => 'fontawesome',
        ($campaign->boosted() ? null : 'disabled')])
    !!}
    @if (!$campaign->boosted())
        @subscriber()
        <p class="help-block">
            <x-icon class="premium"></x-icon> {!! __('crud.errors.boosted_campaigns', ['boosted' => link_to_route('settings.premium', __('concept.premium-campaign'), ['campaign' => $campaign])]) !!}
        </p>
    @else
        <p class="help-block">
            <x-icon class="premium"></x-icon> {!! __('crud.errors.boosted_campaigns', ['boosted' => link_to('https://kanka.io/premium', __('concept.boosted-campaign'))]) !!}
        </p>
        @endsubscriber
    @endif

    <div class="hidden">
        <datalist id="map-marker-icon-list">
            @foreach (\App\Facades\MapMarkerCache::iconSuggestion() as $icon)
                <option value="{{ $icon }}">{{ $icon }}</option>
            @endforeach
        </datalist>
    </div>
</x-forms.field>
