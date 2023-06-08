<x-grid>
    @include('cruds.fields.name', ['trans' => 'tags'])
    @include('cruds.fields.type', ['base' => \App\Models\Tag::class, 'trans' => 'tags'])

    @include('cruds.fields.tag', ['isParent' => true])
    @include('cruds.fields.colour')

    @include('cruds.fields.entry2')

    <div class="field-auto-apply">
        {!! Form::hidden('is_auto_applied', 0) !!}
        <label>{!! Form::checkbox('is_auto_applied', 1, $model->is_auto_applied ?? '' )!!}
            {{ __('tags.fields.is_auto_applied') }}
        </label>
        <p class="help-block">{{ __('tags.hints.is_auto_applied') }}</p>
    </div>
    <div class="field-hidden">
        {!! Form::hidden('is_hidden', 0) !!}
        <label>{!! Form::checkbox('is_hidden', 1, $model->is_hidden ?? '' )!!}
            {{ __('tags.fields.is_hidden') }}
        </label>
        <p class="help-block">{{ __('tags.hints.is_hidden') }}</p>
    </div>
    @include('cruds.fields.image')

</x-grid>
