<template>
    <div
        class="kanka-ft-union select-none"
        :class="unionClasses"
        :style="unionStyle"
        :title="unionTitle"
        @click.stop="onSelect"
    >
        <Handle type="target" :position="targetPos" />
        <Handle type="source" :position="sourcePos" />

        <i :class="unionIcon" aria-hidden="true"></i>
        <span v-if="union.role" class="truncate max-w-[90px] font-medium text-base-content">
            {{ union.role }}
        </span>

        <button
            v-if="isEditing"
            type="button"
            class="kanka-ft-action-btn kanka-ft-action-btn--bottom"
            :title="texts?.actions?.add_child || 'Add child'"
            @click.stop="emitAddChild"
        >
            <i class="fa-solid fa-plus" aria-hidden="true"></i>
        </button>
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

const union = computed(() => props.data.union || {});
const isEditing = computed(() => Boolean(treeCtx.isEditing?.value));
const texts = computed(() => treeCtx.texts?.value || {});

const sourcePos = computed(() => (props.data.direction === 'LR' ? Position.Right : Position.Bottom));
const targetPos = computed(() => (props.data.direction === 'LR' ? Position.Left : Position.Top));

const unionIcon = computed(() => {
    switch (union.value.type) {
        case 'divorced':
            return 'fa-solid fa-heart-crack text-error';
        case 'affair':
            return 'fa-solid fa-bolt text-warning';
        case 'betrothed':
            return 'fa-regular fa-gem text-info';
        case 'partner':
            return 'fa-regular fa-handshake text-primary';
        default:
            return 'fa-solid fa-ring text-primary';
    }
});

const unionTitle = computed(() => {
    const typeLabel = texts.value?.union_types?.[union.value.type] || union.value.type || '';
    return union.value.role ? `${typeLabel}: ${union.value.role}` : typeLabel;
});

const unionClasses = computed(() => {
    const classes = [`kanka-ft-union--${union.value.type || 'married'}`];
    if (props.selected) {
        classes.push('kanka-ft-union--selected');
    }
    if (union.value.cssClass) {
        classes.push(union.value.cssClass);
    }
    return classes;
});

const unionStyle = computed(() => {
    if (!union.value.colour) {
        return {};
    }
    return { '--ft-colour': union.value.colour };
});

function onSelect() {
    treeCtx.selectElement?.({ type: 'union', id: props.id });
}

function emitAddChild() {
    treeCtx.openQuickAdd?.({ action: 'add-union-child', unionId: props.id });
}
</script>
