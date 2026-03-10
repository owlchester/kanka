@php $helper = __('maps/markers.helpers.custom_icon_v2', [
        'rpgawesome' => '<a href="https://nagoshiashumari.github.io/Rpg-Awesome/" target="_blank">RPG Awesome</a>',
'fontawesome' => '<a href="' . config('fontawesome.search') . '" target="_blank">Font Awesome</a>',
'docs' => '<a href="https://docs.kanka.io/en/latest/entries/maps/markers.html#custom-icon" target="_blank">' . __('footer.documentation') . '</a>',
]);
 $fieldname = $fieldname ?? 'custom_icon';
 @endphp
<x-forms.field
    field="icon"
    :label="__('maps/markers.fields.custom_icon')"
    :helper="$helper"
    >

    <input type="text" name="{{ $fieldname }}" value="{{ old($fieldname, $source->{$fieldname} ?? $model->{$fieldname} ?? null) }}" placeholder="{{ __('maps/markers.placeholders.custom_icon', ['example1' => '"fa-solid fa-gem"', 'example2' => '"ra ra-aura"']) }}" list="map-marker-icon-list" autocomplete="off" data-paste="fontawesome" @if (!$campaign->boosted()) disabled="disabled" @endif />
    @if (!$campaign->boosted())
        @can('boost', auth()->user())
            <x-helper>
                <p><x-icon class="premium" /> {!! __('crud.errors.boosted_campaigns', ['boosted' => '<a href="' . route('settings.premium', ['campaign' => $campaign]) . '">' . __('concept.premium-campaign') . '</a>']) !!}</p>
            </x-helper>
        @else
            <x-helper>
                <p><x-icon class="premium" /> {!! __('crud.errors.boosted_campaigns', ['boosted' => '<a href="https://kanka.io/premium">' . __('concepts.premium-campaign') . '</a>']) !!}</p>
            </x-helper>
        @endif
    @endif

    <div class="hidden">
        <datalist id="map-marker-icon-list">
            @foreach (\App\Facades\MapMarkerCache::campaign($campaign)->iconSuggestion() as $icon)
                <option value="{{ $icon }}">{{ $icon }}</option>
            @endforeach
        </datalist>
    </div>
</x-forms.field>
