@nativeAd(\App\Models\Ad::SECTION_SIDEBAR)
<div class="ads-space nativead-manager text-center" data-video="true">
    {!! \App\Facades\AdCache::show() !!}
</div>
@else
    @ads('sidebar')
    <div style="width: 280px" class="overflow-hidden">
    <div class="vm-placement" data-id="{{ config('tracking.venatus.sidebar') }}"></div>
    </div>
    @endads
@endnativeAd
