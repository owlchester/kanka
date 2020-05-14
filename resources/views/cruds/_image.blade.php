@if ($model->image)
    <a href="{{ $model->getImageUrl(0) }}" title="{{ $model->name }}" target="_blank">
        <img class="profile-user-img img-responsive img-bordered-sm" src="{{ $model->getImageUrl(0) }}" alt="{{ $model->name }} picture">
    </a>
@endif
