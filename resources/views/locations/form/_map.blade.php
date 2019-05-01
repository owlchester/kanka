@if (!isset($model) || auth()->user()->can('map', $model))
    <div class="row">
        <div class="col-md-6">
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

            <a href="{{ route('helpers.map') }}" data-toggle="tooltip" title="{{ trans('helpers.map.description') }}" target="_blank">{{ trans('locations.map.helpers.info') }}</a>
        </div>
    </div>

@endif