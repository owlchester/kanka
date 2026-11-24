@foreach (\App\View\EntryFormTabs::for($entityType, $campaign) as $target => $label)
    <x-tab.tab :target="$target" :title="$label" :icon="$target === 'moons' ? 'fa-regular fa-moon' : null"></x-tab.tab>
@endforeach
