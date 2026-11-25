@can('update', $entity)
    <div class="bg-base-100 rounded-lg p-6 entity-empty-state">
        <h2 class="text-lg font-semibold mb-4">{{ __('entities/assets.empty.title', ['name' => $entity->name]) }}</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <a href="#"
               data-toggle="dialog"
               data-url="{{ route('entities.entity_assets.create', [$campaign, $entity, 'type' => \App\Enums\EntityAssetType::file]) }}"
               class="group flex items-start gap-3 p-4 rounded-lg bg-base-200/60 hover:bg-base-200 transition-colors text-left">
                <span class="shrink-0 mt-0.5 text-primary">
                    <x-icon class="fa-regular fa-upload fa-lg" />
                </span>
                <div>
                    <div class="font-medium text-base-content group-hover:text-primary transition-colors">
                        {{ __('entities/assets.empty.file.title') }}
                    </div>
                    <p class="text-sm text-base-content/70 mt-0.5 mb-0">
                        {{ __('entities/assets.empty.file.description') }}
                    </p>
                </div>
            </a>

            <a href="#"
               data-toggle="dialog"
               data-url="{{ route('entities.entity_assets.create', [$campaign, $entity, 'type' => \App\Enums\EntityAssetType::link]) }}"
               class="group flex items-start gap-3 p-4 rounded-lg bg-base-200/60 hover:bg-base-200 transition-colors text-left">
                <span class="shrink-0 mt-0.5 text-primary">
                    <x-icon class="fa-regular fa-link fa-lg" />
                </span>
                <div>
                    <div class="font-medium text-base-content group-hover:text-primary transition-colors">
                        {{ __('entities/assets.empty.link.title') }}
                    </div>
                    <p class="text-sm text-base-content/70 mt-0.5 mb-0">
                        {{ __('entities/assets.empty.link.description') }}
                    </p>
                </div>
            </a>
        </div>
    </div>
@else
    <div class="bg-base-100 rounded-lg p-6 text-center text-base-content/60 entity-empty-state">
        <p class="m-0">{{ __('entities/assets.empty.read_only') }}</p>
    </div>
@endcan
