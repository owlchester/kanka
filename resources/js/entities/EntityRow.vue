<template>
    <tr :data-id="entity.id" v-bind="dataAttributes"
        @pointerdown="lpStart" @pointerup="lpCancel" @pointermove="lpMove" @pointercancel="lpCancel"
        @contextmenu="handleContextMenu" @click.capture="handleRowClick">
        <!-- Checkbox -->
        <td class="w-8" :class="selecting ? '' : 'hidden sm:table-cell'">
            <input
                type="checkbox"
                :checked="entity.selected"
                @change="handleCheckboxChange"
            />
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

            <!-- Icon (boolean or mapped status) -->
            <template v-else-if="col.type === 'icon'">
                <i v-if="entity[col.key]?.icon" :class="entity[col.key].icon" v-tippy="entity[col.key].tooltip" aria-hidden="true"></i>
                <i v-else-if="col.icons && col.icons[entity[col.key]]" :class="col.icons[entity[col.key]].icon" v-tippy="col.icons[entity[col.key]].tooltip" aria-hidden="true"></i>
                <i v-else-if="!col.icons && entity[col.key]" :class="col.icon" v-tippy="col.tooltip" aria-hidden="true"></i>
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
                       :style="tag.colour_style || ''"
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

            <!-- Map explore link -->
            <template v-else-if="col.type === 'explore'">
                <a v-if="entity.explore?.url" :href="entity.explore.url" target="_blank" class="text-link" :title="col.tooltip">
                    <i class="fa-regular fa-map" aria-hidden="true"></i>
                </a>
                <i v-else-if="entity.explore?.status === 'error'" class="fa-regular fa-exclamation-triangle text-warning" :title="col.tooltip" aria-hidden="true"></i>
                <i v-else-if="entity.explore?.status === 'running'" class="fa-solid fa-spinner fa-spin" aria-hidden="true"></i>
            </template>

            <!-- Whiteboard draw link -->
            <template v-else-if="col.type === 'draw'">
                <a v-if="entity.draw?.url" :href="entity.draw.url" target="_blank" class="text-link" :title="col.tooltip">
                    <i class="fa-regular fa-chalkboard" aria-hidden="true"></i>
                </a>
            </template>
        </td>

        <!-- Row actions -->
        <td class="w-10 text-center">
            <div class="dropdown">
                <button class="cursor-pointer rounded-full w-8 h-8 aspect-square hover:bg-base-200 flex items-center justify-center"
                        :ref="el => actionsBtnRef = el"
                        data-tree="escape">
                    <i class="fa-regular fa-ellipsis-v" data-tree="escape" aria-hidden="true"></i>
                </button>
                <div ref="actionsMenuRef" class="flex flex-col gap-1" >
                    <a :href="entity.urls.relations" class="flex items-center gap-2 px-2 py-1.5 hover:bg-base-200 rounded-xl text-xs text-base-content">
                        <i class="fa-regular fa-circle-nodes w-5 text-center text-neutral-content" aria-hidden="true"></i>
                        <span v-html="i18n.relations"></span>
                    </a>
                    <a v-if="features?.inventories" :href="entity.urls.inventory" class="flex items-center gap-2 px-2 py-1.5 hover:bg-base-200 rounded-xl text-xs text-base-content">
                        <i class="fa-regular fa-gem w-5 text-center text-neutral-content" aria-hidden="true"></i>
                        <span v-html="i18n.inventory"></span>
                    </a>
                    <template v-if="entity.can_edit">
                        <hr class="m-0" />
                        <a :href="entity.urls.edit" class="flex items-center gap-2 px-2 py-1.5 hover:bg-base-200 rounded-xl text-xs text-base-content">
                            <i class="fa-regular fa-pencil w-5 text-center text-neutral-content" aria-hidden="true"></i>
                            <span v-html="i18n.edit"></span>
                        </a>
                    </template>
                </div>
            </div>
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
            :features="features"
            :depth="depth + 1"
            :max-depth="maxDepth"
            :show-expand-column="showExpandColumn"
            :on-toggle-child="onToggleChild"
            @start-selecting="emit('startSelecting', $event)"
        />
        <tr v-if="hasMoreChildren">
            <td :colspan="loadMoreColspan" class="text-center py-1">
                <button
                    class="btn2 btn-sm btn-ghost text-xs"
                    :disabled="loadingMoreChildren"
                    @click="loadMoreChildren"
                >
                    <i v-if="loadingMoreChildren" class="fa-solid fa-spinner fa-spin" aria-hidden="true"></i>
                    <span v-html="i18n.loadMore || 'Load more'"></span>
                </button>
            </td>
        </tr>
    </template>
</template>

