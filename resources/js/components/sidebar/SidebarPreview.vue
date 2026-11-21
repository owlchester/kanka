<template>
    <div class="flex flex-col gap-3">
        <label v-if="hasInaccessible" class="flex items-center gap-2 text-xs text-base-content cursor-pointer select-none">
            <input v-model="hideInaccessible" type="checkbox" class="checkbox checkbox-xs" />
            <span>{{ i18n.previewHideInaccessible.replace(':role', roleName) }}</span>
        </label>

        <div class="rounded-lg bg-sidebar text-white/90 p-3 flex flex-col gap-0.5 text-sm max-h-[28rem] overflow-y-auto">
            <p v-if="!previewItems.length" class="text-xs text-white/60 text-center py-6 mb-0">
                {{ i18n.previewEmpty }}
            </p>
            <template v-for="item in previewItems" :key="item.id">
                <div v-if="item.children" class="pt-3 first:pt-1">
                    <div class="px-2 py-1 text-[11px] font-semibold uppercase tracking-wider text-white/60 truncate">
                        {{ item.label }}
                    </div>
                    <ul class="list-none p-0 m-0 flex flex-col gap-0.5">
                        <li
                            v-for="child in item.children"
                            :key="child.id"
                            class="px-2 py-1.5 flex items-center gap-2 rounded text-sm text-white/90"
                        >
                            <span class="w-5 text-center shrink-0">
                                <i class="shrink-0 text-sm" :class="child.icon" aria-hidden="true"></i>
                            </span>
                            <span class="truncate">{{ child.label }}</span>
                        </li>
                    </ul>
                </div>
                <div v-else class="px-2 py-1.5 flex items-center gap-2 rounded text-sm text-white/90">
                    <span class="w-5 text-center shrink-0">
                        <i class="shrink-0 text-sm" :class="item.icon" aria-hidden="true"></i>
                    </span>
                    <span class="truncate">{{ item.label }}</span>
                </div>
            </template>
        </div>

        <p class="text-xs text-neutral-content mb-0">{{ i18n.previewNote }}</p>
    </div>
</template>

<script setup>
import { computed, ref } from 'vue';
import { buildPreviewItems } from './sidebarState.js';

const props = defineProps({
    items: { type: Array, required: true },
    catalog: { type: Object, required: true },
    inaccessible: { type: Object, default: () => ({}) },
    roleName: { type: String, default: '' },
    i18n: { type: Object, required: true },
});

const hideInaccessible = ref(true);
const hasInaccessible = computed(() => Object.keys(props.inaccessible ?? {}).length > 0);

const previewItems = computed(() =>
    buildPreviewItems(
        props.items,
        props.catalog,
        props.inaccessible,
        hasInaccessible.value && hideInaccessible.value,
        props.i18n.sections
    )
);
</script>
