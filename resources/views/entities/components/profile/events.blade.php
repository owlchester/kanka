<?php
/**
 * @var \App\Models\Entity $entity
 * @var \App\Models\Event $model
 */
$child = $entity->child;
$hasProfileFields = $entity->aliases->isNotEmpty()
    || $entity->locations->isNotEmpty()
    || ! empty($child->type)
    || ! empty($entity->calendarReminder());
$visibleGroups = $child->groups->filter(fn ($group) => $group->participants->isNotEmpty());
$ungrouped = $child->participants;
$totalParticipants = $visibleGroups->sum(fn ($group) => $group->participants->count()) + $ungrouped->count();
?>

@if (!$child->showProfileInfo())
    @php return @endphp
@endif

@if ($hasProfileFields)
    <x-sidebar.profile>
        @includeWhen($entity->aliases->isNotEmpty(), 'entities.components.profile._aliases')
        @include('entities.components.profile._locations')
        @include('entities.components.profile._type')
        @include('entities.components.profile._reminder')
    </x-sidebar.profile>
@endif

@if ($totalParticipants > 0)
    <div class="sidebar-section-box overflow-hidden flex flex-col gap-2">
        <button
            type="button"
            class="sidebar-section-title text-left cursor-pointer group user-select element-toggle flex items-center justify-between gap-2 w-full"
            data-animate="collapse"
            data-target="#sidebar-event-participants"
            aria-expanded="true"
            aria-controls="sidebar-event-participants"
        >
            <span class="text-xs font-semibold uppercase tracking-wider truncate">{{ __('events.participants.title') }}</span>
            <span class="flex items-center gap-1.5 shrink-0">
                <span class="text-xs font-medium text-neutral-content bg-base-200 px-1.5 py-0.5 rounded-full">{{ $totalParticipants }}</span>
                <span class="text-xs">
                    <x-icon class="fa-regular fa-chevron-up icon-show transition-transform duration-200 group-hover:-translate-y-0.5" />
                    <x-icon class="fa-regular fa-chevron-down icon-hide transition-transform duration-200 group-hover:translate-y-0.5" />
                </span>
            </span>
        </button>

        <div class="sidebar-elements grid overflow-hidden" id="sidebar-event-participants">
            <div class="flex flex-col gap-4 pt-1">
                @foreach ($visibleGroups as $group)
                    <section
                        class="border-l-2 border-base-300 pl-2.5 flex flex-col gap-2"
                        @if ($group->colour) style="border-left-color: {{ $group->colour }}" @endif
                    >
                        <h3
                            class="flex items-center justify-between gap-2 text-xs font-semibold uppercase tracking-wider"
                            @if ($group->colour) style="color: {{ $group->colour }}" @endif
                        >
                            <span class="truncate">{{ $group->name }}</span>
                            <span class="text-neutral-content font-normal shrink-0">{{ $group->participants->count() }}</span>
                        </h3>
                        <div class="flex flex-col gap-2">
                            @foreach ($group->participants as $participant)
                                <div class="flex items-start gap-2 min-w-0">
                                    <img
                                        src="{{ \App\Services\Images\Avatar::for($participant->entity)->size(48)->fallback()->thumbnail() }}"
                                        alt=""
                                        class="w-6 h-6 rounded-full object-cover shrink-0 mt-0.5"
                                    />
                                    <div class="min-w-0 flex flex-col leading-tight">
                                        <x-entity-link :entity="$participant->entity" :campaign="$campaign" class="truncate" />
                                        @if ($participant->role)
                                            <span class="text-xs text-neutral-content truncate">{{ $participant->role }}</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </section>
                @endforeach

                @if ($ungrouped->isNotEmpty())
                    <section class="{{ $visibleGroups->isNotEmpty() ? 'border-l-2 border-base-300 pl-2.5 ' : '' }}flex flex-col gap-2">
                        @if ($visibleGroups->isNotEmpty())
                            <h3 class="flex items-center justify-between gap-2 text-xs font-semibold uppercase tracking-wider text-neutral-content">
                                <span class="truncate">{{ __('events.participants.other') }}</span>
                                <span class="font-normal shrink-0">{{ $ungrouped->count() }}</span>
                            </h3>
                        @endif
                        <div class="flex flex-col gap-2">
                            @foreach ($ungrouped as $participant)
                                <div class="flex items-start gap-2 min-w-0">
                                    <img
                                        src="{{ \App\Services\Images\Avatar::for($participant->entity)->size(48)->fallback()->thumbnail() }}"
                                        alt=""
                                        class="w-6 h-6 rounded-full object-cover shrink-0 mt-0.5"
                                    />
                                    <div class="min-w-0 flex flex-col leading-tight">
                                        <x-entity-link :entity="$participant->entity" :campaign="$campaign" class="truncate" />
                                        @if ($participant->role)
                                            <span class="text-xs text-neutral-content truncate">{{ $participant->role }}</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </section>
                @endif
            </div>
        </div>
    </div>
@endif
