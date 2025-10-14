@section('entity-header-actions-override')
    <div class="header-buttons flex gap-2 items-center justify-end flex-wrap">
        @include('entities.headers.toggle')
        @include('entities.headers.actions')
    </div>
@endsection

<div class="entity-grid flex flex-col gap-5">
    @include('entities.components.header', [
        'entityHeaderActions' => 'entity-header-actions-override',
    ])

    <div class="entity-body flex flex-col md:flex-row gap-5">
        @include('entities.components.menu_v2', ['active' => 'story'])

        <div class="entity-main-block grow flex flex-col gap-5 min-w-0">
            <a href="{{ route('whiteboards.draw', [$campaign, $entity->child]) }}" class="btn2 btn-block btn-primary draw-link" target="_blank">
                <x-icon class="fa-duotone fa-chalkboard" /> {{ __('whiteboards.actions.draw') }}
            </a>

            @include('entities.components.posts', ['withEntry' => true])
        </div>

        @include('entities.components.pins')
    </div>
</div>
