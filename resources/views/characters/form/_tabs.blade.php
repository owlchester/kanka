<x-tab.tab target="traits" :title="__('characters.fields.traits')"></x-tab.tab>

@if ($campaignService->enabled('organisations'))
    @php $tabTitle = \App\Facades\Module::plural(config('entities.ids.organisation'), __('entities.organisations')); @endphp
    <x-tab.tab target="organisations" icon="ra ra-hood" :title="$tabTitle"></x-tab.tab>
</li>
@endif
