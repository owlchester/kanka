<?php /** @var \App\Models\MiscModel $model */?>
@if ($model->image)
    <a href="{{ $model->getOriginalImageUrl() }}" title="{{ $model->name }}" target="_blank">
        <img class="profile-user-img img-responsive img-bordered-sm" src="{{ $model->getImageUrl(0) }}" alt="{{ $model->name }} picture">
    </a>
@endif
