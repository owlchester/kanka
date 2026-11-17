<template>
    <div class="flex flex-wrap items-center gap-2 p-2">
        <span class="sidebar-v2-handle cursor-move" aria-hidden="true">⠿</span>
        <input v-if="section" type="text" :value="label" :aria-label="i18n.sectionName" maxlength="90"
            class="grow min-w-0" @input="$emit('rename', $event.target.value)" />
        <span v-else class="grow"><i :class="entry?.icon" aria-hidden="true"></i> {{ entry?.label }}
            <span v-if="entry?.disabled" class="text-neutral-content text-sm">({{ i18n.disabled }})</span>
        </span>
        <button type="button" class="btn2 btn-sm btn-ghost" :aria-label="i18n.up" :title="i18n.up" @click="$emit('order', -1)">↑</button>
        <button type="button" class="btn2 btn-sm btn-ghost" :aria-label="i18n.down" :title="i18n.down" @click="$emit('order', 1)">↓</button>
        <select v-if="!section" :aria-label="i18n.move" @change="$emit('move', $event.target.value); $event.target.value = ''">
            <option value="">{{ i18n.move }}</option>
            <option value="root">{{ i18n.top }}</option>
            <option v-for="destination in sections" :key="destination.id" :value="destination.id">{{ destination.label }}</option>
        </select>
        <span class="inline-flex w-8 h-8 shrink-0 items-center justify-center">
            <button v-if="removable" type="button" class="btn2 btn-sm btn-ghost w-8 h-8 p-0!"
                :aria-label="section ? i18n.removeSection : i18n.remove" :title="section ? i18n.removeSection : i18n.remove" @click="$emit('remove')">×</button>
            <span v-else :title="i18n.protected" :aria-label="i18n.protected">🔒</span>
        </span>
    </div>
</template>

<script setup>
defineProps(['section', 'label', 'entry', 'sections', 'removable', 'i18n']);
defineEmits(['rename', 'order', 'move', 'remove']);
</script>
