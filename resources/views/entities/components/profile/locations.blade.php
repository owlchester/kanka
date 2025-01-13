<?php /** @var \App\Models\Location $model */?>

@if (!$entity->child->showProfileInfo())
    @php return @endphp
@endif

<x-sidebar.profile>
    @include('entities.components.profile._type')
    @include('entities.components.profile._events')

    @if (!$entity->child->maps->isEmpty())
        <div class="profile-maps">
            <div class="title text-uppercase text-xs">
                {!! \App\Facades\Module::singular(config('entities.ids.map'), __('entities.map')) !!}
            </div>
            @foreach ($entity->child->maps as $map)
                <x-entity-link
                    :entity="$map->entity"
                    :campaign="$campaign" />
                @include('maps._explore-link')<br />
            @endforeach
        </div>
    @endif
</x-sidebar.profile>
