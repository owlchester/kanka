<h3 id="custom">{{ __('campaigns/modules.sections.custom')}}</h3>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-2 md:gap-4">
    <div class="cell col-span-1 flex">
        @include('campaigns.entity-types.box.new')
    </div>
    @foreach ($customEntityTypes as $entityType)
        <div class="cell col-span-1 flex">
            @include('campaigns.entity-types.box.custom')
        </div>
    @endforeach
</div>
