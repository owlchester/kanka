<x-dialog.header>
    {{ __('campaigns/modules.rename.title', ['module' => __('entities.' . $entityType->code)]) }}
</x-dialog.header>
<article>
    {!! Form::open(['method' => 'PATCH', 'route' => ['modules.update', [$campaign, $entityType->id]], 'class' => 'w-full max-w-lg']) !!}

    <p class="text-justify">{{ __('campaigns/modules.rename.helper') }}</p>

    <x-grid type="1/1">
        <div class="field-singular text-left">
            <label>{{ __('campaigns/modules.fields.singular') }}</label>
            {!! Form::text('singular', $singular, ['class' => 'form-control', 'maxlength' => 45, 'placeholder' => __('entities.' . $entityType->code)]) !!}
        </div>

        <div class="field-plural text-left">
            <label>{{ __('campaigns/modules.fields.plural') }}</label>
            {!! Form::text('plural', $plural, ['class' => 'form-control', 'maxlength' => 45, 'placeholder' => __('entities.' . \Illuminate\Support\Str::plural($entityType->code))]) !!}
        </div>

        <div class="field-icon text-left">
            <label>{{ __('campaigns/modules.fields.icon') }}</label>
            {!! Form::text('icon', $icon, ['class' => 'form-control', 'maxlength' => 40]) !!}
        </div>
    </x-grid>

    <x-dialog.footer>
        <x-buttons.confirm type="primary">
            <x-icon class="save"></x-icon>
            {{ __('crud.save') }}
        </x-buttons.confirm>
    </x-dialog.footer>

    {!! Form::close() !!}
</article>

