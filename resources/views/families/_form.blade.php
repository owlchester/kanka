@inject('formService', 'App\Services\FormService')

{{ csrf_field() }}
<div class="row">
    <div class="col-md-6">

        <div class="panel panel-default">
            <div class="panel-heading">
                <h4>{{ trans('crud.panels.general_information') }}</h4>
            </div>
            <div class="panel-body">
                <div class="form-group required">
                    <label>{{ trans('families.fields.name') }}</label>
                    {!! Form::text('name', $formService->prefill('name', $source), ['placeholder' => trans('families.placeholders.name'), 'class' => 'form-control', 'maxlength' => 191]) !!}
                </div>
                @if ($campaign->enabled('locations'))
                <div class="form-group">
                    {!! Form::select2(
                        'location_id',
                        (isset($model) && $model->location ? $model->location : $formService->prefillSelect('location', $source)),
                        App\Models\Location::class,
                        true
                    ) !!}
                </div>
                @endif

                @if (Auth::user()->isAdmin())
                    <hr>
                    @include('cruds.fields.private')
                @endif
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h4>{{ trans('crud.panels.appearance') }}</h4>
            </div>
            <div class="panel-body">
                @include('cruds.fields.image')
            </div>
        </div>
    </div>
    <div class="col-md-6">

        <div class="panel panel-default">
            <div class="panel-heading">
                <h4>{{ trans('crud.panels.history') }}</h4>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    {!! Form::textarea('history', $formService->prefill('history', $source), ['class' => 'form-control html-editor', 'id' => 'history']) !!}
                </div>
            </div>
            <div class="panel-footer">
                <a href="{{ route('helpers.link') }}" target="_blank">{{ trans('crud.linking_help') }}</a>
            </div>
        </div>
    </div>
</div>


<div class="form-group">
    <button class="btn btn-success">{{ trans('crud.save') }}</button>
    <button class="btn btn-default" name="submit-new">{{ trans('crud.save_and_new') }}</button>
    {!! trans('crud.or_cancel', ['url' => (!empty($cancel) ? $cancel : url()->previous())]) !!}
</div>
