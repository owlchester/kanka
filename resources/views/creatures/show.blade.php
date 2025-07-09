<div class="entity-grid flex flex-col gap-5">
    @include('entities.components.header')

    <div class="entity-body flex flex-col md:flex-row gap-5">
        @include('entities.components.menu_v2', ['active' => 'story'])

        <div class="entity-main-block grow flex flex-col gap-5 min-w-0">
            @include('entities.components.posts', ['withEntry' => true])
        </div>

        @include('entities.components.pins')
    </div>
</div>
