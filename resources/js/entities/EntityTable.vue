<template>
    <div class="w-full overflow-x-auto">
        <table class="table table-striped table-entities mb-0 w-full"
               :role="nested ? 'treegrid' : 'grid'">
            <thead>
                <tr>
                    <th v-if="selecting" class="w-8">
                        <input type="checkbox" :checked="allSelected" @change="$emit('toggleAll')" />
                    </th>
                    <th v-if="nested && entityType?.is_nested" class="w-8"></th>
                    <th v-for="col in visibleColumns" :key="col.key"
                        :class="headerClass(col)">
                        <button v-if="col.sortable" @click="$emit('orderBy', col.key, col.sortKey)"
                                class="text-link flex items-center gap-1">
                            <span v-html="col.label"></span>
                            <i v-if="isOrdering(col.sortKey || col.key)" :class="orderByIcon(col.sortKey || col.key)"></i>
                            <i v-else class="fa-regular fa-sort text-neutral-content" aria-hidden="true"></i>
                        </button>
                        <span v-else v-html="col.label"></span>
                    </th>
                    <th class="w-10"></th>
                </tr>
            </thead>
            <tbody>
                <template v-for="(entity, idx) in entities" :key="entity.id">
                    <EntityRow
                        :entity="entity"
                        :visible-columns="visibleColumns"
                        :selecting="selecting"
                        :nested="nested"
                        :i18n="i18n"
                        :features="features"
                        :show-expand-column="nested && entityType?.is_nested"
                    />
                    <!-- Ad row -->
                    <tr v-if="ads.enabled && (idx + 1) % ads.frequency === 0" class="adrow">
                        <td :colspan="totalColumns" class="adrow" v-html="adContent"></td>
                    </tr>
                </template>
                <tr v-if="entities.length === 0">
                    <td :colspan="totalColumns" class="italic" v-html="i18n.noResults"></td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script setup lang="ts">
import { computed } from 'vue'
import EntityRow from './EntityRow.vue'

const props = defineProps<{
    entities: any[]
    visibleColumns: any[]
    selecting: boolean
    allSelected: boolean
    nested: boolean
    i18n: any
    entityType: any
    features: any
    ads: { enabled: boolean; frequency: number }
    isOrdering: (field: string) => boolean
    orderByIcon: (field: string) => string
    adContent?: string
}>()

defineEmits<{
    orderBy: [field: string, sortKey?: string | null]
    toggleAll: []
}>()

const totalColumns = computed(() => {
    let count = props.visibleColumns.length + 1 // +1 for actions column
    if (props.selecting) count++
    if (props.nested && props.entityType?.is_nested) count++
    return count
})

const headerClass = (col: any): string => {
    if (col.type === 'avatar') return 'w-10'
    if (col.type === 'name') return 'dg-name'
    if (col.type === 'private') return 'w-10 text-center'
    if (col.type === 'icon') return 'w-10 text-center'
    return 'hidden lg:table-cell'
}
</script>
