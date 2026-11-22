<template>
    <dialog
        ref="dialogEl"
        class="dialog rounded-top md:rounded-2xl bg-base-100 shadow-md text-base-content w-full max-w-md"
        aria-modal="true"
        @cancel.prevent="$emit('close')"
        @click="onBackdropClick"
    >
        <header class="flex items-center gap-2 px-4 py-3 border-b border-base-200">
            <i class="fa-solid fa-magnifying-glass opacity-60" aria-hidden="true"></i>
            <input
                ref="inputEl"
                v-model="query"
                type="text"
                class="w-full bg-transparent outline-none text-sm"
                :placeholder="placeholder"
                @keydown.enter="selectFirst"
            />
            <button
                type="button"
                class="text-xl opacity-50 hover:opacity-100 cursor-pointer"
                aria-label="Close"
                @click="$emit('close')"
            >
                <i class="fa-regular fa-circle-xmark" aria-hidden="true"></i>
            </button>
        </header>
        <article class="max-h-72 overflow-y-auto p-2 flex flex-col gap-1">
            <button
                v-for="item in filtered"
                :key="item.id"
                type="button"
                class="w-full text-left px-3 py-2 rounded-lg hover:bg-primary/10 flex items-center justify-between text-sm cursor-pointer"
                @click="pick(item.id)"
            >
                <span class="truncate font-medium">{{ item.label }}</span>
                <span v-if="item.isPlaceholder" class="badge badge-xs badge-ghost">
                    {{ placeholderBadge }}
                </span>
            </button>
            <div v-if="filtered.length === 0" class="text-center py-6 text-xs text-neutral-content">
                No matching people in this tree.
            </div>
        </article>
    </dialog>
</template>

<script setup>
import { computed, nextTick, ref, watch } from 'vue';

const props = defineProps({
    open: { type: Boolean, default: false },
    people: { type: Array, default: () => [] },
    placeholder: { type: String, default: 'Search tree…' },
    placeholderBadge: { type: String, default: 'Placeholder' },
});

const emit = defineEmits(['close', 'select']);

const query = ref('');
const inputEl = ref(null);
const dialogEl = ref(null);

watch(
    () => props.open,
    async (isOpen) => {
        const el = dialogEl.value;
        if (!el) {
            return;
        }
        if (isOpen) {
            query.value = '';
            if (!el.open) {
                el.showModal();
            }
            await nextTick();
            inputEl.value?.focus();
        } else if (el.open) {
            el.close();
        }
    }
);

function onBackdropClick(e) {
    if (e.target === dialogEl.value) {
        emit('close');
    }
}

const filtered = computed(() => {
    const q = query.value.trim().toLowerCase();
    if (!q) {
        return props.people;
    }
    return props.people.filter((p) => p.label.toLowerCase().includes(q));
});

function pick(id) {
    emit('select', id);
    emit('close');
}

function selectFirst() {
    if (filtered.value.length > 0) {
        pick(filtered.value[0].id);
    }
}
</script>
