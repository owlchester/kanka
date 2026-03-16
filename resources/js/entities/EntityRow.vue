<template>
    <tr :data-id="entity.id" v-bind="dataAttributes">
        <!-- Checkbox -->
        <td v-if="selecting" class="w-8">
            <input type="checkbox" :checked="entity.selected" @change="entity.selected = !entity.selected" />
        </td>

        <!-- Expand/collapse arrow (nested mode only) -->
        <td v-if="showExpandColumn" class="w-8 text-center">
            <button v-if="entity.children > 0 && depth < maxDepth" @click="toggleExpand" class="text-link hover:text-primary">
                <i v-if="loadingChildren" class="fa-solid fa-spinner fa-spin" aria-hidden="true"></i>
                <i v-else-if="expanded" class="fa-regular fa-angle-down" aria-hidden="true"></i>
                <i v-else class="fa-regular fa-angle-right" aria-hidden="true"></i>
            </button>
            <a v-else-if="entity.children > 0" :href="entity.urls.children" class="text-link text-xs">
                <i class="fa-regular fa-arrow-right" aria-hidden="true"></i>
            </a>
        </td>

        <!-- Dynamic columns -->
        <td v-for="col in visibleColumns" :key="col.key" :class="cellClass(col)">
            <!-- Avatar -->
            <template v-if="col.type === 'avatar'">
                <a :href="entity.urls.show" class="block avatar w-8 h-8 rounded-full cover-background"
                   :style="{ backgroundImage: `url('${entity.images.thumb}')` }" :title="entity.name" />
            </template>

            <!-- Name -->
            <template v-else-if="col.type === 'name'">
                <a :href="entity.urls.show" class="text-link truncate"
                   data-toggle="tooltip-ajax" :data-id="entity.id" :data-url="entity.urls.tooltip">
                    <span v-if="depth > 0" class="text-neutral-content mr-1" v-html="indentPrefix"></span>
                    <span v-html="entity.name"></span>
                </a>
            </template>

            <!-- Text -->
            <template v-else-if="col.type === 'text'">
                <span class="truncate" v-html="entity[col.key]"></span>
            </template>

            <!-- Icon (boolean status) -->
            <template v-else-if="col.type === 'icon'">
                <i v-if="entity[col.key]" :class="col.icon" :title="col.tooltip" data-toggle="tooltip" aria-hidden="true"></i>
            </template>

            <!-- Single entity link -->
            <template v-else-if="col.type === 'entity'">
                <a v-if="entityFieldValue(col.key)" :href="entityFieldValue(col.key).url" class="text-link truncate" v-html="entityFieldValue(col.key).name"></a>
            </template>

            <!-- Multiple entity links -->
            <template v-else-if="col.type === 'entities'">
                <span v-if="entity[col.key]?.length">
                    <template v-for="(item, idx) in entity[col.key]" :key="item.id">
                        <a :href="item.url" class="text-link" v-html="item.name"></a>
                        <span v-if="idx < entity[col.key].length - 1">, </span>
                    </template>
                </span>
            </template>

            <!-- Tags -->
            <template v-else-if="col.type === 'tags'">
                <div class="flex items-center gap-1 flex-wrap">
                    <a v-for="tag in entity.tags" :key="tag.id" :href="tag.urls.show"
                       :class="'tag rounded-full text-xs badge cursor-pointer hover:shadow-xs ' + tag.colour"
                       v-html="tag.shortname" :title="tag.name" />
                </div>
            </template>

            <!-- Private lock -->
            <template v-else-if="col.type === 'private'">
                <i v-if="entity.is_private" class="fa-regular fa-lock" :aria-label="i18n.is_private" :title="i18n.is_private" />
            </template>

            <!-- Count -->
            <template v-else-if="col.type === 'count'">
                <span v-html="entity[col.key]"></span>
            </template>

            <!-- Calendar date -->
            <template v-else-if="col.type === 'calendar_date'">
                <a v-if="entity.calendar_date" :href="entity.calendar_date.url" class="text-link" v-html="entity.calendar_date.date"></a>
            </template>
        </td>
    </tr>

    <!-- Expanded children rows -->
    <template v-if="expanded && children.length">
        <EntityRow
            v-for="child in children"
            :key="child.id"
            :entity="child"
            :visible-columns="visibleColumns"
            :selecting="selecting"
            :nested="nested"
            :i18n="i18n"
            :depth="depth + 1"
            :max-depth="maxDepth"
            :show-expand-column="showExpandColumn"
        />
    </template>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue'

const props = withDefaults(defineProps<{
    entity: any
    visibleColumns: any[]
    selecting: boolean
    nested: boolean
    i18n: any
    depth?: number
    maxDepth?: number
    showExpandColumn: boolean
}>(), {
    depth: 0,
    maxDepth: 3,
})

const expanded = ref(false)
const children = ref<any[]>([])
const loadingChildren = ref(false)

const dataAttributes = computed(() => {
    const attrs: Record<string, any> = {
        'data-entity-id': props.entity.id,
        'data-entity-type': props.entity.entityType?.code,
    }
    if (props.nested && props.depth > 0) {
        attrs['aria-level'] = props.depth + 1
    }
    if (props.entity.children > 0 && props.nested) {
        attrs['aria-expanded'] = expanded.value
    }
    return attrs
})

const indentPrefix = computed(() => {
    if (props.depth <= 0) return ''
    let prefix = ''
    for (let i = 0; i < props.depth; i++) {
        prefix += '&nbsp;&nbsp;'
    }
    return prefix + '└'
})

const cellClass = (col: any): string => {
    if (col.type === 'avatar') return 'w-10'
    if (col.type === 'name') return 'truncate max-w-fit'
    if (col.type === 'private') return 'w-10 text-center'
    if (col.type === 'icon') return 'w-10 text-center'
    return 'hidden lg:table-cell truncate max-w-fit'
}

const entityFieldValue = (key: string) => {
    // For 'parent' column, the API returns 'parent_entity'
    if (key === 'parent') {
        return props.entity.parent_entity || null
    }
    return props.entity[key] || null
}

const toggleExpand = async () => {
    if (expanded.value) {
        expanded.value = false
        return
    }

    loadingChildren.value = true
    try {
        const response = await fetch(props.entity.urls.children_api)
        if (!response.ok) {
            return
        }
        const data = await response.json()
        children.value = data.entities?.data ?? []
        expanded.value = true
    } catch {
        // Network error — silently fail, user can retry
    } finally {
        loadingChildren.value = false
    }
}
</script>
