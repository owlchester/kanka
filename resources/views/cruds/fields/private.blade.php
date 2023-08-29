@if (auth()->user()->isAdmin())
    <hr />
    <x-forms.field field="private" :label="__('crud.fields.is_private')">
        {!! Form::hidden('is_private', 0) !!}
        <label class="text-neutral-content cursor-pointer flex gap-2">
            {!! Form::checkbox('is_private', 1, empty($model) ? (!empty($source) ? $source->is_private : $campaign->entity_visibility) : $model->is_private) !!}
            @include('cruds.fields.helpers.private')
        </label>
    </x-forms.field>
@endif
