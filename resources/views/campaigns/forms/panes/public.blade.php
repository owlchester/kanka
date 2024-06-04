<?php /** @var \App\Models\Campaign $model */?>
<div class="tab-pane" id="form-public">
    <x-grid type="1/1">
        @if (isset($campaign))
            <x-tutorial code="public_campaign_helper">
                <p class="mb-2">
                    {!! __('campaigns/public.helpers.main', [
                        'public-campaigns' => link_to('https://kanka.io/campaigns', __('footer.public-campaigns'), null, ['target' => '_blank']),
                        'public-role' => link_to_route('campaigns.campaign_roles.public', __('campaigns.members.roles.public'), $campaign, ['target' => '_blank'])
                    ]) !!}
                </p>
                <p>
                    <a href="https://www.youtube.com/watch?v=VpY_D2PAguM" target="_blank">
                        <x-icon class="fa-solid fa-external-link-alt" />
                        {{ __('helpers.public') }}
                    </a>
                </p>
            </x-tutorial>
        @endif

        <x-grid type="1/1">
            <x-forms.field
                field="public"
                :label="__('campaigns.fields.public')"
                >
                {!! Form::select('is_public', [0 => __('campaigns.visibilities.private'), 1 => __('campaigns.visibilities.public')], null, ['class' => '']) !!}
            </x-forms.field>

            <x-forms.field field="discreet" :label="__('campaigns.fields.is_discreet')" :disabled="true">
                @if (isset($model) && $model->boosted())
                    <input type="hidden" name="is_discreet" value="0" />
                    <x-checkbox :text="__('campaigns.helpers.is_discreet', ['public-campaigns' => link_to('https://kanka.io/campaigns', __('footer.public-campaigns'))])">
                        <input type="checkbox" name="is_discreet" value="1" @if (old('is_discreet', $model->is_discreet ?? false)) checked="checked" @endif />
                    </x-checkbox>
                @else
                    <x-checkbox :text="__('campaigns.helpers.is_discreet_locked', ['public-campaigns' => link_to('https://kanka.io/campaigns', __('footer.public-campaigns'))])">
                        <input type="checkbox" name="premium_feature" value="1" disabled="disabled" />
                    </x-checkbox>
                @endif
            </x-forms.field>

            @if (isset($model) && $model->isPublic())
                <x-helper>
                    {!! __('campaigns.helpers.view_public', ['link' => '<a href="' . route('dashboard', $campaign) . '" target="_blank">' . route('dashboard', $campaign) . '</a>']) !!}
                </x-helper>

                @if ($model->publicHasNoVisibility())
                    <x-alert type="warning">
                        {!! __('campaigns.helpers.public_no_visibility', [
        'fix' => link_to_route('campaigns.campaign_roles.public', __('crud.fix-this-issue'), $campaign)
        ]) !!}
                    </x-alert>
                @endif
            @endif
            <hr />

            <h4 class="m-0">{{ __('campaigns.fields.public_campaign_filters') }}</h4>

            <p>
                {!! __('campaigns.sharing.filters', [
        'public-campaigns' => link_to('https://kanka.io/campaigns', __('footer.public-campaigns'), null, ['target' => '_blank'])
        ]) !!}
            </p>

            <x-grid>
                <x-forms.field
                        field="locale"
                        :label="__('campaigns.fields.locale')"
                        :helper="__('campaigns.sharing.language')">
                    {!! Form::select('locale', $languages->getSupportedLanguagesList(true), null, ['class' => 'w-full']) !!}
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
                    :selected="$selected"
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