<script setup lang="ts">
import { ref, computed, watch, onMounted, onBeforeUnmount } from 'vue'
import tippy from 'tippy.js'
import { useLongPress } from './composables/useLongPress'

const emit = defineEmits<{
    startSelecting: [entityId: number]
}>()

const props = withDefaults(defineProps<{
    entity: any
    visibleColumns: any[]
    selecting: boolean
    nested: boolean
    i18n: any
    features: any
    depth?: number
    maxDepth?: number
    showExpandColumn: boolean
    onToggleChild?: (id: number) => void
}>(), {
    depth: 0,
    maxDepth: 3,
})

const expanded = ref(false)
const children = ref<any[]>([])
const loadingChildren = ref(false)
const loadingMoreChildren = ref(false)
const childrenMeta = ref<{ current_page: number; last_page: number } | null>(null)

const actionsBtnRef = ref<HTMLElement | null>(null)
const actionsMenuRef = ref<HTMLElement | null>(null)
let actionsInstance: any = null

onMounted(() => {
    if (actionsBtnRef.value && actionsMenuRef.value) {
        actionsMenuRef.value.style.display = ''
        actionsInstance = tippy(actionsBtnRef.value, {
            content: actionsMenuRef.value,
            theme: 'kanka-dropdown',
            placement: 'bottom-end',
            interactive: true,
            trigger: 'click',
            allowHTML: true,
            arrow: true,
            zIndex: 890,
        })
    }
})

onBeforeUnmount(() => {
    actionsInstance?.destroy()
})

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
    if (col.type === 'explore') return 'w-10 text-center'
    if (col.type === 'draw') return 'w-10 text-center'
    return 'hidden lg:table-cell truncate max-w-fit'
}

const entityFieldValue = (key: string) => {
    // For 'parent' column, the API returns 'parent_entity'
    if (key === 'parent') {
        return props.entity.parent_entity || null
    }
    return props.entity[key] || null
}

const handleCheckboxChange = () => {
    if (!props.selecting) {
        if (props.depth > 0) {
            props.entity.selected = true
        }
        emit('startSelecting', props.entity.id)
        return
    }
    props.entity.selected = !props.entity.selected
    if (props.depth > 0) {
        props.onToggleChild?.(props.entity.id)
    }
}

watch(() => props.selecting, (newVal) => {
    if (!newVal) {
        children.value.forEach(c => { c.selected = false })
    }
})

let suppressNextClick = false
let lastPointerType = 'mouse'

const handleContextMenu = (e: MouseEvent) => {
    if (lastPointerType !== 'mouse') {
        e.preventDefault()
    }
}

const { start: lpStartInner, cancel: lpCancel, move: lpMove } = useLongPress(() => {
    if (!props.selecting) {
        suppressNextClick = true
        emit('startSelecting', props.entity.id)
    }
})

const lpStart = (e: PointerEvent) => {
    lastPointerType = e.pointerType
    lpStartInner(e)
}

const handleRowClick = (event: MouseEvent) => {
    if (suppressNextClick) {
        event.preventDefault()
        event.stopPropagation()
        suppressNextClick = false
        return
    }
    if (props.selecting) {
        if ((event.target as HTMLElement).closest('input[type="checkbox"]')) {
            return
        }
        event.preventDefault()
        event.stopPropagation()
        props.entity.selected = !props.entity.selected
        if (props.depth > 0) {
            props.onToggleChild?.(props.entity.id)
        }
    }
}

const hasMoreChildren = computed(() => {
    return childrenMeta.value !== null && childrenMeta.value.current_page < childrenMeta.value.last_page
})

const loadMoreColspan = computed(() => {
    let count = props.visibleColumns.length + 1 // +1 for actions column
    count++ // checkbox column
    if (props.showExpandColumn) {
        count++
    }
    return count
})

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
        childrenMeta.value = data.entities?.meta ?? null
        expanded.value = true
    } catch {
        // Network error — silently fail, user can retry
    } finally {
        loadingChildren.value = false
    }
}

const loadMoreChildren = async () => {
    if (!childrenMeta.value || loadingMoreChildren.value) {
        return
    }
    loadingMoreChildren.value = true
    try {
        const url = new URL(props.entity.urls.children_api, window.location.origin)
        url.searchParams.set('page', String(childrenMeta.value.current_page + 1))
        const response = await fetch(url.toString())
        if (!response.ok) {
            return
        }
        const data = await response.json()
        children.value = [...children.value, ...(data.entities?.data ?? [])]
        childrenMeta.value = data.entities?.meta ?? null
    } catch {
        // Network error — silently fail, user can retry
    } finally {
        loadingMoreChildren.value = false
    }
}
</script>
