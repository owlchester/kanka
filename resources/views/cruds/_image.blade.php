@if ($model->image)
    <a href="/storage/{{ $model->image }}" title="{{ $model->name }}" target="_blank">
        <img class="profile-user-img img-responsive img-circle" src="/storage/{{ $model->image }}" alt="{{ $model->name }} picture">
    </a>
@endif