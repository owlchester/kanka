<div class="form-group">
    <label>{{ trans('crud.fields.image') }}</label>
    {!! Form::hidden('remove-image') !!}
    <div class="row">
        <div class="col-md-5">
            {!! Form::file('image', array('class' => 'image form-control')) !!}
        </div>
        <div class="col-md-7">
            {!! Form::text('image_url', null, ['placeholder' => trans('crud.placeholders.image_url'), 'class' => 'form-control']) !!}
        </div>
    </div>

    @if (!empty($model->image))
        <div class="preview">
            <div class="image">
                <img src="{{ Storage::url($model->image) }}"/>
                <a href="#" class="img-delete" data-target="remove-image" title="{{ trans('crud.remove') }}">
                    <i class="fa fa-trash"></i> {{ trans('crud.remove') }}
                </a>
            </div>
            <br class="clear">
        </div>
    @endif
</div>