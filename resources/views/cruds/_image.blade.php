@if ($model->image)
    <a href="{{ asset('storage/' . $model->image) }}" title="{{ $model->name }}" target="_blank">
        <img class="profile-user-img img-responsive img-circle" src="{{ asset('storage/' . $model->image) }}" alt="{{ $model->name }} picture">
    </a>
@endif