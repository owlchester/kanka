<x-grid>
    @include('cruds.fields.name', ['trans' => 'characters'])
    @include('cruds.fields.type', ['base' => \App\Models\Character::class, 'trans' => 'characters'])
    @include('cruds.fields.title')
    @include('cruds.fields.families', ['quickCreator' => true])
    @include('cruds.fields.location')
    @include('cruds.fields.races', ['quickCreator' => true])
    @include('cruds.fields.entry2')

    <x-forms.field
        field="age"
        :label="__('characters.fields.age')"
        :helper="__('characters.helpers.age', ['more' => link_to('https://docs.kanka.io/en/latest/advanced/age.html', __('crud.actions.find_out_more'), ['target' => '_blank'])])">
        {!! Form::text('age', FormCopy::field('age')->string(), ['placeholder' => __('characters.placeholders.age'), 'maxlength' => 25]) !!}
    </x-forms.field>

    @include('cruds.fields.sex')

    @include('cruds.fields.pronouns')

    <x-forms.field
        field="dead"
        :label="__('characters.fields.is_dead')">
        <input type="hidden" name="is_dead" value="0" />
        <x-checkbox :text="__('characters.hints.is_dead')">
            {!! Form::checkbox('is_dead', 1, (!empty($model) ? $model->is_dead : (!empty($source) ? FormCopy::field('is_dead')->boolean() : 0))) !!}
        </x-checkbox>
    </x-forms.field>

    @include('cruds.fields.tags')

    @include('cruds.fields.image')
</x-grid>

@section('scripts')
    @parent
    @vite('resources/js/forms/character.js')
@endsection
