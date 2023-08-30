    <x-grid>
    <x-forms.field
        :required="true"
        :label="__('crud.fields.name')"
        field="name"
        css="col-span-2">
        {!! Form::text('name', null, ['placeholder' => __('maps/groups.placeholders.name'), 'class' => '', 'maxlength' => 191, 'required' => true]) !!}
    </x-forms.field>

    <x-forms.field
        field="shown col-span-2"
        :label="__('maps/groups.fields.is_shown')">
        {!! Form::hidden('is_shown', 0) !!}
        <label class="text-neutral-content">
            {!! Form::checkbox('is_shown', 1, isset($model) ? $model->is_shown : 1) !!}
            {{  __('maps/groups.hints.is_shown') }}
        </label>
    </x-forms.field>

    @php
        $options = $map->groupPositionOptions(!empty($model->position) ? $model->position : null);
        $last = array_key_last($options);
    @endphp
    <x-forms.field
        field="position"
        :label="__('maps/groups.fields.position')">
        {!! Form::select('position', $options, (!empty($model->position) ? $model->position : $last), ['class' => '']) !!}
    </x-forms.field>

    @include('cruds.fields.visibility_id')
</x-grid>
