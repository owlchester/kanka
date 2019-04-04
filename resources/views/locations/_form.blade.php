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
                @include('cruds.fields.type', ['base' => \App\Models\Location::class, 'trans' => 'locations'])
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
                @include('cruds.fields.tags')
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
            </div>
        </div>
    </div>
    <div class="col-md-6">
        @include('cruds.fields.entry')

        @can('map', $model)
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4>{{ trans('locations.panels.map') }}</h4>
            </div>
            <div class="panel-body">
                <p class="">{{ __('locations.helpers.map') }}</p>
                <label>{{ trans('locations.fields.map') }}</label>
                {!! Form::hidden('remove-map') !!}
                <div class="row">
                    <div class="col-md-10">
                        <div class="form-group">
                            {!! Form::file('map', array('class' => 'image form-control')) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::text('map_url', null, ['placeholder' => trans('crud.placeholders.image_url'), 'class' => 'form-control']) !!}
                        </div>

                        <p class="help-block">
                            {{ trans('crud.hints.map_limitations', ['size' => auth()->user()->maxUploadSize(true, 'map')]) }}
                            @if (!auth()->user()->hasRole('patreon'))
                                <a href="{{ config('patreon.url') }}" target="_blank">{{ __('crud.hints.image_patreon') }}</a>
                            @endif
                        </p>
                    </div>
                    <div class="col-md-2">
                        @if (!empty($model->map))
                            <div class="preview-v2">
                                <div class="image" style="background-image: url('{{ Storage::url($model->map) }}')">
                                    <a href="#" class="img-delete" data-target="remove-map" title="{{ trans('crud.remove') }}">
                                        <i class="fa fa-trash"></i> {{ trans('crud.remove') }}
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                @if (Auth::user()->isAdmin())
                    <hr>
                    <div class="form-group">
                        {!! Form::hidden('is_map_private', 0) !!}
                        <label>{!! Form::checkbox('is_map_private', 1, empty($model) ? 0 : $model->is_map_private) !!}
                            {{ trans('locations.fields.is_map_private') }}
                        </label>
                        <p class="help-block">{{ trans('locations.hints.is_map_private') }}</p>
                    </div>
                @endif
            </div>
            <div class="panel-footer">
                <a href="{{ route('helpers.map') }}" data-toggle="tooltip" title="{{ trans('helpers.map.description') }}" target="_blank">{{ trans('locations.map.helpers.info') }}</a>
            </div>
        </div>
        @endif

        @include('cruds.fields.copy')
    </div>
</div>

@include('cruds.fields.save')