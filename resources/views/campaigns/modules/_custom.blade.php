<div class="flex gap-2 items-center justify-between">
    <h3 id="custom" class="text-xl">{{ __('campaigns/modules.sections.custom')}}</h3>

    <a
        class="btn2 btn-primary btn-sm"
        data-toggle="dialog-ajax"
        data-url="{{ route('entity_types.create', [$campaign]) }}"
        data-target="primary-dialog"
        title="{{ __('campaigns/modules.actions.new') }}">
        <x-icon class="plus" />
        {{ __('crud.create') }}
    </a>
</div>

@if ($customEntityTypes->isEmpty())
    <x-helper>
        <p>{{ __('campaigns/modules.errors.empty-custom') }}</p>
    </x-helper>
@else

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-2 md:gap-4">
        @foreach ($customEntityTypes as $entityType)
            <div class="cell col-span-1 flex">
                <x-campaigns.module-box :campaign="$campaign" :entityType="$entityType"></x-campaigns.module-box>
            </div>
        @endforeach
    </div>
@endif
