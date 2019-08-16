<div class="tab-pane {{ (request()->get('tab') == null ? ' active' : '') }}" id="form-entry">
    <div class="form-group required">
        <label>{{ __('campaigns.fields.name') }}</label>
        {!! Form::text('name', null, ['placeholder' => __('campaigns.placeholders.name'), 'class' => 'form-control', 'required']) !!}
        <p class="help-block">{{ __('campaigns.helpers.name') }}</p>
    </div>

    <div class="form-group">
        <label>{{ __('campaigns.fields.description') }}</label>
        {!! Form::textarea('entry', null, ['class' => 'form-control html-editor', 'id' => 'entry']) !!}
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>{{ __('campaigns.fields.locale') }}</label>
                {!! Form::select('locale', $languages->getSupportedLanguagesList(true), \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale(), ['class' => 'form-control']) !!}
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
                    'link' => link_to_route('public_campaigns', __('front.menu.campaigns'), ['target' => '_blank'])
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

    @include('cruds.fields.image')
</div>