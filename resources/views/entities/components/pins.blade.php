@php
/** @var \App\Models\Entity $entity */
$forceShow = false;
if (!$entity->entityType->isSpecial() && method_exists($entity->child, 'pinnedMembers') && !$entity->child->pinnedMembers->isEmpty()) {
    $forceShow = true;
}
if (auth()->check() && auth()->user()->can('update', $entity)) {
    $forceShow = true;
}
@endphp
<aside class="entity-sidebar relative grid grid-cols-2 md:flex md:flex-col gap-5 items-stretch md:w-48 flex-none">

    @if ($forceShow || $entity->hasPins())
        <div class="col-span-2 sidebar-section-box entity-pins overflow-hidden flex flex-col gap-2 {{ $entity->hasPins() ? '' : 'entity-empty-pin' }}">
            <div class="sidebar-section-title cursor-pointer user-select border-b element-toggle flex items-center gap-2 justify-between group" data-animate="collapse" data-target="#sidebar-pinned-elements">
                <div>
                    <x-icon class="fa-solid fa-chevron-up icon-show transition-transform duration-200 group-hover:-translate-y-0.5" />
                    <x-icon class="fa-solid fa-chevron-down icon-hide transition-transform duration-200 group-hover:translate-y-0.5" />
                    <span class="text-lg ">{{ __('entities/pins.title') }}</span>
                </div>
                <a href="https://docs.kanka.io/en/latest/features/profile-sidebar.html" aria-label="{{ __('crud.helpers.learn_more', ['documentation' => __('footer.documentation')]) }}" data-toggle="tooltip" data-title="{{ __('crud.helpers.learn_more', ['documentation' => __('footer.documentation')]) }}" class="">
                    <x-icon class="question" />
                </a>
            </div>
            <div class="sidebar-elements grid overflow-hidden" id="sidebar-pinned-elements">
                <div class="pins flex flex-col gap-2">
                    @includeWhen(!$entity->pinnedFiles->isEmpty() || !$entity->pinnedAliases->isEmpty(), 'entities.components.assets')
                    @include('entities.components.relations')
                    @includeWhen(!$entity->entityType->isSpecial() && method_exists($entity->child, 'pinnedMembers') && !$entity->child->pinnedMembers->isEmpty(), 'entities.components.members')
                    @can('view-attributes', [$entity, $campaign])
                        @include('entities.components.attributes')
                    @endcan
                </div>
            </div>
        </div>
    @endif

    @if ($entity->entityType->isSpecial())
            @includeIf('entities.components.profile.custom')
    @else
        @includeIf('entities.components.profile.' . $entity->entityType->pluralCode())
    @endif

    @includeWhen(!isset($printing) && $campaign->boosted() && $entity->hasLinks(), 'entities.components.links')

    @include('entities.components.history')
</aside>
