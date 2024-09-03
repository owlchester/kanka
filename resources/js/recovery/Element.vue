<template>
    <div v-if="!file.is_hidden && !file.url" :class="fileClass()" @click="click">
        <div class="flex gap-4 items-center">
            <div class="flex-none">
                <input v-if="!file.url" type="checkbox" v-model="file.is_selected" @click="startBulking"/>
            </div>
            <div class="grow font-extrabold" v-html="file.name"></div>
            <div class="rounded px-2 py-1 text-sm bg-base-200" v-html="trans(file.type_id)"></div>
        </div>
        <hr />
        <div class="flex items-center">
            <div class="grow text-neutral-content">
                <span v-html="trans('deleted_at', [file.date, file.deleted_name])"></span>
            </div>
            <div v-if="!file.url" class="flex-none">
                <button :class="buttonClass()" @click="restoreElement()" v-html="trans('recover')" ></button>
            </div>
        </div>
    </div>

    <div v-if="!file.is_hidden && file.url" class="rounded shadow p-4 flex gap-2 items-center bg-base-200 hover:shadow-lg">
        <div class="flex-none">
            <i class="fa-solid text-green-500 fa-circle-check" aria-hidden="true" />
        </div>
        <div class="grow" v-html="trans('recovery_success', [file.url, file.name])"></div>
        <div class="rounded px-2 py-1 text-sm bg-base-200" v-html="trans(file.type_id)"></div> <!-- px and py might need tweaking -->
    </div>

</template>

<script setup lang="ts">
import {ref, onMounted, watch, onBeforeMount} from 'vue'
import {matches} from "lodash";

const emit = defineEmits(['recover'])

const props = defineProps<{
    file: Object,
    isBulking: Boolean,
    i18n: Object
}>()

const click = () => {
    if (!props.file.url) {
        props.file.is_selected = !props.file.is_selected
    }
}

const fileClass = () => {
    let css = 'rounded shadow bg-base-100 flex flex-col gap-2 p-2 hover:shadow-lg'
    
    if (!props.file.url) {
        css = css + ' cursor-pointer'
    }

    if (!props.file.is_selected) {
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
    if (props.file.is_recovering) {
        css += ' loading btn-disabled btn-sm'
    }
    return css
}

const restoreElement = () => {
    emit('recover', props.file)
}

</script>
