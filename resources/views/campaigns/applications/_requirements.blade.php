@php
/** @var \App\Models\Campaign $campaign */
@endphp
<div class="grid grid-cols-1 md:grid-cols-2 gap-5">
    <x-box class="flex items-center gap-5 rounded-xl">
        <div class="rounded {{ $campaign->isOpen() ? 'bg-green-200' : 'bg-red-200' }} w-12 h-12 flex items-center justify-center">
            <x-icon class="fa-solid {{ $campaign->isOpen() ? 'fa-check text-green-600' : 'fa-times text-red-600' }}" />
        </div>
        <div class="flex flex-col gap-0 grow">
            <span>{!! __('campaigns/applications.open.title') !!}</span>
            @if ($campaign->isOpen())
                <span class="text-green-600">{!! __('campaigns/applications.open.open') !!}</span>
            @else
                <span class="text-red-600">{!! __('campaigns/applications.open.closed') !!}</span>
            @endif
        </div>
        <div class="rounded-full border border-base-300 h-12 w-12 flex items-center justify-center cursor-pointer" data-url="{{ route('campaign-applications', $campaign) }}" data-target="application-dialog" data-toggle="dialog">
            <x-icon class="fa-solid fa-angle-right" />
        </div>
    </x-box>
    <x-box class="flex items-center gap-5 rounded-xl">
        <div class="rounded {{ $campaign->isPublic() ? 'bg-green-200' : 'bg-red-200' }} w-12 h-12 flex items-center justify-center">
            <x-icon class="fa-solid {{ $campaign->isPublic() ? 'fa-check text-green-600' : 'fa-times text-red-600' }}" />
        </div>
        <div class="flex flex-col gap-0 grow">
            <span>{!! __('campaigns/applications.public.title') !!}</span>
            @if ($campaign->isPublic())
                <span class="text-green-600">{!! __('campaigns/applications.public.public') !!}</span>
            @else
                <span class="text-red-600">{!! __('campaigns/applications.public.private') !!}</span>
            @endif
        </div>
        <div class="rounded-full border border-base-300 h-12 w-12 flex items-center justify-center cursor-pointer" data-url="{{ route('campaign-visibility', $campaign) }}" data-toggle="dialog">
            <x-icon class="fa-solid fa-angle-right" />
        </div>
    </x-box>
</div>
