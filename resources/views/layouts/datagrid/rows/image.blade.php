<?php /** @var \App\Models\MiscModel|\App\Models\Entity $model */?>
@if ($model instanceof \App\Models\Entity)
    <x-entities.thumbnail :entity="$model" :title="$model->name"></x-entities.thumbnail>
@elseif ($model instanceof \App\Models\MiscModel || $model instanceof \App\Models\Post)
    <x-entities.thumbnail :entity="$model->entity" :title="$model->name"></x-entities.thumbnail>
@elseif ($model instanceof \App\Models\MapLayer && $model->hasImage())
    <a class="w-10 h-10 entity-image cover-background"
       style="background-image: url('{{ $model->thumbnail(40) }}');"
       title="{{ $model->name }}"
       href="{{ $model->getLink() }}"></a>
@elseif (!empty($with))
    @php $target = \Illuminate\Support\Arr::get($with, 'target', false); @endphp
    <a class="entity-image w-10 h-10 cover-background" style="background-image: url('{{ \App\Facades\Avatar::entity($model->$target->entity)->size(40)->fallback()->thumbnail() }}');" title="{{ $model->$target->name }}" href="{{ $model->$target->getLink() }}"></a>
@endif
