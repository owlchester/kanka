<template>
    <div class="flex flex-col gap-3 p-1 min-w-56">
        <div class="flex flex-col gap-3 lg:hidden">
            <div v-if="entityType.is_nested && !criteriaActive && !ordering.ordering.value" class="flex rounded-lg bg-base-200 p-0.5 gap-0.5">
                <button type="button" class="flex min-h-11 flex-1 items-center justify-center gap-2 rounded-md px-2 text-sm" :class="nesting.nested.value ? 'bg-base-100 text-base-content shadow-xs' : 'text-neutral-content'" :aria-pressed="nesting.nested.value" @click="$emit('nest', true)">
                    <i class="fa-regular fa-layer-group" aria-hidden="true"></i><span v-html="i18n.nestShort"></span>
                </button>
                <button type="button" class="flex min-h-11 flex-1 items-center justify-center gap-2 rounded-md px-2 text-sm" :class="!nesting.nested.value ? 'bg-base-100 text-base-content shadow-xs' : 'text-neutral-content'" :aria-pressed="!nesting.nested.value" @click="$emit('nest', false)">
                    <i class="fa-regular fa-boxes-stacked" aria-hidden="true"></i><span v-html="i18n.flattenShort"></span>
                </button>
            </div>
            <div v-if="entityType.has_table && !ordering.ordering.value" class="flex rounded-lg bg-base-200 p-0.5 gap-0.5">
                <button type="button" class="flex min-h-11 flex-1 items-center justify-center gap-2 rounded-md px-2 text-sm" :class="layout.isGrid() ? 'bg-base-100 text-base-content shadow-xs' : 'text-neutral-content'" :aria-pressed="layout.isGrid()" @click="$emit('layout', true)">
                    <i class="fa-regular fa-grid-2" aria-hidden="true"></i><span v-html="i18n.gridShort"></span>
                </button>
                <button type="button" class="flex min-h-11 flex-1 items-center justify-center gap-2 rounded-md px-2 text-sm" :class="!layout.isGrid() ? 'bg-base-100 text-base-content shadow-xs' : 'text-neutral-content'" :aria-pressed="!layout.isGrid()" @click="$emit('layout', false)">
                    <i class="fa-regular fa-list-ul" aria-hidden="true"></i><span v-html="i18n.listShort"></span>
                </button>
            </div>
            <hr v-if="(entityType.is_nested || entityType.has_table) && !ordering.ordering.value" class="border-base-300 -mx-1" />
        </div>
        <div>
            <div class="text-xs uppercase tracking-wide text-neutral-content px-1 mb-1.5" v-html="i18n.perPage"></div>
            <div class="flex flex-wrap gap-1.5">
                <button v-for="n in perPage.perPageOptions.value" :key="n" type="button" @click="$emit('perPage', n)" class="px-3 py-1 rounded-md text-xs border transition-all max-md:min-h-11" :class="[perPage.perPage.value === n ? 'bg-primary text-primary-content border-primary font-semibold' : 'bg-base-200 border-base-300 text-base-content hover:border-primary', perPage.isSubscriberOnly(n) && !perPage.isSubscriber.value ? 'opacity-60' : '']">
                    {{ n }}<i v-if="perPage.isSubscriberOnly(n) && !perPage.isSubscriber.value" class="fa-regular fa-gem ml-1" aria-hidden="true"></i>
                </button>
            </div>
        </div>
        <div v-if="!layout.isGrid() && entityType.has_table && toggleableColumns.length">
            <hr class="border-base-300 -mx-1 mb-3" />
            <div class="text-xs uppercase tracking-wide text-neutral-content px-1 mb-1.5" v-html="i18n.columns"></div>
            <div class="flex flex-col gap-0.5">
                <button v-for="col in toggleableColumns" :key="col.key" type="button" class="px-2 py-1.5 hover:bg-base-200 rounded-lg flex items-center justify-between gap-2 text-xs cursor-pointer text-base-content max-md:min-h-11" :class="columns.isColumnVisible(col.key) ? 'text-primary' : ''" :aria-pressed="columns.isColumnVisible(col.key)" @click="columns.toggleColumn(col.key)">
                    <span v-html="col.label"></span><i :class="columns.isColumnVisible(col.key) ? 'fa-regular fa-check text-primary' : 'fa-regular fa-circle text-neutral-content'" aria-hidden="true"></i>
                </button>
            </div>
            <button type="button" @click="columns.resetToDefaults()" class="mt-1.5 px-2 py-1.5 hover:bg-base-200 rounded-lg flex items-center gap-2 text-xs text-base-content w-full max-md:min-h-11">
                <i class="fa-regular fa-rotate-left" aria-hidden="true"></i><span v-html="i18n.resetDefaults"></span>
            </button>
        </div>
    </div>
</template>

<script setup lang="ts">
defineProps<{
    entityType: any
    criteriaActive: boolean
    i18n: any
    ordering: any
    nesting: any
    layout: any
    columns: any
    perPage: any
    toggleableColumns: any[]
}>()

defineEmits<{
    nest: [nested: boolean]
    layout: [grid: boolean]
    perPage: [count: number]
}>()
</script>
