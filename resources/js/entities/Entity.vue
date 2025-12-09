<template>
    <div v-if="isGrid() && stacked()" class="stack inline-grid items-center align-items-end w-[47%] xs:w-[25%] sm:w-48" v-bind:data-stack="entity.children">
        <div
            class="entity overflow-hidden rounded shadow-xs hover:shadow-md aspect-square w-full flex flex-col bg-box"
            v-bind="dataAttributes()">
            <a
                :href="entity.urls.children"
                :title="entity.name"
                class="block avatar grow relative cover-background overflow-hidden text-center text-link"
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
                class="block text-center relative truncate h-12 p-4 text-link"
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
    <div v-else-if="isGrid()"
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
            class="block text-center relative truncate h-12 p-4 text-link"
            data-toggle="tooltip-ajax"
            v-bind:data-id="entity.id"
            v-bind:data-url="entity.urls.tooltip"
            v-html="entity.name"
            @click.prevent="selectingAction">
        </a>
    </div>
    <div v-else
         :class="rowClass()"
         v-bind="dataAttributes()" @click="selectingAction">
        <div class="flex items-center gap-4">
            <div v-if="selecting"
                 class="w-5 h-5 cursor-pointer border rounded-full text-center ">
                <i v-if="entity.selected" class="fa-regular fa-check" aria-label="selected" />

            </div>

            <a
                :href="entity.urls.show"
                class="block avatar w-8 h-8 rounded-full relative cover-background"
                v-bind:style="entityImage()"
                :title="entity.name"
                @click.prevent="selectingAction">

            </a>
            <a
                :href="entity.urls.show"
                class="truncate lg:w-40 text-link"
                data-toggle="tooltip-ajax"
                v-bind:data-id="entity.id"
                v-bind:data-url="entity.urls.tooltip"
                v-html="entity.name"
                @click.prevent="selectingAction">
            </a>
            <div class="text-neutral-content lg:w-40 truncate">
                <span v-html="entity.type" />
            </div>
        </div>
        <div class="flex items-center gap-4 justify-between">
            <div class="flex items-center gap-1">
                <a v-for="tag in entity.tags" :href="tag.urls.show" :class="tagClass(tag)" v-html="tag.shortname" :title="tag.name" />
            </div>

            <i class="fa-regular fa-lock" v-if="entity.is_private" v-bind:aria-label="i18n.is_private" :title="i18n.is_private" />
        </div>
    </div>
    <div
        v-if="notFlatTable() && showChildren()"
        @click="loadChildren()"
        :title="entity.name"
        class="flex items-center justify-center gap-2 cursor-pointer text-xs p-0.5 hover:bg-base-200 rounded-xl"
        aria-label="Show children">
        <i class="fa-regular fa-angles-down" aria-hidden="true" />
        <span v-html="entity.children" />
    </div>
    <span v-if="loadingChildren" class="text-center">
        <i class="fa-solid fa-spinner fa-spin" aria-label="Loading"></i>
    </span>
    <div class="flex flex-col gap-1 pl-2" v-if="notFlatTable() && children">
        <Entity
            v-for="child in children"
            :key="child.id"
            :entity="child"
            :is-parent="false"
            :i18n="i18n"
            :selecting="selecting"
            :layout="layout"
            :nesting="nesting"
            ></Entity>
    </div>
</template>

<script setup lang="ts">
import {ref, onMounted, onBeforeUnmount} from 'vue'

const loadingChildren = ref(false)
const children = ref(null)

const props = defineProps<{
    entity: object,
    isParent: boolean,
    selecting: boolean,
    i18n: object,
    layout: string,
    nesting: boolean,
}>()

const entityClass = () => {
    let css = 'entity overflow-hidden rounded shadow-xs hover:shadow-md w-[47%] xs:w-[25%] sm:w-48 aspect-square flex flex-col bg-box';

    if (props.isParent) {
        css += 'shadow-lg stacking-parent font-bold'
    }
    return css;
}
const rowClass = () => {
    let css = 'rounded-xl flex bg-base-100 shadow-xs items-center gap-4 py-2 px-4 overflow-hidden justify-between';

    if (props.isParent) {
        css += ' shadow-lg stacking-parent'
    }
    if (props.selecting) {
        css += ' cursor-pointer';
    }
    return css;
}

const entityImage = () => {
    return {
        backgroundImage: "url('" + props.entity.images.thumb + "')"
    }
}

const notFlatTable = () => {
    // If in table view and not nesting (flat), don't show children
    if (!isGrid() && !props.nesting) {
        return false;
    }
    return true;
}

const showChildren = () => {
    return props.entity.children && !isGrid() && !loadingChildren.value && !children.value
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
    } else if (event.target && (event.target as HTMLAnchorElement).href) {
        // If the target is an anchor element, go to it
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

const loadChildren = () => {
    loadingChildren.value = true;
    fetch(props.entity.urls.children_api)
        .then(response => response.json())
        .then(response => {
            importChildren(response)
            loadingChildren.value = false;
        });
}

const importChildren = (response: any) => {
    //console.log('children', response.entities.data);
    children.value = [];
    response.entities.data.forEach(a => {
        children.value.push(a)
    })
}

const tagClass = (tag: any) => {
    return ' tag rounded-full text-xs flex items-center justify-center badge cursor-pointer hover:shadow-xs ' + tag.colour
}

const isGrid = () =>  {
    return props.layout === 'grid';
}

</script>
