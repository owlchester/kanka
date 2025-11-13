<?php /** @var \App\Models\Campaign $campaign */ ?>
@section('content-header')
<div
    class="campaign-header cover-background p-4 relative z-[841] @if(!empty($campaign->header_image))campaign-imaged-header px-4 md:px-10 py-6 md:py-14 pt-12 md:pt-24 @else no-header @endif "
    @if(!empty($campaign->header_image)) style="background-image: url('{{ Img::crop(1200, 400)->url($campaign->header_image) }}')" @endif>

    <div class="campaign-header-content bg-base-100 bg-opacity-60 max-w-7xl mx-auto p-4 @if(!empty($campaign->header_image)) backdrop-blur-lg rounded @endif">
        <div class="campaign-content flex flex-col gap-2 ">
            <div class="campaign-head flex gap-2 justify-between items-center">
                <div class="truncate">
                    <a href="{{ route('overview', $campaign) }}" title="{!! $campaign->name !!}" class="campaign-title text-2xl drop-shadow-sm">
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
