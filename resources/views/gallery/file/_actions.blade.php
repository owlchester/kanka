@if (!$image->isFont())
    <a href="#" class="btn2 btn-ghost" data-toggle="dialog" data-target="primary-dialog" data-url="{{  route('campaign.gallery.focus', [$campaign, $image]) }}">
        <x-icon class="fa-solid fa-bullseye" />
        <span class="hidden md:inline">
            {{ __('campaigns/gallery.actions.focus_point') }}
        </span>
    </a>
@endif
@if (!$image->isFolder() )
<a class="btn2 btn-ghost" href="{{ Storage::url($image->path) }}" target="_blank">
    <x-icon class="fa-regular fa-link"></x-icon>
    <span class="hidden md:inline">
        {{ __('crud.actions.open') }}
    </span>
</a>
@endif
<div class="submit-group">
    <button class="btn2 btn-primary">
        <x-icon class="save" />
        <span class="hidden sm:inline">{{ $submit ?? __('crud.save') }}</span>
    </button>
</div>
