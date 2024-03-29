<?php /** @var \App\Models\Location $model */?>

@if (!$model->showProfileInfo())
    @php return @endphp
@endif

<x-sidebar.profile>
    @include('entities.components.profile._type')
    @include('entities.components.profile._events')

    @if (!$model->maps->isEmpty())
        <div class="profile-maps">
            <div class="title text-uppercase text-xs">
                {!! \App\Facades\Module::singular(config('entities.ids.map'), __('entities.map')) !!}
            </div>
            @foreach ($model->maps as $map)
                {!! $map->tooltipedLink() !!} {!! $map->exploreLink() !!}<br />
            @endforeach
        </div>
    @endif
</x-sidebar.profile>
