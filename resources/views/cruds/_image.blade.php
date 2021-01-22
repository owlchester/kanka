<?php /** @var \App\Models\MiscModel $model */?>
@if ($model->image)
    <a href="{{ $model->getOriginalImageUrl() }}" title="{{ $model->name }}" target="_blank">
        <img class="profile-user-img img-responsive img-bordered-sm" src="{{ $model->getImageUrl(0) }}" alt="{{ $model->name }} picture">
    </a>
@elseif ($campaign->campaign()->boosted(true) && $model->entity && $model->entity->image)
    <a href="{{ $model->entity->image->getUrl() }}" title="{{ $model->name }}" target="_blank">
        <img class="profile-user-img img-responsive img-bordered-sm" src="{{ Img::crop(400, 400)->url($model->entity->image->path) }}" alt="{{ $model->name }} picture">
    </a>
@endif
