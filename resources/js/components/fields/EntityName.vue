<template>
    <div class="flex flex-col gap-2">
        <!-- Label row with + Alias button -->
        <div class="flex items-center justify-between" :class="{ required: required }">
            <label :for="inputId" class="text-xs font-medium opacity-80">{{ label }}</label>
            <button
                v-if="aliasesEnabled"
                type="button"
                :disabled="isAliasLimitReached"
                :class="addBtnClass"
                @click="toggleAddForm"
            >
                <i class="fa-regular fa-plus" aria-hidden="true" />
                {{ i18n.addAlias }}
            </button>
        </div>

        <!-- Name input -->
        <input
            :id="inputId"
            type="text"
            name="name"
            :value="name"
            :placeholder="placeholder"
            :required="required"
            maxlength="191"
            class="w-full"
            data-1p-ignore="true"
            @input="onNameInput"
        />

        <!-- Similarity alert -->
        <similar-entity-alert
            :entities="similarEntities"
            :label="i18n.duplicateWarning"
        />

        <!-- Inline add alias form -->
        <div
            v-if="showAddForm"
            class="flex flex-wrap gap-1 items-center"
        >
            <input
                v-model="newAliasName"
                type="text"
                class="grow min-w-0 text-sm !min-h-3 !py-0.5"
                maxlength="45"
                :placeholder="i18n.aliasPlaceholder"
                ref="addInput"
                @keydown.enter.prevent="confirmAdd"
                @keydown.esc="cancelAdd"
            />
            <div class="flex gap-2">
                <select v-model="newAliasVisibility" class="text-sm !min-h-3 !py-0.5">
                    <option v-for="opt in visibilityOptions" :key="opt.value" :value="opt.value">
                        {{ opt.label }}
                    </option>
                </select>
                <div class="flex gap-1 flex-none">
                    <button
                        type="button"
                        class="px-3 py-2 rounded-lg bg-primary text-primary-content text-sm hover:opacity-80"
                        @click="confirmAdd"
                    >
                        <span>Add</span>
                    </button>
                    <button
                        type="button"
                        class="px-2 py-1 rounded-lg hover:bg-base-300 text-xs text-neutral-content"
                        @click="cancelAdd"
                    >
                        <i class="fa-regular fa-xmark" aria-hidden="true" />
                    </button>
                </div>
            </div>
        </div>

        <!-- Alias pills -->
        <div v-if="aliasesList.length > 0" class="flex flex-wrap gap-1">
            <alias-pill
                v-for="alias in aliasesList"
                :key="alias.id"
                :alias="alias"
                :visibility-options="visibilityOptions"
                :save-label="i18n.save"
                :delete-label="i18n.delete"
                :alias-name-label="i18n.aliasNameLabel"
                :visible-to-label="i18n.visibleToLabel"
                @update="updateAlias"
                @delete="deleteAlias"
            />
        </div>

        <!-- Quota pips & limit warning for non-premium campaigns -->
        <template v-if="aliasLimit !== null && aliasLimit !== undefined">
            <div v-if="!isAliasLimitReached" class="flex gap-0.5 items-center">
                <span
                    v-for="n in aliasLimit"
                    :key="n"
                    :class="n <= aliasesList.length ? 'bg-accent' : 'bg-base-300'"
                    class="h-1.5 w-4 rounded-full transition-colors"
                />
            </div>
            <div v-if="isAliasLimitReached" class="bg-amber-100 text-amber-700 border-amber-700 p-3 rounded-xl text-xs flex gap-1 ">
                <i class="fa-regular fa-warning text-base" aria-hidden="true"></i>
                <span v-html="i18n.aliasLimitReached"></span>
            </div>
        </template>

        <!-- Serialised aliases for form submission -->
        <input type="hidden" name="aliases" :value="JSON.stringify(aliasesList)" />
    </div>
</template>

<script setup lang="ts">
import { ref, computed, nextTick, onMounted } from 'vue'
import AliasPill from './AliasPill.vue'
import SimilarEntityAlert from './SimilarEntityAlert.vue'
import { useEntitySimilarity } from '../../composables/useEntitySimilarity.js'

type Alias = { id: number | string; name: string; visibility: string }

