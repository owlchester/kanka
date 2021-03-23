@if(!$campaign->campaign()->boosted())
    <?php return; ?>
@endif

<?php /** @var \App\Rules\EntityLink $link */?>
<ul class="entity-links list-inline @if(!isset($header)) text-center @endif">
    @foreach ($model->entity->links()->ordered()->get() as $link)
        <li data-target="{{ $link->id }}">
            <a href="{{ route('entities.entity_links.go', ['entity' => $model->entity->id, 'entity_link' => $link->id]) }}" title="{{ $link->name }}" target="_blank" rel="noreferrer nofollow">
                <i class="{{ $link->iconName() }}"></i>
            </a>
        </li>
    @endforeach
</ul>
