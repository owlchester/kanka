<template>
    <div v-if="stacked" class="stack inline-grid items-center align-items-end w-[47%] xs:w-[25%] sm:w-48"
         @pointerdown="lpStart" @pointerup="lpCancel" @pointermove="lpMove" @pointercancel="lpCancel"
         @contextmenu.prevent>
        <div class="entity overflow-hidden rounded shadow-xs hover:shadow-md aspect-square w-full flex flex-col bg-box" v-bind="dataAttributes">
            <a :href="entity.urls.show" :title="entity.name"
               class="block avatar grow relative cover-background overflow-hidden text-center text-link"
               :style="entityImage" @click.prevent="handleClick">
                <div v-if="entity.is_private && !selecting"
                     class="bubble-private absolute left-1.5 top-1.5 text-xs shadow-xs flex justify-center items-center aspect-square rounded-full w-6 h-6 bg-box opacity-80 text-base-content"
                     :title="i18n.is_private">
                    <i class="fa-regular fa-lock" :aria-label="i18n.is_private" />
                </div>
                <div v-else-if="selecting" :class="selectorClass">
                    <i v-if="entity.selected" class="fa-regular fa-check" aria-label="selected" />
                </div>
                <!-- Avatar bubbles for children -->
                <div v-if="nested && entity.children_preview?.length" class="absolute bottom-2 right-2 flex flex-row-reverse">
                    <div v-if="entity.children > 3"
                         class="w-7 h-7 rounded-full bg-primary border-1 border-box flex items-center justify-center text-primary-content font-bold ml-[-8px] z-0">
                        +{{ entity.children - 3 }}
                    </div>
                    <div v-for="(child, idx) in entity.children_preview.slice(0, 3)" :key="child.id"
                         class="w-7 h-7 rounded-full border-1 border-box flex items-center justify-center ml-[-8px] cover-background"
                         :style="childStyle(child, idx)"
                         :class="child.image ? '' : 'bg-base-200 text-base-content'"
                         :title="child.name">
                        <span v-if="!child.image">{{ initials(child.name) }}</span>
                    </div>
                </div>
            </a>
            <a :href="entity.urls.show" class="block text-center relative truncate h-12 p-4 text-link"
               data-toggle="tooltip-ajax" :data-id="entity.id" :data-url="entity.urls.tooltip"
               v-html="entity.name" @click.prevent="handleClick" />
        </div>
        <div v-for="s in Math.min(entity.children, 2)" :key="s"
             class="entity entity-stack bg-base-300 w-full overflow-hidden rounded aspect-square flex flex-col shadow-xs">
            <div class="block grow"></div>
            <div class="block h-12 p-4 bg-box"></div>
        </div>
    </div>
    <div v-else :class="entityClass" v-bind="dataAttributes"
         @pointerdown="lpStart" @pointerup="lpCancel" @pointermove="lpMove" @pointercancel="lpCancel"
         @contextmenu.prevent>
        <a :href="entity.urls.show" class="block avatar grow relative cover-background" :style="entityImage"
           :title="entity.name" @click.prevent="handleClick">
            <div v-if="entity.is_private && !selecting"
                 class="bubble-private absolute left-1.5 top-1.5 text-xs shadow-xs flex justify-center items-center aspect-square rounded-full w-6 h-6 bg-box opacity-80 text-base-content"
                 :title="i18n.is_private">
                <i class="fa-regular fa-lock" :aria-label="i18n.is_private" />
            </div>
            <div v-else-if="selecting" :class="selectorClass">
                <i v-if="entity.selected" class="fa-regular fa-check" aria-label="selected" />
            </div>
        </a>
        <a :href="entity.urls.show" class="block text-center relative truncate h-12 p-4 text-link"
           data-toggle="tooltip-ajax" :data-id="entity.id" :data-url="entity.urls.tooltip"
           v-html="entity.name" @click.prevent="handleClick" />
    </div>
</template>

<script setup lang="ts">
import { computed } from 'vue'
import { useLongPress } from './composables/useLongPress'

const props = defineProps<{
    entity: any
    selecting: boolean
    nested: boolean
    i18n: any
}>()

const emit = defineEmits<{
    navigate: [entityId: number, childrenUrl: string]
    startSelecting: [entityId: number]
}>()

let suppressNextClick = false

const { start: lpStart, cancel: lpCancel, move: lpMove } = useLongPress(() => {
    if (!props.selecting) {
        suppressNextClick = true
        emit('startSelecting', props.entity.id)
    }
})

const stacked = computed(() => props.nested && props.entity.children > 0)

const entityImage = computed(() => ({
    backgroundImage: `url('${props.entity.images.thumb}')`
}))

const entityClass = computed(() => {
    return 'entity overflow-hidden rounded shadow-xs hover:shadow-md w-[47%] xs:w-[25%] sm:w-48 aspect-square flex flex-col bg-box'
})

const selectorClass = computed(() => {
    const base = 'rounded-full opacity-80 h-6 w-6 absolute left-1.5 top-1.5 border border-primary flex items-center justify-center text-xl'
    return props.entity.selected
        ? base + ' bg-primary text-primary-content'
        : base + ' bg-base-100'
})

const dataAttributes = computed(() => {
    const attrs: Record<string, any> = {
        'data-entity': props.entity.id,
        'data-entity-type': props.entity.entityType?.code,
        'data-type': props.entity.type_slug || props.entity.type,
    }
    props.entity.attributes?.forEach((a: string) => {
        attrs[`data-${a}`] = true
    })
    return attrs
})

const initials = (name: string): string => {
    return name.split(' ').map(w => w[0]).join('').slice(0, 2).toUpperCase()
}

const childStyle = (child: any, idx: number) => {
    const style: Record<string, any> = { zIndex: 3 - idx }
    if (child.image) {
        style.backgroundImage = `url('${child.image}')`
    }
    return style
}

const handleClick = (event: Event) => {
    if (suppressNextClick) {
        event.preventDefault()
        suppressNextClick = false
        return
    }
    if (props.selecting) {
        props.entity.selected = !props.entity.selected
    } else if (props.nested && props.entity.children > 0) {
        emit('navigate', props.entity.id, props.entity.urls.children_api)
    } else if (event.target && (event.target as HTMLAnchorElement).href) {
        window.location.href = (event.target as HTMLAnchorElement).href
    }
}
</script>
