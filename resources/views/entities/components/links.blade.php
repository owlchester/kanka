<?php /** @var \App\Rules\EntityLink $link */?>

<div class="box box-solid entity-links">
    <div class="box-header with-border">
        <h3 class="box-title">{{ __('entities/pins.links') }}</h3>
    </div>
    <div class="box-body">
        <ul class="list-inline export-hidden">
            @foreach ($model->entity->links()->ordered()->get() as $link)
                <li data-target="{{ $link->id }}">
                    <a href="{{ route('entities.entity_links.go', ['entity' => $model->entity->id, 'entity_link' => $link->id]) }}" title="{!! $link->name !!}" target="_blank" rel="noreferrer nofollow" class="entity-link">
                        <i class="{{ $link->iconName() }} margin-r-5"></i> {!! $link->name !!}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</div>
