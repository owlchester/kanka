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
                    <label>{{ trans('locations.fields.name') }}</label>
                    {!! Form::text('name', $formService->prefill('name', $source), ['placeholder' => trans('locations.placeholders.name'), 'class' => 'form-control', 'maxlength' => 191]) !!}
                </div>
                <div class="form-group">
                    <label>{{ trans('locations.fields.type') }}</label>
                    {!! Form::text('type', $formService->prefill('type', $source), ['placeholder' => trans('locations.placeholders.type'), 'class' => 'form-control', 'maxlength' => 45]) !!}
                </div>
                <div class="form-group">
                    {!! Form::select2(
                        'parent_location_id',
                        (isset($model) && $model->parentLocation ? $model->parentLocation : $formService->prefillSelect('parentLocation', $source)),
                        App\Models\Location::class,
                        true,
                        'crud.fields.location',
                        'locations.find',
                        'locations.placeholders.location'
                    ) !!}
                </div>
                @include('cruds.fields.section')
                @include('cruds.fields.attribute_template')

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

                <hr />
                <div class="form-group">
                    <label>{{ trans('locations.fields.map') }}</label>
                    {!! Form::hidden('remove-map') !!}
                    <div class="row">
                        <div class="col-md-5">
                            {!! Form::file('map', array('class' => 'image form-control')) !!}
                        </div>
                    </div>

                    @if (!empty($model->map))
                        <div class="preview">
                            <div class="image">
                                <img src="{{ Storage::url($model->map) }}"/>
                                <a href="#" class="img-delete" data-target="remove-map" title="{{ trans('crud.remove') }}">
                                    <i class="fa fa-trash"></i> {{ trans('crud.remove') }}
                                </a>
                            </div>
                            <br class="clear">
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">

        <div class="panel panel-default">
            <div class="panel-heading">
                <h4>{{ trans('crud.panels.entry') }}</h4>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    {!! Form::textarea('entry', $formService->prefill('entry', $source), ['class' => 'form-control html-editor', 'id' => 'entry']) !!}
                </div>
            </div>
            <div class="panel-footer">
                <a href="{{ route('helpers.link') }}" target="_blank">{{ trans('crud.linking_help') }}</a>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4>{{ trans('crud.panels.entry') }}</h4>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    {!! Form::textarea('entry', $formService->prefill('entry', $source), ['class' => 'form-control html-editor', 'id' => 'entry']) !!}
                </div>
            </div>
            <div class="panel-footer">
                <a href="{{ route('helpers.link') }}" target="_blank">{{ trans('crud.linking_help') }}</a>
            </div>
        </div>
    </div>
</div>

@include('cruds.fields.save')