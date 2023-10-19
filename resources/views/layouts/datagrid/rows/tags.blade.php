<?php /** @var \App\Models\MiscModel|\App\Models\Entity $model */?>
@if ($model instanceof \App\Models\Entity)

@elseif ($model instanceof \App\Models\MiscModel)
    <div class="flex gap-1 flex-wrap">
    @foreach ($model->entity->tags as $tag)
        <a href="{{ $tag->getLink() }}">
            {!! $tag->bubble() !!}
        </a>
    @endforeach
    </div>
@endif
