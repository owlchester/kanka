<?php /** @var \App\Models\Campaign $campaign */ ?>
@section('content-header')
<div class="campaign-header cover-background mb-3 p-2 relative z-[10] @if(!empty($campaign->header_image))campaign-imaged-header px-10 py-14" style="background-image: url({{ Img::crop(1200, 400)->url($campaign->header_image) }}) @else no-header @endif">

    <div class="campaign-header-content p-2 max-w-7xl mx-auto">
        <div class="campaign-content ">
            <div class="campaign-head flex gap-2">
                <div class="grow">
                    <a href="{{ route('overview', $campaign) }}" title="{!! $campaign->name !!}" class="campaign-title text-2xl">
                        {!! $campaign->name !!}
                    </a>
                </div>
                <div class="flex gap-2 action-bar">
                    @include('dashboard.widgets._actions')
                </div>
            </div>
            @if ($campaign->hasPreview())
                <div class="preview">
                    {!! $campaign->preview() !!}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
