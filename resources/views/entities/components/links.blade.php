<?php /** @var \App\Rules\EntityLink $link */?>

<div class="sidebar-section-box entity-links">
    <div class="sidebar-section-title cursor" data-toggle="collapse" data-target="#sidebar-link-elements">
        <i class="fa-solid fa-chevron-right" style="display: none"></i>
        <i class="fa-solid fa-chevron-down"></i>

        {{ __('entities/pins.links') }}
    </div>
    <div class="sidebar-elements collapse in" id="sidebar-link-elements">
        <ul class="list-unstyled">
            @foreach ($model->entity->links()->ordered()->get() as $link)
                <li data-target="{{ $link->id }}" data-visibility="{{ $link->visibility }}">
                    <a href="{{ route('entities.entity_links.go', ['entity' => $model->entity->id, 'entity_link' => $link->id]) }}" title="{!! $link->name !!}" target="_blank" rel="noreferrer nofollow" class="entity-link">
                        <i class="{{ $link->iconName() }} margin-r-5"></i> {!! $link->name !!}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</div>
