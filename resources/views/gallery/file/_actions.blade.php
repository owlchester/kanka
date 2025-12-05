
@can('edit', [$image, $campaign])
    @if ($image->hasThumbnail())
        <a href="#" class="btn2 btn-ghost" data-toggle="dialog" data-url="{{  route('campaign.gallery.focus', [$campaign, $image]) }}">
            <x-icon class="fa-regular fa-bullseye" />
            <span class="hidden md:inline">
                {{ __('campaigns/gallery.actions.focus_point') }}
            </span>
        </a>
    @endif
@endcan
@if (!$image->isFolder() )
<a class="btn2 btn-ghost" href="{{ $image->url() }}" target="_blank">
    <x-icon class="fa-regular fa-link" />
    <span class="hidden md:inline">
        {{ __('crud.actions.open') }}
    </span>
</a>
@endif
@can('edit', [$image, $campaign])
<div class="submit-group">
    <button class="btn2 btn-primary">
        <x-icon class="save" />
        <span class="hidden sm:inline">{{ $submit ?? __('crud.save') }}</span>
    </button>
</div>
@endcan
