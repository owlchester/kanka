@php($copyrightNotice = $campaign->copyrightNotice())
@if ($copyrightNotice)
    <div role="alert" class="bg-warning text-warning-content px-4 py-3 text-center text-sm">
        {{ $copyrightNotice }}
    </div>
@endif
