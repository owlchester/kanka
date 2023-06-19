<?php /** @var \App\Models\Ability $model */?>

@if (!$model->showProfileInfo())
    @php return @endphp
@endif

<x-sidebar.profile>
    @if (!empty($model->charges))
        <div class="element profile-charges">
            <div class="title text-uppercase text-xs">{{ __('abilities.fields.charges') }}</div>
            {{ $model->charges }}
        </div>
    @endif
    @include('entities.components.profile._type')
</x-sidebar.profile>