const props = defineProps<{
    label: string,
    placeholder?: string,
    modelValue?: string,
    endPoint?: string,
    entityId?: string,
    aliases?: string,
    aliasLimit?: number | null,
    upgradeUrl?: string,
    required?: boolean,
    i18n?: string,
}>()

const emit = defineEmits<{
    'update:modelValue': [value: string],
    'update:aliases': [aliases: Alias[]],
}>()

const inputId = `entity-name-${Math.random().toString(36).slice(2)}`

const defaultI18n: Record<string, string> = {
    addAlias: '+ Alias',
    aliasPlaceholder: 'Alias name',
    aliasNameLabel: 'Alias name',
    visibleToLabel: 'Visible to',
    duplicateWarning: 'Similar entities found:',
    save: 'Save',
    delete: 'Delete',
    aliasLimitReached: 'Alias limit reached.',
    upgrade: 'Upgrade',
    visibilityAll: 'All',
    visibilityMembers: 'Members',
    visibilityAdmin: 'Admins',
    visibilityAdminSelf: 'Me & Admins',
    visibilitySelf: 'Only me',
}

const i18n = computed(() => {
    const parsed: Record<string, string> = props.i18n ? JSON.parse(props.i18n) : {}
    return { ...defaultI18n, ...parsed }
})

const visibilityOptions = computed(() => [
    { value: 'all', label: i18n.value.visibilityAll },
    { value: 'members', label: i18n.value.visibilityMembers },
    { value: 'admin', label: i18n.value.visibilityAdmin },
    { value: 'admin-self', label: i18n.value.visibilityAdminSelf },
    { value: 'self', label: i18n.value.visibilitySelf },
])

// Whether alias management is surfaced at all (endPoint must be set for the name field check)
const aliasesEnabled = computed(() => props.aliases !== undefined)

// Name state
const name = ref(props.modelValue ?? '')

// Alias state
const aliasesList = ref<Alias[]>(props.aliases ? JSON.parse(props.aliases) : [])

// Add form state
const showAddForm = ref(false)
const newAliasName = ref('')
const newAliasVisibility = ref('all')
const addInput = ref<HTMLInputElement | null>(null)

let nextTempId = -1

const isAliasLimitReached = computed(() =>
    props.aliasLimit !== null &&
    props.aliasLimit !== undefined &&
    aliasesList.value.length >= (props.aliasLimit as number)
)

const addBtnClass = computed(() => {
    const base = 'text-link text-xs'
    return isAliasLimitReached.value
        ? `${base} opacity-40 cursor-not-allowed`
        : base
})

// Similarity check
const { similarEntities, setup: setupSimilarity, setName } = useEntitySimilarity()

onMounted(() => {
    if (props.endPoint) {
        setupSimilarity(props.endPoint, props.entityId ?? null)
    }
})

const onNameInput = (e: Event) => {
    const value = (e.target as HTMLInputElement).value
    name.value = value
    emit('update:modelValue', value)
    if (props.endPoint) {
        setName(value)
    }
}

// Add alias
const toggleAddForm = () => {
    if (isAliasLimitReached.value) {
        return
    }
    showAddForm.value = !showAddForm.value
    if (showAddForm.value) {
        newAliasName.value = ''
        newAliasVisibility.value = 'all'
        nextTick(() => addInput.value?.focus())
    }
}

const confirmAdd = () => {
    const trimmed = newAliasName.value.trim()
    if (!trimmed) {
        return
    }
    aliasesList.value = [
        ...aliasesList.value,
        { id: nextTempId--, name: trimmed, visibility: newAliasVisibility.value },
    ]
    emit('update:aliases', aliasesList.value)
    cancelAdd()
}

const cancelAdd = () => {
    showAddForm.value = false
    newAliasName.value = ''
}

// Edit alias (from popover)
const updateAlias = (updated: Alias) => {
    aliasesList.value = aliasesList.value.map(a => a.id === updated.id ? updated : a)
    emit('update:aliases', aliasesList.value)
}

// Delete alias
const deleteAlias = (alias: Alias) => {
    aliasesList.value = aliasesList.value.filter(a => a.id !== alias.id)
    emit('update:aliases', aliasesList.value)
}
</script>
