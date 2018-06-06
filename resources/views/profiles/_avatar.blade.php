{{ csrf_field() }}

<div class="form-group">
    <label>{{ trans('crud.fields.image') }}</label>
    {!! Form::hidden('remove-avatar') !!}
    <div class="row">
        <div class="col-md-5">
            {!! Form::file('avatar', array('class' => 'image form-control')) !!}
        </div>
        <div class="col-md-7">
            {!! Form::text('avatar_url', null, ['placeholder' => trans('crud.placeholders.image_url'), 'class' => 'form-control']) !!}
        </div>
    </div>

    @if (!empty($model->avatar) && $model->avatar != 'users/default.png')
        <div class="preview">
            <div class="image">
                <img src="{{ Storage::url($model->avatar) }}"/>
                <a href="#" class="img-delete" data-target="remove-avatar" title="{{ trans('crud.remove') }}">
                    <i class="fa fa-trash"></i> {{ trans('crud.remove') }}
                </a>
            </div>
            <br class="clear">
        </div>
    @endif
</div>

<div class="form-group">
    <button class="btn btn-success">{{ trans('crud.save') }}</button>
</div>
