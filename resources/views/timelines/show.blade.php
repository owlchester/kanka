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
            @include('entities.components.posts', ['withEntry' => true])
            @include('timelines._timeline', ['timeline' => $entity->child])
        </div>

        @include('entities.components.pins')
    </div>
</div>
