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
                    {!! Form::text('name', null, ['placeholder' => trans('families.placeholders.name'), 'class' => 'form-control', 'maxlength' => 191]) !!}
                </div>
                @if ($campaign->enabled('locations'))
                <div class="form-group">
                    <label>{{ trans('families.fields.location') }}</label>
                    <div class="input-group input-group-sm">
                        {!! Form::select('location_id', (isset($family) && !empty($family->location) ? [$family->location_id => $family->location->name] : []),
                         null, ['id' => 'location_id', 'class' => 'form-control select2', 'style' => 'width: 100%', 'data-url' => route('locations.find'),
                         'data-placeholder' => trans('families.placeholders.location')]) !!}
                        <div class="input-group-btn">
                            <a class="btn btn-tab-form new-entity-selector" style="" data-toggle="modal" data-target="#new-entity-modal" data-parent="location_id" data-entity="locations">
                                <span class="glyphicon glyphicon-plus"></span>
                            </a>
                        </div>
                    </div>
                </div>

                <hr />
                @endif

                <div class="form-group">
                    {!! Form::hidden('is_private', 0) !!}
                    <label>{!! Form::checkbox('is_private') !!}
                        {{ trans('characters.fields.is_private') }}
                    </label>
                    <p class="help-block">{{ trans('characters.hints.is_private') }}</p>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h4>{{ trans('crud.panels.appearance') }}</h4>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label>{{ trans('families.fields.image') }}</label>

                    {!! Form::hidden('remove-image') !!}
                    {!! Form::file('image', array('class' => 'image')) !!}
                    @if (!empty($family->image))
                        <div class="preview">
                            <div class="image">
                                <img src="/storage/{{ $family->image }}"/>
                                <a href="#" class="img-delete" data-target="remove-image" title="{{ trans('crud.remove') }}">
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
                <h4>{{ trans('crud.panels.history') }}</h4>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label>{{ trans('families.fields.history') }}</label>
                    {!! Form::textarea('history', null, ['class' => 'form-control html-editor', 'id' => 'history']) !!}
                </div>
                <div class="form-group">
                    <a href="{{ route('helpers.link') }}" target="_blank">{{ trans('crud.linking_help') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="form-group">
    <button class="btn btn-success">{{ trans('crud.save') }}</button>
    <button class="btn btn-default" name="submit-new">{{ trans('crud.save_and_new') }}</button>
    {!! trans('crud.or_cancel', ['url' => (!empty($cancel) ? $cancel : url()->previous())]) !!}
</div>
