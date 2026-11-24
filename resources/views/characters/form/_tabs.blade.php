@foreach (\App\View\EntryFormTabs::for($entityType, $campaign) as $target => $label)
    @php($icon = $target === 'organisations' ? \App\Models\EntityType::find(config('entities.ids.organisation'))?->icon() : null)
    <x-tab.tab :target="$target" :title="$label" :icon="$icon"></x-tab.tab>
@endforeach
