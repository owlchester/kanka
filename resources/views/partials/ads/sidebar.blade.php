<x-ad section="sidebar" :campaign="isset($campaign) ? $campaign : null">
    <div style="width: 280px" class="overflow-hidden">
        <div class="vm-placement" data-id="{{ config('tracking.venatus.sidebar') }}"></div>
    </div>
</x-ad>
