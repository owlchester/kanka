    <x-grid>
    <div class="field-name col-span-2 required">
        <label>{{ __('crud.fields.name') }}</label>
        {!! Form::text('name', null, ['placeholder' => __('maps/groups.placeholders.name'), 'class' => 'form-control', 'maxlength' => 191, 'required' => true]) !!}
    </div>

    <div class="field-shown col-span-2">
        {!! Form::hidden('is_shown', 0) !!}
        <label>{!! Form::checkbox('is_shown', 1, isset($model) ? $model->is_shown : 1) !!}
            {{ __('maps/groups.fields.is_shown') }}
        </label>
        <p class="help-block m-0">{{ __('maps/groups.hints.is_shown') }}</p>
    </div>

    @php
        $options = $map->groupPositionOptions(!empty($model->position) ? $model->position : null);
        $last = array_key_last($options);
    @endphp
    <div class="field-position">
        <label>{{ __('maps/groups.fields.position') }}</label>
        {!! Form::select('position', $options, (!empty($model->position) ? $model->position : $last), ['class' => 'form-control']) !!}
    </div>

    @include('cruds.fields.visibility_id')
</x-grid>
