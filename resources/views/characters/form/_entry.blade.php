<x-grid>
    @include('cruds.fields.name', ['trans' => 'characters'])
    @include('cruds.fields.type', ['base' => \App\Models\Character::class, 'trans' => 'characters'])
    @include('cruds.fields.title')
    @include('cruds.fields.families', ['quickCreator' => true])
    @include('cruds.fields.location')
    @include('cruds.fields.races', ['quickCreator' => true])
    @include('cruds.fields.entry2')

    <div class="form-group age">
        <label>{{ __('characters.fields.age') }}</label>
        {!! Form::text('age', FormCopy::field('age')->string(), ['placeholder' => __('characters.placeholders.age'), 'class' => 'form-control', 'maxlength' => 25]) !!}
        <p class="help-block">{!! __('characters.helpers.age', ['more' => link_to('https://docs.kanka.io/en/latest/advanced/age.html', __('crud.actions.find_out_more'), ['target' => '_blank'])]) !!}</p>
    </div>

    <div class="form-group gender">
        <label>{{ __('characters.fields.sex') }}</label>
        {!! Form::text('sex', FormCopy::field('sex')->string(), [
            'placeholder' => __('characters.placeholders.sex'),
            'class' => 'form-control',
            'maxlength' => 45,
            'list' => 'character-gender-list',
            'autocomplete' => 'off'
        ]) !!}
    </div>
    <div class="hidden">
        <datalist id="character-gender-list">
            @foreach (\App\Facades\CharacterCache::genderSuggestion() as $gender)
                <option value="{{ $gender }}">{{ $gender }}</option>
            @endforeach
        </datalist>
    </div>

    @include('cruds.fields.pronouns')

    <div class="form-group dead">
        {!! Form::hidden('is_dead', 0) !!}
        <label>{!! Form::checkbox('is_dead', 1, (!empty($model) ? $model->is_dead : (!empty($source) ? FormCopy::field('is_dead')->boolean() : 0))) !!}
            {{ __('characters.fields.is_dead') }}
        </label>
        <p class="help-block">{{ __('characters.hints.is_dead') }}</p>
    </div>

    @include('cruds.fields.tags')

    @include('cruds.fields.image')
</x-grid>

@section('scripts')
    @parent
    @vite('resources/js/forms/character.js')
@endsection
