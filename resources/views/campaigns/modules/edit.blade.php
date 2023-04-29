<x-dialog.header>
    {{ __('campaigns/modules.rename.title', ['module' => __('entities.' . $entityType->code)]) }}
</x-dialog.header>
<article>
    {!! Form::open(['method' => 'PATCH', 'route' => ['modules.update', $entityType->id], 'class' => 'w-full max-w-lg']) !!}

    <p class="text-justify">{{ __('campaigns/modules.rename.helper') }}</p>
    <div class="form-group text-left">
        <label>{{ __('campaigns/modules.fields.singular') }}</label>
        {!! Form::text('singular', $singular, ['class' => 'form-control', 'maxlength' => 45, 'placeholder' => __('entities.' . $entityType->code)]) !!}
    </div>

    <div class="form-group text-left">
        <label>{{ __('campaigns/modules.fields.plural') }}</label>
        {!! Form::text('plural', $plural, ['class' => 'form-control', 'maxlength' => 45, 'placeholder' => __('entities.' . \Illuminate\Support\Str::plural($entityType->code))]) !!}
    </div>

    <div class="form-group text-left">
        <label>{{ __('campaigns/modules.fields.icon') }}</label>
        {!! Form::text('icon', $icon, ['class' => 'form-control', 'maxlength' => 40]) !!}
    </div>

    <div class="grid grid-cols-2 gap-2">
        <x-buttons.confirm type="ghost" full="true" dismiss="dialog">
            {{ __('crud.cancel') }}
        </x-buttons.confirm>

        <x-buttons.confirm type="primary" full="true">
            <i class="fa-solid fa-save" aria-hidden="true"></i>
            {{ __('crud.save') }}
        </x-buttons.confirm>
    </div>

    {!! Form::close() !!}
</article>

