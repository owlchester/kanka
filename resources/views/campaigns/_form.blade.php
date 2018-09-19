@inject('languages', 'App\Services\LanguageService')
{{ csrf_field() }}
<div class="row">
    <div class="col-md-{{ (isset($start) ? 12 : 6) }}">
        <div class="form-group required">
            <label>{{ trans('campaigns.fields.name') }}</label>
            {!! Form::text('name', null, ['placeholder' => trans('campaigns.placeholders.name'), 'class' => 'form-control']) !!}
            <p class="help-block">{{ trans('campaigns.helpers.name') }}</p>
        </div>
    </div>
    @if (!isset($start))
        <div class="col-md-6">
                @include('cruds.fields.image')
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>{{ trans('campaigns.fields.locale') }}</label>
                {!! Form::select('locale', $languages->getSupportedLanguagesList(), null, ['class' => 'form-control']) !!}
                <p class="help-block">{{ trans('campaigns.helpers.locale') }}</p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::hidden('entity_visibility', 0) !!}
                <label>{{ trans('campaigns.fields.entity_visibility') }}</label>
                <div class="checkbox">
                    <label>{!! Form::checkbox('entity_visibility') !!}
                        {{ trans('campaigns.entity_visibilities.private') }}
                    </label>
                </div>
                <p class="help-block">{{ trans('campaigns.helpers.entity_visibility') }}</p>
            </div>
        </div>
    @endif
</div>
@if (!isset($start))
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label>{{ trans('campaigns.fields.description') }}</label>
            {!! Form::textarea('entry', null, ['class' => 'form-control html-editor', 'id' => 'entry']) !!}
        </div>
    </div>
</div>

<div class="form-group">
    {!! Form::hidden('is_public', 0) !!}
    <label>{!! Form::checkbox('is_public') !!}
        {{ trans('campaigns.visibilities.public') }}
    </label>
    <p class="help-block">{{ trans('campaigns.helpers.visibility') }}</p>
</div>
@endif

<div class="form-group">
    <button class="btn btn-success">{{ trans('crud.save') }}</button>
    @if (!isset($start))
        {!! trans('crud.or_cancel', ['url' => (!empty($cancel) ? $cancel : url()->previous())]) !!}
    @endif
</div>
