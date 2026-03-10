<template>
    <Tippy
        placement="bottom-start"
        trigger="click"
        :interactive="true"
        :arrow="false"
        theme="kanka"
        @show="onShow"
        ref="tippyRef"
    >
        <button type="button" :class="pillClass">
            <span class="max-w-28 truncate">{{ alias.name }}</span>
            <span class="opacity-60 text-[10px]">{{ visibilityLabel }}</span>
            <span
                class="leading-none flex-none opacity-60 hover:opacity-100 border border-inherit rounded-full flex items-center align-middle w-4 h-4 justify-center"
                @click.stop="emit('delete', alias)"
                :aria-label="deleteLabel"
            >&times;</span>
        </button>

        <template #content="{ hide }">
            <div class="flex flex-col gap-4 p-3 w-52">
                <div class="flex flex-col gap-2">
                    <label class="text-xs font-medium opacity-80">{{ aliasNameLabel }}</label>
                    <input
                        v-model="editName"
                        type="text"
                        class="w-full text-sm"
                        maxlength="45"
                        ref="popoverInput"
                        @keydown.enter.prevent="() => { save(); hide() }"
                        @keydown.esc="hide"
                    />
                </div>
                <div class="flex flex-col gap-2">
                    <label class="text-xs font-medium opacity-80">{{ visibleToLabel }}</label>
                    <select v-model="editVisibility" class="w-full text-sm">
                        <option v-for="opt in visibilityOptions" :key="opt.value" :value="opt.value">
                            {{ opt.label }}
                        </option>
                    </select>
                </div>
                <div class="flex gap-1 justify-between">
                    <button
                        type="button"
                        class="btn2 btn-error btn-xs btn-outline"
                        @click="() => { removeAlias(); hide() }"
                    >{{ deleteLabel }}</button>
                    <button
                        type="button"
                        class="btn2 btn-primary btn-xs"
                        @click="() => { save(); hide() }"
                    >{{ saveLabel }}</button>
                </div>
            </div>
        </template>
    </Tippy>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue'
import { Tippy } from 'vue-tippy'

type Alias = { id: number | string; name: string; visibility: string }

const props = defineProps<{
    alias: Alias,
    visibilityOptions: Array<{ value: string; label: string }>,
    saveLabel: string,
    deleteLabel: string,
    aliasNameLabel: string,
    visibleToLabel: string,
}>()

const emit = defineEmits<{
    update: [alias: Alias],
    delete: [alias: Alias],
}>()

const tippyRef = ref()
const popoverInput = ref<HTMLInputElement | null>(null)
const editName = ref(props.alias.name)
const editVisibility = ref(props.alias.visibility)

const colorMap: Record<string, string> = {
    all: 'bg-sky-100 text-sky-700',
    members: 'bg-stone-200 text-stone-700',
    admin: 'bg-amber-100 text-amber-700',
    'admin-self': 'bg-orange-100 text-orange-700',
    self: 'bg-purple-100 text-purple-700',
}

const pillClass = computed(() => {
    const base = 'flex items-center gap-2 px-3 py-1 rounded-full text-xs cursor-pointer select-none'
    const color = colorMap[props.alias.visibility] ?? 'bg-base-200 text-base-content'
    return `${base} ${color}`
})

const visibilityLabel = computed(() =>
    props.visibilityOptions.find(o => o.value === props.alias.visibility)?.label ?? props.alias.visibility
)

const onShow = () => {
    editName.value = props.alias.name
    editVisibility.value = props.alias.visibility
    setTimeout(() => popoverInput.value?.focus(), 50)
}

const save = () => {
    if (!editName.value.trim()) {
        return
    }
    emit('update', { ...props.alias, name: editName.value.trim(), visibility: editVisibility.value })
}

const removeAlias = () => {
    emit('delete', props.alias)
}
</script>
