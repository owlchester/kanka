{{ csrf_field() }}
<div class="row">
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4>{{ trans('crud.panels.general_information') }}</h4>
            </div>
            <div class="panel-body">
                <div class="form-group required">
                    <label>{{ trans('notes.fields.name') }}</label>
                    {!! Form::text('name', null, ['placeholder' => trans('notes.placeholders.name'), 'class' => 'form-control', 'maxlength' => 191]) !!}
                </div>
                <div class="form-group">
                    <label>{{ trans('notes.fields.type') }}</label>
                    {!! Form::text('type', null, ['placeholder' => trans('notes.placeholders.type'), 'class' => 'form-control', 'maxlength' => 191]) !!}
                </div>
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
                    <label>{{ trans('notes.fields.image') }}</label>

                    {!! Form::hidden('remove-image') !!}
                    {!! Form::file('image', array('class' => 'image')) !!}
                    @if (!empty($model->image))
                        <div class="preview">
                            <div class="image">
                                <img src="/storage/{{ $model->image }}"/>
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
                <h4>{{ trans('crud.panels.description') }}</h4>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label>{{ trans('notes.fields.description') }}</label>
                    {!! Form::textarea('description', null, ['class' => 'form-control html-editor', 'id' => 'description']) !!}
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
