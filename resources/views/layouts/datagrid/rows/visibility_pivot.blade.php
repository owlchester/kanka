@if (auth()->check())
    @php
    /** @var \App\Models\Visibility $pivot */
    $pivot = new \App\Models\EntityAbility();
    $pivot->visibility_id = $model->pivot->visibility_id;
    @endphp
    @include('icons.visibility', ['icon' => $pivot->visibilityIcon()])
@endif
