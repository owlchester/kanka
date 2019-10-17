<?php /** @var \App\Models\Entity $entity */?>
@foreach ($entities as $entity)
    @if (empty($entity->child))
        @continue
    @endif
    <div class="row">
        <div class="col-xs-7 col-sm-8 col-md-8">
            <a class="entity-image" style="background-image: url('{{ $entity->avatar(true) }}');"
               title="{{ $entity->name }}"
               href="{{ $entity->url() }}"></a>

            {!! $entity->tooltipedLink() !!}
        </div>
        <div class="col-xs-5 col-sm-4 col-md-4">
            {{ $entity->updater ? e($entity->updater->name) : trans('crud.history.unknown') }}<br />
            <span class="elapsed" title="{{ $entity->child->updated_at }}">
                {{ $entity->child->updated_at->diffForHumans() }}
            </span>
        </div>
    </div>

@endforeach
<div class="text-center">
    <a href="#" class="text-center widget-recent-more"
       data-url="{{ route('dashboard.recent', ['id' => $widget->id, 'offset' => $offset + 10]) }}">
        {{ __('crud.actions.next') }}
    </a>
</div>