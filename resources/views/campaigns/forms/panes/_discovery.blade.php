<?php /** @var \App\Models\Campaign $model */?>
<h4 class="text-lg">{{ __('campaigns.fields.public_campaign_filters') }}</h4>

<x-helper>
    <p>
        {!! __('campaigns.sharing.filters', [
'public-campaigns' => '<a href="https://kanka.io/campaigns" target="_blank" class="text-link">' . __('footer.public-campaigns') . '</a>'
]) !!}
    </p>
</x-helper>

<x-grid>
    <x-forms.field
            field="locale"
            required
            :label="__('campaigns.fields.locale')"
            :helper="__('campaigns.sharing.language')">
        <x-forms.select name="locale" :options="$languages" :selected="$campaign->locale ?? null" />
    </x-forms.field>
    @php
        $selected = [];
        if (isset($model)) {
            foreach ($model->systems as $system) {
                $selected[$system->id] = $system->name;
            }
        }
    @endphp
    <x-forms.foreign
        field="systems"
        label="campaigns.fields.system"
        required
        :multiple="true"
        :helper="__('campaigns.sharing.system')"
        name="systems[]"
        id="systems[]"
        :placeholder="__('campaigns.placeholders.system')"
        allowClear="true"
        :route="route('search.systems')"
        :selected="$selected">
    >
    </x-forms.foreign>

    <x-forms.field
        field="genre"
        required
        :label="__('campaigns.fields.genre')">
        <input type="hidden" name="campaign_genre" value="1">
        @include('components.form.genres', ['options' => [
            'model' => $model ?? null,
            'quickCreator' => false
        ]])
    </x-forms.field>
</x-grid>

