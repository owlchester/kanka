{{ csrf_field() }}
<div class="row">
    <div class="col-md-12">
        <div class="form-group required">
            <label>{{ __('entities/links.fields.name') }}</label>
            {!! Form::text(
                'name',
                null,
                [
                    'placeholder' => __('entities/links.placeholders.name'),
                    'class' => 'form-control',
                    'maxlength' => 45
                ]
            ) !!}
        </div>
        <div class="form-group required">
            <label>{{ __('entities/links.fields.url') }}</label>
            {!! Form::text(
                'url',
                null,
                [
                    'placeholder' => __('entities/links.placeholders.url'),
                    'class' => 'form-control',
                    'maxlength' => 255
                ]
            ) !!}
        </div>

        <div class="form-group">
            <label>{{ __('entities/links.fields.icon') }}</label>
            {!! Form::text(
                'icon',
                null,
                [
                    'placeholder' => __('entities/links.placeholders.icon'),
                    'class' => 'form-control',
                    'maxlength' => 45
                ]
            ) !!}
            <p class="help-block">
                {!! __('entities/links.helpers.icon', [
                    'fontawesome' => link_to('https://fontawesome.com/search?m=free&s=solid', 'FontAwesome', ['target' => '_blank'])
                ]) !!}
            </p>
        </div>

        <div class="form-group">
            <label>{{ __('entities/links.fields.position') }}</label>
            {!! Form::number(
                'position',
                null,
                [
                    'class' => 'form-control',
                    'min' => 1,
                    'max' => 128
                ]
            ) !!}
        </div>

        <div class="row">
            <div class="col-md-12">
                @include('cruds.fields.visibility')
            </div>
        </div>
    </div>
</div>
