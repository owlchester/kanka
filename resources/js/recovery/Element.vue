<template>
    <div v-if="!model.is_hidden && !model.url" :class="modelClass()" @click="click">
        <div class="flex gap-4 items-center">
            <div class="flex-none">
                <input v-if="!model.url" type="checkbox" v-model="model.is_selected" @click="startBulking"/>
            </div>
            <div class="grow font-extrabold" v-html="model.name"></div>
            <div class="rounded px-2 py-1 text-sm bg-base-200" v-html="trans('model_' + model.type_id)"></div>
        </div>
        <hr />
        <div class="flex items-center">
            <div class="grow text-neutral-content">
                <span v-html="trans('deleted_at', [model.date, model.deleted_name])"></span>
            </div>
            <div v-if="!model.url" class="flex-none">
                <button :class="buttonClass()" @click="restoreElement()" v-html="trans('recover')" ></button>
            </div>
        </div>
    </div>

    <div v-if="!model.is_hidden && model.url" class="rounded shadow p-4 flex gap-2 items-center bg-base-200 hover:shadow-lg">
        <div class="flex-none">
            <i class="fa-solid text-green-500 fa-circle-check" aria-hidden="true" />
        </div>
        <div class="grow" v-html="trans('recovery_success', [model.url, model.name])"></div>
        <div class="rounded px-2 py-1 text-sm bg-base-200" v-html="trans('model_' + model.type_id)"></div>
    </div>

</template>

<script setup lang="ts">
import {ref, onMounted, watch, onBeforeMount} from 'vue'
import {matches} from "lodash";

const emit = defineEmits(['recover'])

const props = defineProps<{
    model: Object,
    i18n: Object
}>()

const click = () => {
    if (!props.model.url) {
        props.model.is_selected = !props.model.is_selected
    }
}

const modelClass = () => {
    let css = 'rounded shadow bg-base-100 flex flex-col gap-2 p-2 hover:shadow-lg'
    
    if (!props.model.url) {
        css = css + ' cursor-pointer'
    }

    if (!props.model.is_selected) {
        return css + '  '
    }

    return css + ' bg-base-300'
}

const trans = (key, replace = []) => {
    if (!props.i18n[key]) {
        console.error('Missing trans', key, props.i18n)
        return 'MISSING'
    }

    let translation = props.i18n[key]
    replace.forEach(f => {
        translation = translation.replace("placeholder", f)
    })

    return translation
}

const buttonClass = () => {
    let css = 'btn2 btn-default btn-sm'
    if (props.model.is_recovering) {
        css += ' loading btn-disabled'
    }
    return css
}

const restoreElement = () => {
    emit('recover', props.model)
}

</script>
