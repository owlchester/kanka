<div class="entity-grid flex flex-col gap-5">
    @include('entities.components.header', [
        'breadcrumb' => [
            Breadcrumb::entity($entity)->list(),
        ]
    ])

    <div class="entity-body flex flex-col md:flex-row gap-5">
        @include('entities.components.menu_v2', ['active' => 'story'])

        <div class="entity-main-block grow flex flex-col gap-5 min-w-0">
            <x-box>
                @can('update', $entity)
                    <p class="text-right">
                        <a href="{{ route('entities.attributes.edit', [$campaign, 'entity' => $entity]) }}" class="btn2 btn-sm">
                            <x-icon class="fa-solid fa-list" />
                            <span class="hidden md:inline">{{ __('entities/attributes.actions.manage') }}</span>
                        </a>
                    </p>
                @endcan

                @include('entities.pages.attributes.render', ['entity' => $entity])
            </x-box>
            @include('entities.components.posts')
        </div>

        @include('entities.components.pins')
    </div>
</div>
