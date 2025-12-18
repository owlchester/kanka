@if (!empty($campaign))
    <x-sidebar.campaign :campaign="$campaign" :entity="$entity ?? null"/>
@endif
