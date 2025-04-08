<template>
    <div v-if="stacked()" class="stack inline-grid items-center align-items-end w-[47%] xs:w-[25%] sm:w-48" v-bind:data-stack="entity.children">
        <div
            class="entity overflow-hidden rounded shadow-xs hover:shadow aspect-square w-full flex flex-col bg-box"
            v-bind="dataAttributes()">
            <a
                :href="entity.urls.children"
                :title="entity.name"
                class="block avatar grow relative cover-background overflow-hidden text-center"
                v-bind:style="entityImage()"
                @click.prevent="selectingAction">
                <div
                    v-if="entity.is_private && !selecting"
                    class="bubble-private absolute left-1.5 top-1.5 text-xs shadow-xs flex justify-center align-items-center items-center aspect-square rounded-full w-6 h-6 bg-box opacity-80 text-base-content" :title="i18n.is_private">
                        <i class="fa-regular fa-lock"  v-bind:aria-label="i18n.is_private" />
                </div>
                <div v-else-if="selecting" :class="selectorClass()">
                    <i v-if="entity.selected" class="fa-regular fa-check" aria-label="selected" />
                </div>
            </a>
            <a
                :href="entity.urls.show"
                class="block text-center relative truncate h-12 p-4"
                data-toggle="tooltip-ajax"
                v-bind:data-id="entity.id"
                v-bind:data-url="entity.urls.tooltip"
                v-html="entity.name"
                @click.prevent="selectingAction">
            </a>
        </div>
        <div
            v-for="s in entity.children"
            class="entity entity-stack bg-base-300 w-full overflow-hidden rounded aspect-square flex flex-col shadow-xs" title="{{ __('datagrids.tooltips.nested') }}" v-bind:data-stack="s">
            <div class="block grow"></div>
            <div class="block h-12 p-4 bg-box"></div>
        </div>
    </div>
    <div v-else
         :class="entityClass()"
         v-bind="dataAttributes()">
        <a
            :href="entity.urls.show"
            class="block avatar grow relative cover-background"
            v-bind:style="entityImage()"
            :title="entity.name"
            @click.prevent="selectingAction">
            <div
                v-if="entity.is_private && !selecting"
                class="bubble-private absolute left-1.5 top-1.5 text-xs shadow-xs flex justify-center align-items-center items-center aspect-square rounded-full w-6 h-6 bg-box opacity-80 text-base-content" :title="i18n.is_private">
                <i class="fa-regular fa-lock" v-bind:aria-label="i18n.is_private" />
            </div>
            <div v-else-if="selecting" :class="selectorClass()">
                <i v-if="entity.selected" class="fa-regular fa-check" aria-label="selected" />
            </div>
        </a>
        <a
            :href="entity.urls.show"
            class="block text-center relative truncate h-12 p-4"
            data-toggle="tooltip-ajax"
            v-bind:data-id="entity.id"
            v-bind:data-url="entity.urls.tooltip"
            v-html="entity.name"
            @click.prevent="selectingAction">
        </a>
    </div>
</template>

<script setup lang="ts">
import {ref, onMounted, onBeforeUnmount} from 'vue'

const props = defineProps<{
    entity: object,
    isParent: boolean,
    selecting: boolean,
    i18n: object,
}>()

const entityClass = () => {
    let css = 'entity overflow-hidden rounded shadow-xs hover:shadow w-[47%] xs:w-[25%] sm:w-48 aspect-square flex flex-col bg-box';

    if (props.isParent) {
        css += 'shadow-lg stacking-parent font-bold'
    }
    return css;
}

const entityImage = () => {
    return {
        backgroundImage: "url('" + props.entity.images.thumb + "')"
    }
}

const dataAttributes = () => {
    let attributes = {};

    attributes['data-entity'] = props.entity.id
    attributes['data-entity-type'] = props.entity.entityType.code
    attributes['data-type'] = props.entity.type
    // console.info('entity', props.entity)
    props.entity.attributes.forEach(a => {
        attributes[`data-${a}`] = true
    })
    return attributes
}

const stacked = () => {
    return props.entity.children > 0;
}

const selectingAction = (event: Event) => {
    if (props.selecting) {
        toggleSelect();
    } else {
        window.location.href = (event.target as HTMLAnchorElement).href;
    }
};


const toggleSelect = () => {
    props.entity.selected = !props.entity.selected;
}

const selectorClass = () => {
    let css = 'rounded rounded-full opacity-80 h-6 w-6 absolute left-1.5 top-1.5 border border-primary flex items-center justify-center text-xl'

    if (props.entity.selected) {
        return css + ' bg-primary text-primary-content'
    }
    return css + ' bg-base-100 '
}

</script>
