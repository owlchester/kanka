@php /** @var \App\Models\Campaign $model */ @endphp
<div class="tab-pane {{ (request()->get('tab') == null ? ' active' : '') }}" id="form-entry">
    <x-grid type="1/1">
        <div class="field-name required">
            <label>
                {{ __('campaigns.fields.name') }}
            </label>
            {!! Form::text('name', null, ['placeholder' => __('campaigns.placeholders.name'), 'class' => 'form-control', 'required', 'maxlength' => 191]) !!}
            <p class="help-block">{{ __('campaigns.helpers.name') }}</p>
        </div>

        <div class="field-vanity">
            <label>{{ __('campaigns.fields.vanity') }}</label>

            @if (isset($model) && $model->hasVanity())
                <p class="help-block">{!! __('campaigns/vanity.set', ['vanity' => '<code>' . $model->slug . '</code>']) !!}</p>
            @elseif(isset($model) && $model->premium())
                <p class="help-block">{!! __('campaigns/vanity.helper', [
    'default' => '<code>w/' . (isset($model) ? $model->id : 123456) . '</code>',
    'example' => '<code>w/exandria-unlimited</code>',
    'learn-more' => link_to('https://docs.kanka.io/en/latest/features/campaigns/vanity-url.html', __('footer.documentation', ['target' => '_blank']))
    ]) !!}</p>

                <input type="text" maxlength="45" name="vanity" class="form-control" data-url="{{ route('campaign.vanity-validate', $model) }}" value="{{ old('vanity') }}"/>
                <p style="display: none" id="vanity-loading">
                    <x-icon class="loading" />
                </p>
                <p class="text-red" style="display: none" id="vanity-error"></p>
                <div class="alert alert-success my-1 rounded px-2 py-1" style="display: none" id="vanity-success">
                    <p>{!! __('campaigns/vanity.available', ['vanity' => '<code></code>']) !!}</p>
                </div>
            @else
                <p class="help-block">{!! __('campaigns/vanity.helper', [
    'default' => '<code>w/' . (isset($model) ? $model->id : 123456) . '</code>',
    'example' => '<code>w/exandria-unlimited</code>',
    'learn-more' => link_to('https://docs.kanka.io/en/latest/features/campaigns/vanity-url.html', __('footer.documentation', ['target' => '_blank']))
    ]) !!}</p>

                <input type="text" maxlength="45" name="" class="form-control" readonly="readonly" />
            @endif
        </div>

        <div class="field-entry">
            <label>{{ __('campaigns.fields.description') }}</label>
            {!! Form::textarea('entryForEdition', null, ['class' => 'form-control html-editor', 'id' => 'entry', 'name' => 'entry']) !!}
        </div>

        @include('cruds.fields.image', ['campaignImage' => true, 'imageLabel' => 'campaigns.fields.image'])
    </x-grid>
</div>
