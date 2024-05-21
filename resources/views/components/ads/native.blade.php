<?php /** @var \App\Models\Ad $ad */?>
<div @if ($ad->isSidebar())
    class="ads-space nativead-manager text-center" data-video="true"
@else
    class="ads-space overflow-hidden nativead-manager text-center" data-video="true" style="max-height: 228px;"
@endif
>
    {!! $ad->html !!}
</div>
