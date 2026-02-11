<?php /** @var \App\Models\Campaign $model */?>
<div class="tab-pane" id="form-public">
    <x-grid type="1/1">

        <x-grid type="1/1">
            @include('campaigns.forms._visibility', ['campaign' => $model ?? null])

            @if (isset($model) && $model->isPublic())
                <x-helper>
                    <p>{!! __('campaigns.helpers.view_public', ['link' => '<a href="' . route('dashboard', $campaign) . '" class="text-link">' . route('dashboard', $campaign) . '</a>']) !!}</p>
                </x-helper>

                @if ($model->publicHasNoVisibility())
                    <x-alert type="warning">
                        {!! __('campaigns.helpers.public_no_visibility', [
                    'public' => $campaign->publicRole->name,
        'fix' => '<a href="' . route('campaigns.campaign_roles.public', $campaign) . '" class="text-link">' . __('crud.fix-this-issue') . '</a>',
        ]) !!}
                    </x-alert>
                @endif
            @endif
            <hr />

            <h4 class="m-0 text-lg">{{ __('campaigns.fields.public_campaign_filters') }}</h4>

            <x-helper>
                <p>{!! __('campaigns.sharing.filters', [
        'public-campaigns' => '<a href="https://kanka.io/campaigns" target="_blank" class="text-link">' . __('footer.public-campaigns') . '</a>'
        ]) !!}</p>
            </x-helper>

            <x-grid>
                <x-forms.field
                        field="locale"
                        :label="__('campaigns.fields.locale')"
                        :helper="__('campaigns.sharing.language')">
                    <x-forms.select name="locale" :options="$languages->getSupportedLanguagesList(true)" :selected="$campaign->locale ?? null" />
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
                    field="systems[]"
                    label="campaigns.fields.system"
                    :multiple="true"
                    :helper="__('campaigns.sharing.system')"
                    name="systems[]"
                    id="system[]"
                    :placeholder="__('campaigns.placeholders.system')"
                    allowClear="true"
                    :route="route('search.systems')"
                    :selected="$selected">
                >
                </x-forms.foreign>

                <x-forms.field
                    field="genre"
                    :label="__('campaigns.fields.genre')">
                    <input type="hidden" name="campaign_genre" value="1">
                    @include('components.form.genres', ['options' => [
                        'model' => $model ?? null,
                        'quickCreator' => false
                    ]])
                </x-forms.field>
            </x-grid>

        </x-grid>
    </x-grid>
</div>
