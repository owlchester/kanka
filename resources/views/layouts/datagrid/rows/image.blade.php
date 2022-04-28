@if ($model instanceof \App\Models\Entity)
    <a class="entity-image" style="background-image: url('{{ $model->avatar(true) }}');" title="{{ $model->name }}" href="{{ $model->url('show') }}"></a>
@else
<?php /** @var \App\Models\MiscModel $model */?>
<a class="entity-image" style="background-image: url('{{ $model->getImageUrl(40) }}');" title="{{ $model->name }}" href="{{ $model->getLink() }}"></a>
@endif
