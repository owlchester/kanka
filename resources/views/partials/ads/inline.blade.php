@ads('inline')
<div class="ads-space mb-5 hidden-xs hidden-sm">
    <div class="vm-placement" data-id="{{ config('tracking.venatus.entity') }}"></div>
</div>
<div class="ads-space mb-5 visible-xs visible-sm">
    <div class="vm-placement" data-id="{{ config('tracking.venatus.inline') }}"></div>
</div>
@endads
