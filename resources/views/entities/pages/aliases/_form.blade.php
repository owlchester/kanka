{{ csrf_field() }}
<div class="row">
    <div class="col-md-12">
        <div class="form-group required">
            <label>{{ __('entities/links.fields.name') }}</label>
            {!! Form::text(
                'name',
                null,
                [
                    'placeholder' => __('entities/aliases.placeholders.name'),
                    'class' => 'form-control',
                    'maxlength' => 45
                ]
            ) !!}
        </div>

        <div class="row">
            <div class="col-md-12">
                @include('cruds.fields.visibility_id')
            </div>
        </div>
    </div>
</div>
