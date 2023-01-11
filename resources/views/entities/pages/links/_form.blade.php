{{ csrf_field() }}
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
        'metadata[url]',
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
        'metadata[icon]',
        null,
        [
            'placeholder' => 'fa-brands fa-d-and-d-beyond',
            'class' => 'form-control',
            'maxlength' => 45
        ]
    ) !!}
    <p class="help-block">
        {!! __('entities/links.helpers.icon', [
            'fontawesome' => link_to(config('fontawesome.search'), 'FontAwesome', ['target' => '_blank'])
        ]) !!}
    </p>
</div>

<!--<div class="form-group">
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
</div>-->

@include('cruds.fields.visibility_id', ['model' => $entity ?? null])
<input type="hidden" name="type_id" value="{{ \App\Models\EntityAsset::TYPE_LINK }}" />
