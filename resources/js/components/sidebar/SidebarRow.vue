<template>
    <div
        class="group flex items-center gap-2 px-3 py-2"
        :class="section ? 'rounded-t-lg' : 'rounded-lg'"
    >
        <span
            class="sidebar-v2-handle cursor-move text-neutral-content/60 hover:text-base-content px-1 shrink-0"
            aria-hidden="true"
        >
            <i class="fa-solid fa-grip-vertical"></i>
        </span>

        <template v-if="section">
            <button
                type="button"
                class="btn2 btn-xs btn-ghost w-6 h-6 p-0! shrink-0 text-neutral-content"
                :aria-label="collapsed ? i18n.expandAll : i18n.collapseAll"
                :aria-expanded="!collapsed"
                @click="$emit('toggle-collapse')"
            >
                <i class="fa-solid text-[11px]" :class="collapsed ? 'fa-chevron-right' : 'fa-chevron-down'"></i>
            </button>

            <div class="grow min-w-0 flex flex-col gap-0.5">
                <div class="flex items-center gap-2 min-w-0">
                    <input
                        type="text"
                        :value="label"
                        :aria-label="i18n.sectionName"
                        maxlength="90"
                        class="grow min-w-0 bg-transparent hover:bg-base-200/70 focus:bg-base-200 rounded px-2 py-1 text-xs font-semibold uppercase tracking-wider border-0 focus:outline-none"
                        :class="{ 'ring-2 ring-error bg-error/5': invalid }"
                        @input="$emit('rename', $event.target.value)"
                        @keydown.enter.prevent="$event.target.blur()"
                        @keydown.escape.prevent="$event.target.blur()"
                    />
                    <span
                        class="text-[11px] font-medium px-2 py-0.5 rounded-full bg-base-200 text-neutral-content shrink-0"
                        :title="i18n.itemsCount.replace(':count', String(childCount ?? 0))"
                    >
                        {{ childCount ?? 0 }}
                    </span>
                    <span
                        v-if="isBookmarks"
                        class="hidden sm:inline-flex items-center gap-1 text-[11px] px-2 py-0.5 rounded-full bg-base-200 text-neutral-content shrink-0"
                        :title="i18n.placement"
                    >
                        {{ i18n.bookmarksBadge }}
                    </span>
                </div>
                <p v-if="invalid" class="text-error text-xs px-2 mb-0">{{ i18n.sectionNameRequired }}</p>
            </div>
        </template>

        <template v-else>
            <span class="w-5 text-center shrink-0 text-neutral-content">
                <i :class="entry?.icon" aria-hidden="true"></i>
            </span>
            <div class="grow min-w-0 flex flex-wrap items-center gap-2">
                <span class="truncate text-sm font-medium">{{ entry?.label }}</span>
                <span
                    v-if="entry?.kind === 'bookmark'"
                    class="text-[11px] px-1.5 py-0.5 rounded bg-base-300/70 text-neutral-content shrink-0"
                >
                    {{ i18n.kindBookmark }}
                </span>
                <Tippy v-if="entry?.duplicates_category" :interactive="true" theme="kanka">
                    <span class="text-[11px] px-1.5 py-0.5 rounded bg-warning text-warning-content font-medium shrink-0 cursor-help">
                        {{ i18n.duplicateCategory }}
                    </span>
                    <template #content>
                        <div class="flex flex-col gap-1.5 p-1 text-xs max-w-60">
                            <p class="mb-0">{{ i18n.duplicateCategoryHelp }}</p>
                            <a
                                v-if="bookmarksUrl"
                                :href="bookmarksUrl"
                                class="text-link inline-flex items-center gap-1 font-medium"
                            >
                                <i class="fa-regular fa-bookmark" aria-hidden="true"></i>
                                <span>{{ i18n.manageBookmarks }}</span>
                            </a>
                        </div>
                    </template>
                </Tippy>
                <span
                    v-if="entry?.disabled"
                    class="text-[11px] px-1.5 py-0.5 rounded bg-base-300/70 text-neutral-content shrink-0"
                >
                    {{ i18n.disabled }}
                </span>
                <span
                    v-if="inaccessibleTooltip"
                    class="inline-flex items-center gap-1 text-warning text-xs shrink-0"
                    :title="inaccessibleTooltip"
                    :aria-label="inaccessibleTooltip"
                >
                    <i class="fa-regular fa-eye-slash" aria-hidden="true"></i>
                </span>
            </div>
        </template>

        <div class="flex items-center gap-1 shrink-0">
            <div class="flex items-center gap-1 opacity-100 md:opacity-0 md:group-hover:opacity-100 md:group-focus-within:opacity-100 transition-opacity">
                <button
                    type="button"
                    class="btn2 btn-xs btn-ghost w-7 h-7 p-0!"
                    :aria-label="i18n.up"
                    :title="i18n.up"
                    @click="$emit('order', -1)"
                >
                    <i class="fa-solid fa-chevron-up text-[11px]"></i>
                </button>
                <button
                    type="button"
                    class="btn2 btn-xs btn-ghost w-7 h-7 p-0!"
                    :aria-label="i18n.down"
                    :title="i18n.down"
                    @click="$emit('order', 1)"
                >
                    <i class="fa-solid fa-chevron-down text-[11px]"></i>
                </button>
                <select
                    v-if="!section"
                    :aria-label="i18n.move"
                    class="text-xs rounded bg-base-100 px-1.5 py-1 max-w-28"
                    @change="$emit('move', $event.target.value); $event.target.value = ''"
                >
                    <option value="">{{ i18n.move }}</option>
                    <option value="root">{{ i18n.top }}</option>
                    <option v-for="destination in sections" :key="destination.id" :value="destination.id">
                        {{ destination.label }}
                    </option>
                </select>
                <button
                    v-if="section && (childCount ?? 0) > 0"
                    type="button"
                    class="btn2 btn-xs btn-ghost w-7 h-7 p-0! text-neutral-content hover:text-base-content"
                    :aria-label="i18n.removeSectionItems"
                    :title="i18n.removeSectionItems"
                    @click="$emit('hide-all')"
                >
                    <i class="fa-regular fa-eye-slash text-xs"></i>
                </button>
            </div>

            <span class="inline-flex w-7 h-7 shrink-0 items-center justify-center">
                <button
                    v-if="removable"
                    type="button"
                    class="btn2 btn-xs btn-ghost w-7 h-7 p-0! text-neutral-content hover:text-error"
                    :aria-label="section ? i18n.removeSection : i18n.remove"
                    :title="section ? i18n.removeSection : i18n.remove"
                    @click="$emit('remove')"
                >
                    <i class="fa-solid fa-xmark"></i>
                </button>
                <span
                    v-else
                    class="text-neutral-content/60 text-xs"
                    :title="isBookmarks ? i18n.placement : i18n.protected"
                    :aria-label="isBookmarks ? i18n.placement : i18n.protected"
                >
                    <i class="fa-solid fa-lock"></i>
                </span>
            </span>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue';
import { Tippy } from 'vue-tippy';

const props = defineProps([
    'section',
    'collapsed',
    'childCount',
    'isBookmarks',
    'label',
    'entry',
    'sections',
    'removable',
    'invalid',
    'inaccessibleReason',
    'roleName',
    'bookmarksUrl',
    'i18n',
]);

defineEmits(['rename', 'toggle-collapse', 'order', 'move', 'remove', 'hide-all']);

const inaccessibleTooltip = computed(() => {
    if (!props.inaccessibleReason) {
        return '';
    }
    if (props.inaccessibleReason === 'private') {
        return props.i18n.inaccessiblePrivate;
    }
    if (props.inaccessibleReason === 'admin_only') {
        return props.i18n.inaccessibleAdmin;
    }
    return props.i18n.inaccessiblePermission.replace(':role', props.roleName || '');
});
</script>
