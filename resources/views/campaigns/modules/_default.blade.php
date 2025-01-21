<h3 id="default">{{ __('campaigns/modules.sections.default')}}</h3>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-2 md:gap-4">
    @foreach ($entityTypes as $entityType)
        <div class="cell col-span-1 flex">
            @include('campaigns.entity-types.box.default')
        </div>
    @endforeach
</div>
