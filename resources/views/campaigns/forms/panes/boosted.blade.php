@php
$themes = [null => ''];
foreach (\App\Models\Theme::all() as $theme):
    $themes[$theme->id] = $theme->__toString();
endforeach;
@endphp

<div class="tab-pane" id="form-boosted">
    @include('cruds.partials.boosted')

    <div class="form-group">
        <label>{{ __('campaigns.fields.theme') }}</label>
        {!! Form::select(
            'theme_id',
            $themes,
            null,
            [
                'class' => 'form-control'
            ]
        ) !!}
        <p class="help-block">{{ __('campaigns.helpers.theme') }}</p>
    </div>

    <div class="form-group">
        <label>{{ __('campaigns.fields.css') }}</label>
        {!! Form::textarea('css', null, ['class' => 'form-control', 'id' => 'css']) !!}
        <p class="help-block">{{ __('campaigns.helpers.css') }}</p>
    </div>

    <hr />
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                {!! Form::hidden('hide_members', 0) !!}
                <label>{!! Form::checkbox('hide_members', 1) !!}
                    {{ __('campaigns.fields.hide_members') }}
                </label>
                <p class="help-block">{{ __('campaigns.helpers.hide_members') }}</p>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                {!! Form::hidden('hide_history', 0) !!}
                <label>{!! Form::checkbox('hide_history', 1) !!}
                    {{ __('campaigns.fields.hide_history') }}
                </label>
                <p class="help-block">{{ __('campaigns.helpers.hide_history') }}</p>
            </div>
        </div>
    </div>
</div>
