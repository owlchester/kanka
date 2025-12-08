<h3 id="default" class="text-xl">{{ __('campaigns/modules.sections.default')}}</h3>

<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-2 md:gap-4">
    @foreach ($entityTypes as $entityType)
        <div class="cell col-span-1 flex">
            <x-campaigns.module-box :campaign="$campaign" :entityType="$entityType"></x-campaigns.module-box>
        </div>
    @endforeach
</div>
