<?php /** @var \App\Models\MiscModel|\App\Models\Entity $model */?>
@if ($model instanceof \App\Models\Entity)
    <a class="entity-image" style="background-image: url('{{ $model->avatar(true) }}');" title="{{ $model->name }}" href="{{ $model->url('show') }}"></a>
@elseif ($model instanceof \App\Models\MiscModel)
<a class="entity-image" style="background-image: url('{{ $model->getImageUrl(40) }}');" title="{{ $model->name }}" href="{{ $model->getLink() }}"></a>
@elseif (!empty($with))
    @php $target = \Illuminate\Support\Arr::get($with, 'target', false); @endphp
    <a class="entity-image" style="background-image: url('{{ $model->$target->getImageUrl(40) }}');" title="{{ $model->$target->name }}" href="{{ $model->$target->getLink() }}"></a>

@endif
