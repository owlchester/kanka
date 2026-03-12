<x-grid>
    @include('cruds.fields.entity-name')
    @include('cruds.fields.type', ['base' => \App\Models\Tag::class, 'trans' => 'tags'])

    @include('cruds.fields.tag', ['isParent' => true])
    @include('cruds.fields.colour')

    @php $iconHelper = __('tags.helpers.icon', [
        'fontawesome' => '<a href="' . config('fontawesome.search') . '" target="_blank">Font Awesome</a>',
        'rpgawesome' => '<a href="https://nagoshiashumari.github.io/Rpg-Awesome/" target="_blank">RPG Awesome</a>',
    ]) @endphp
    <x-forms.field field="icon" :label="__('tags.fields.icon')" :helper="$iconHelper">
        <input type="text" name="icon" value="{{ old('icon', $source->child->icon ?? $model->icon ?? null) }}" placeholder="{{ __('tags.placeholders.icon', ['example1' => '"fa-solid fa-gem"', 'example2' => '"ra ra-aura"']) }}" autocomplete="off" data-paste="fontawesome" @if (!$campaign->boosted()) disabled="disabled" @endif />
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
    </x-forms.field>

    <x-forms.field field="icon-in-label" :label="__('tags.fields.icon_in_label')">
        <input type="hidden" name="icon_in_label" value="0" />
        <x-checkbox :text="__('tags.hints.icon_in_label')">
            <input type="checkbox" name="icon_in_label" value="1" @if (old('icon_in_label', $source->child->icon_in_label ?? $model->icon_in_label ?? false)) checked="checked" @endif @if (!$campaign->boosted()) disabled="disabled" @endif />
        </x-checkbox>
    </x-forms.field>

    @include('cruds.fields.entry2')

    <x-forms.field field="auto-apply" :label="__('tags.fields.is_auto_applied')">
        <input type="hidden" name="is_auto_applied" value="0" />
        <x-checkbox :text="__('tags.hints.is_auto_applied')">
            <input type="checkbox" name="is_auto_applied" value="1" @if (old('is_auto_applied', $source->child->is_auto_applied ?? $model->is_auto_applied ?? false)) checked="checked" @endif />
        </x-checkbox>
    </x-forms.field>
    <x-forms.field field="hidden" :label="__('tags.fields.is_hidden')">
        <input type="hidden" name="is_hidden" value="0" />
        <x-checkbox :text="__('tags.hints.is_hidden')">
            <input type="checkbox" name="is_hidden" value="1" @if (old('is_hidden', $source->child->is_hidden ?? $model->is_hidden ?? false)) checked="checked" @endif />
        </x-checkbox>
    </x-forms.field>

    @include('cruds.fields.tags')
    @include('cruds.fields.image')

</x-grid>
