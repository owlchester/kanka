<template>
    <div
        class="kanka-ft-node flex flex-col justify-center px-3 py-2 select-none"
        :class="nodeClasses"
        :style="nodeStyle"
        @click="onSelect"
    >
        <Handle type="target" :position="targetPos" />
        <Handle type="source" :position="sourcePos" />

        <!-- Direct-manipulation + handles in Edit mode -->
        <template v-if="isEditing">
            <button
                type="button"
                class="kanka-ft-action-btn kanka-ft-action-btn--top"
                :title="texts?.actions?.add_parent || 'Add parent'"
                @click.stop="emitAction('add-parent')"
            >
                <i class="fa-solid fa-plus" aria-hidden="true"></i>
            </button>
            <button
                type="button"
                class="kanka-ft-action-btn kanka-ft-action-btn--right"
                :title="texts?.actions?.add_partner || 'Add partner'"
                @click.stop="emitAction('add-partner')"
            >
                <i class="fa-solid fa-heart" aria-hidden="true"></i>
            </button>
            <button
                type="button"
                class="kanka-ft-action-btn kanka-ft-action-btn--bottom"
                :title="texts?.actions?.add_child || 'Add child'"
                @click.stop="emitAction('add-child')"
            >
                <i class="fa-solid fa-plus" aria-hidden="true"></i>
            </button>
        </template>

        <div class="flex items-center gap-2.5 min-w-0">
            <!-- Avatar -->
            <div class="shrink-0">
                <img
                    v-if="entity?.thumb"
                    :src="entity.thumb"
                    :alt="displayName"
                    class="rounded-full object-cover bg-base-200"
                    :class="compact ? 'w-8 h-8' : 'w-10 h-10'"
                    loading="lazy"
                />
                <div
                    v-else
                    class="rounded-full bg-base-200 flex items-center justify-center text-neutral-content"
                    :class="compact ? 'w-8 h-8 text-xs' : 'w-10 h-10 text-sm'"
                >
                    <i class="fa-regular fa-user" aria-hidden="true"></i>
                </div>
            </div>

            <!-- Details -->
            <div class="min-w-0 flex-1">
                <div class="flex items-center gap-1 min-w-0">
                    <a
                        v-if="entity && !isEditing"
                        :href="entity.url"
                        class="font-semibold text-sm truncate hover:underline text-base-content"
                        @click.stop
                    >
                        {{ displayName }}
                    </a>
                    <span v-else class="font-semibold text-sm truncate text-base-content">
                        {{ displayName }}
                    </span>

                    <i
                        v-if="entity?.status?.icon"
                        :class="entity.status.icon"
                        :title="entity.status.name"
                        class="text-xs opacity-70 shrink-0"
                        aria-hidden="true"
                    ></i>
                </div>

                <div v-if="!compact" class="flex flex-wrap items-center gap-1.5 mt-0.5 text-xs text-neutral-content">
                    <span v-if="lifespan" class="truncate">{{ lifespan }}</span>
                    <span v-else-if="isPlaceholder && person.placeholder?.subtitle" class="truncate italic">
                        {{ person.placeholder.subtitle }}
                    </span>
                    <span
                        v-else-if="isPlaceholder"
                        class="badge badge-xs badge-ghost opacity-75"
                    >
                        {{ texts?.placeholders?.badge || 'Placeholder' }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Cross-tree jump badges -->
        <div v-if="!compact && linkedTrees.length > 0" class="flex flex-wrap gap-1 mt-1.5 pt-1 border-t border-base-200/70">
            <a
                v-for="lt in visibleLinkedTrees"
                :key="lt.family_id"
                :href="lt.url"
                class="inline-flex items-center gap-1 text-[10px] px-1.5 py-0.5 rounded bg-base-200/80 hover:bg-primary/15 text-base-content/80 hover:text-primary transition-colors truncate max-w-full"
                :title="(texts?.linked_trees?.jump || 'Open :name tree').replace(':name', lt.name)"
                @click.stop
            >
                <i class="fa-solid fa-sitemap text-[9px]" aria-hidden="true"></i>
                <span class="truncate">{{ lt.name }}</span>
            </a>
            <span
                v-if="extraLinkedCount > 0"
                class="inline-flex items-center text-[10px] px-1.5 py-0.5 rounded bg-base-200/80 text-neutral-content"
            >
                {{ (texts?.linked_trees?.more || '+:count trees').replace(':count', extraLinkedCount) }}
            </span>
        </div>
    </div>
</template>

<script setup>
import { computed, inject } from 'vue';
import { Handle, Position } from '@vue-flow/core';

const props = defineProps({
    id: { type: String, required: true },
    data: { type: Object, required: true },
    selected: { type: Boolean, default: false },
});

const treeCtx = inject('familyTreeContext', {});

const person = computed(() => props.data.person || {});
const entity = computed(() => props.data.entity || null);
const linkedTrees = computed(() => props.data.linkedTrees || []);
const compact = computed(() => Boolean(props.data.compact));
const isEditing = computed(() => Boolean(treeCtx.isEditing?.value));
const isFocused = computed(() => treeCtx.focusedNodeId?.value === props.id);
const texts = computed(() => treeCtx.texts?.value || {});

const isPlaceholder = computed(() => !person.value.entity_id);

const displayName = computed(() => {
    if (entity.value?.name) {
        return entity.value.name;
    }
    const phName = person.value.placeholder?.name;
    if (phName && phName.trim() !== '') {
        return phName;
    }
    return texts.value?.placeholders?.unknown || 'Unknown';
});

const lifespan = computed(() => {
    const b = entity.value?.birth;
    const d = entity.value?.death;
    if (b === null && d === null) {
        return '';
    }
    if (b !== undefined && b !== null && d !== undefined && d !== null) {
        return `${b} – ${d}`;
    }
    if (b !== undefined && b !== null) {
        return `* ${b}`;
    }
    if (d !== undefined && d !== null) {
        return `† ${d}`;
    }
    return '';
});

const visibleLinkedTrees = computed(() => linkedTrees.value.slice(0, 2));
const extraLinkedCount = computed(() => Math.max(0, linkedTrees.value.length - 2));

const sourcePos = computed(() => (props.data.direction === 'LR' ? Position.Right : Position.Bottom));
const targetPos = computed(() => (props.data.direction === 'LR' ? Position.Left : Position.Top));

const nodeClasses = computed(() => {
    const classes = [];
    if (compact.value) {
        classes.push('kanka-ft-node--compact');
    }
    if (isPlaceholder.value) {
        classes.push('kanka-ft-node--placeholder');
    }
    if (props.selected) {
        classes.push('kanka-ft-node--selected');
    }
    if (isFocused.value) {
        classes.push('kanka-ft-node--focused');
    }
    if (entity.value?.death !== null && entity.value?.death !== undefined) {
        classes.push('kanka-ft-node--dead');
    }
    if (Array.isArray(entity.value?.tags)) {
        classes.push(...entity.value.tags);
    }
    if (person.value.cssClass) {
        classes.push(person.value.cssClass);
    }
    return classes;
});

const nodeStyle = computed(() => {
    if (!person.value.colour) {
        return {};
    }
    return { '--ft-colour': person.value.colour };
});

function onSelect() {
    treeCtx.selectElement?.({ type: 'person', id: props.id });
}

function emitAction(action) {
    treeCtx.openQuickAdd?.({ action, personId: props.id });
}
</script>
