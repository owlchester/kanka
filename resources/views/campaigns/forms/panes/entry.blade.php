@php /** @var \App\Models\Campaign $model */ @endphp
<div class="tab-pane {{ (request()->get('tab') == null ? ' active' : '') }}" id="form-entry">
    <x-grid type="1/1">
        <x-forms.field
            field="name"
            :required="true"
            :label="__('campaigns.fields.name')"
            :helper="__('campaigns.helpers.name')">
            <input type="text" name="name" placeholder="{{ __('campaigns.placeholders.name') }}" data-live-disabled="1" maxlength="191" required value="{!! old('name', $model->name ?? null) !!}" />
        </x-forms.field>

        <x-forms.field
            field="vanity"
            :label="__('campaigns.fields.vanity')">
            @if (isset($model) && $model->hasVanity())
                <x-helper :text="__('campaigns/vanity.set', ['vanity' => '<code>' . $model->slug . '</code>'])" />
            @elseif(isset($model) && $model->premium())
                <x-helper>{!! __('campaigns/vanity.helper', [
    'default' => '<code>w/' . (isset($model) ? $model->id : 123456) . '</code>',
    'example' => '<code>w/exandria-unlimited</code>',
    'learn-more' => '<a target="_blank" href="https://docs.kanka.io/en/latest/features/campaigns/vanity-url.html">' . __('footer.documentation') . '</a>'
    ]) !!}</x-helper>

                <input type="text" maxlength="45" name="vanity" class="w-full" data-url="{{ route('campaign.vanity-validate', $model) }}" value="{{ old('vanity') }}"/>
                <p class="hidden" id="vanity-loading">
                    <x-icon class="loading" />
                </p>
                <p class="text-error hidden" id="vanity-error"></p>
                <div class="alert alert-success my-1 rounded px-2 py-1 hidden" id="vanity-success">
                    <p>{!! __('campaigns/vanity.available', ['vanity' => '<code></code>']) !!}</p>
                </div>
            @else
                <x-helper>{!! __('campaigns/vanity.helper', [
    'default' => '<code>w/' . (isset($model) ? $model->id : 123456) . '</code>',
    'example' => '<code>w/exandria-unlimited</code>',
    'learn-more' => '<a target="_blank" href="https://docs.kanka.io/en/latest/features/campaigns/vanity-url.html">' . __('footer.documentation') . '</a>'
    ]) !!}</x-helper>
                @if (isset($model))
                    @if ($model->legacyBoosted())
                        <a href="{{ route('settings.boost') }}">Switch to premium campaigns to unlock vanity urls on campaigns.</a>
                    @else
                        <a href="{{ route('settings.premium') }}">{{ __('callouts.premium.unlock', ['campaign' => $campaign->name]) }}</a>
                    @endif
                @else
                    <input type="text" maxlength="45" name="" class="w-full" readonly="readonly" />
                @endif
            @endif
        </x-forms.field>

        <x-forms.field
            field="entry"
            :label="__('campaigns.fields.description')">
            <textarea name="entry" id="entry" class="w-full html-editor">{!! old('entry', $campaign->entryForEdition ?? null) !!}</textarea>
        </x-forms.field>

        @include('cruds.fields.image-old', ['model' => $campaign ?? null, 'campaignImage' => true, 'imageLabel' => 'campaigns.fields.image', 'recommended' => '240x210'])
    </x-grid>
</div>
