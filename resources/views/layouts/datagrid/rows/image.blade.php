<?php /** @var \App\Models\MiscModel|\App\Models\Entity $model */?>
@if ($model instanceof \App\Models\Entity)
    <x-entities.thumbnail :entity="$model" :title="$model->name"></x-entities.thumbnail>
@elseif ($model instanceof \App\Models\MiscModel)
    <x-entities.thumbnail :entity="$model->entity" :title="$model->name"></x-entities.thumbnail>
@elseif (!empty($with))
    @php $target = \Illuminate\Support\Arr::get($with, 'target', false); @endphp
    <a class="entity-image cover-background" style="background-image: url('{{ $model->$target->thumbnail() }}');" title="{{ $model->$target->name }}" href="{{ $model->$target->getLink() }}"></a>
@endif
