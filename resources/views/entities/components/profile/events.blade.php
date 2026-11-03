<?php
/**
 * @var \App\Models\Entity $entity
 * @var \App\Models\Event $model
 */
$child = $entity->child;
?>

@if (!$child->showProfileInfo())
    @php return @endphp
@endif

<x-sidebar.profile>
    @includeWhen($entity->aliases->isNotEmpty(), 'entities.components.profile._aliases')
    @include('entities.components.profile._locations')
    @include('entities.components.profile._type')
    @include('entities.components.profile._reminder')
    @if ($child->groups->isNotEmpty() || $child->participants->isNotEmpty())
        <div class="sidebar-section-box overflow-hidden flex flex-col gap-2">
            <div class="sidebar-section-title cursor-pointer group user-select border-b element-toggle" data-animate="collapse" data-target="#sidebar-event-participants">
                <x-icon class="fa-regular fa-chevron-up icon-show transition-transform duration-200 group-hover:-translate-y-0.5" />
                <x-icon class="fa-regular fa-chevron-down icon-hide transition-transform duration-200 group-hover:translate-y-0.5" />
                <span class="text-lg">{{ __('events.participants.title') }}</span>
            </div>
            <div class="sidebar-elements grid overflow-hidden" id="sidebar-event-participants">
                <div class="flex flex-col gap-3">
                    @foreach ($child->groups as $group)
                        <section class="flex flex-col gap-1">
                            <h3 class="title text-uppercase text-xs" @if ($group->colour) style="color: {{ $group->colour }}" @endif>{{ $group->name }}</h3>
                            @foreach ($group->participants as $participant)
                                <div class="flex flex-wrap items-center gap-1">
                                    <x-entity-link :entity="$participant->entity" :campaign="$campaign" />
                                    @if ($participant->role)<span class="inline-flex items-center rounded-full bg-base-200 px-2 py-0.5 text-xs text-neutral-content">{{ $participant->role }}</span>@endif
                                </div>
                            @endforeach
                        </section>
                    @endforeach
                    @if ($child->participants->isNotEmpty())
                        <section class="flex flex-col gap-1">
                            @if ($child->groups->isNotEmpty())
                                <h3 class="title text-uppercase text-xs">{{ __('events.participants.other') }}</h3>
                            @endif
                            @foreach ($child->participants as $participant)
                                <div class="flex flex-wrap items-center gap-1">
                                    <x-entity-link :entity="$participant->entity" :campaign="$campaign" />
                                    @if ($participant->role)<span class="inline-flex items-center rounded-full bg-base-200 px-2 py-0.5 text-xs text-neutral-content">{{ $participant->role }}</span>@endif
                                </div>
                            @endforeach
                        </section>
                    @endif
                </div>
            </div>
        </div>
    @endif
</x-sidebar.profile>
