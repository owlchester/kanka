<div class="tab-pane" id="form-public">
    <div class="row">
        <div class="col-md-6">
    {!! Form::hidden('is_public', 0) !!}
    <label>{!! Form::checkbox('is_public') !!}
        {{ __('campaigns.visibilities.public') }}
    </label>
    <p class="help-block">{{ __('campaigns.helpers.visibility') }}<br />
        <a href="https://www.youtube.com/watch?v=VpY_D2PAguM" target="_blank"><i class="fas fa-external-link-alt"></i> {{ __('helpers.public') }}</a>
    </p>

            <p class="help-block">
                {!! __('campaigns.helpers.view_public', ['link' => '<a href="' . route('dashboard') . '" target="_blank">' . route('dashboard') . '</a>']) !!}
            </p>
        </div>
    </div>

    <hr />

    <h4>{{ __('campaigns.fields.public_campaign_filters') }}</h4>

    <p class="help-block">{{ __('campaigns.helpers.public_campaign_filters') }}</p>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>{{ __('campaigns.fields.locale') }}</label>
                {!! Form::select('locale', $languages->getSupportedLanguagesList(true), null, ['class' => 'form-control']) !!}
                <p class="help-block">{{ __('campaigns.helpers.locale') }}</p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>{{ __('campaigns.fields.system') }}</label>
                {!! Form::text('system', null, [
                    'placeholder' => __('campaigns.placeholders.system'),
                    'class' => 'form-control',
                    'list' => 'rpg-system-list',
                    'autocomplete' => 'off'
                ]) !!}
                <p class="help-block">{!! __('campaigns.helpers.system', [
                        'link' => link_to_route('front.public_campaigns', __('front.menu.campaigns'), null, ['target' => '_blank'])
                    ]) !!}</p>
            </div>

            <div class="hidden">
                <datalist id="rpg-system-list">
                    @foreach (__('rpg_systems.names') as $name)
                        <option value="{{ $name }}">{{ $name }}</option>
                    @endforeach
                </datalist>
            </div>
        </div>
    </div>
</div>
