@php
/** @var \App\Models\Entity $entity */
$forceShow = false;
if ($entity->entityType->isStandard() && method_exists($entity->child, 'pinnedMembers') && !$entity->child->pinnedMembers->isEmpty()) {
    $forceShow = true;
}
if (auth()->check() && auth()->user()->can('update', $entity)) {
    $forceShow = true;
}
@endphp
<aside class="entity-sidebar relative grid grid-cols-2 lg:flex lg:flex-col gap-3 items-stretch lg:w-56 flex-none scroll-mt-32 lg:sticky lg:top-32 lg:self-start" id="entity-details-{{ $entity->id }}" aria-label="Details" tabindex="-1">
    <div class="entity-reader-details contents in-[.entity-details-sheet]:flex in-[.entity-details-sheet]:flex-col in-[.entity-details-sheet]:gap-3" data-reader-details-content>
        @if ($forceShow || $entity->hasPins())
            <div class="col-span-2 sidebar-section-box entity-pins overflow-hidden flex flex-col gap-2 {{ $entity->hasPins() ? '' : 'entity-empty-pin' }}">
                <div class="sidebar-section-title relative flex items-center gap-2 justify-between">
                    <button type="button" class="cursor-pointer user-select element-toggle group text-left grow flex items-center justify-between gap-2" data-animate="collapse" data-target="#sidebar-pinned-elements" aria-expanded="true" aria-controls="sidebar-pinned-elements">
                        <span class="text-xs font-semibold uppercase tracking-wider">{{ __('entities/pins.title') }}</span>
                        <span class="text-xs shrink-0">
                            <x-icon class="fa-regular fa-chevron-up icon-show transition-transform duration-200 group-hover:-translate-y-0.5" />
                            <x-icon class="fa-regular fa-chevron-down icon-hide transition-transform duration-200 group-hover:translate-y-0.5" />
                        </span>
                    </button>
                    <a href="https://docs.kanka.io/en/latest/features/profile-sidebar.html" data-toggle="tooltip" data-title="{{ __('general.documentation') }}" class="text-link shrink-0 text-xs absolute right-5 in-[.entity-details-sheet]:static">
                        <x-icon class="question" />
                        <span class="sr-only">{{ __('general.documentation') }}</span>
                    </a>
                </div>
                <div class="sidebar-elements grid overflow-hidden" id="sidebar-pinned-elements">
                    <div class="pins flex flex-col gap-2">
                        @includeWhen(!$entity->pinnedFiles->isEmpty(), 'entities.components.assets')
                        @include('entities.components.relations')
                        @includeWhen($entity->entityType->isStandard() && method_exists($entity->child, 'pinnedMembers') && !$entity->child->pinnedMembers->isEmpty(), 'entities.components.members')
                        @can('view-attributes', [$entity, $campaign])
                            @include('entities.components.attributes')
                        @endcan
                    </div>
                </div>
            </div>
        @endif

        @if ($entity->entityType->isCustom())
            @includeIf('entities.components.profile.custom')
        @else
            @includeIf('entities.components.profile.' . $entity->entityType->pluralCode())
        @endif

        @includeWhen(!isset($printing) && $campaign->boosted() && $entity->hasLinks(), 'entities.components.links')

        @include('entities.components.history')
    </div>

    <div class="col-span-2">
        @include('ads.siderail_right')
    </div>
</aside>
