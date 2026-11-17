@foreach (\App\View\EntryFormTabs::for($entityType, $campaign) as $target => $label)
    <x-tab.tab :target="$target" :title="$label"></x-tab.tab>
@endforeach
