@if ($model->image)
    <a href="{{ Storage::url($model->image) }}" title="{{ $model->name }}" target="_blank">
        <img class="profile-user-img img-responsive img-bordered-sm" src="{{ Storage::url($model->image) }}" alt="{{ $model->name }} picture">
    </a>
@endif