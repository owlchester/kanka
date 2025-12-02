<template>
    <div :class="fileClass()" @click="click">
        <input type="checkbox" v-model="file.is_selected" v-if="isBulking" class="absolute! top-4 left-4" />
        <div class="flex-none w-20 md:w-full h-16 md:h-32" v-if="file.is_folder">

            <div class="w-full h-full" v-if="file.thumbnails.length === 1"  :style="{backgroundImage: previewImage(file.thumbnails[0])}"></div>
            <div class="w-full h-full flex gap-0.5" v-else-if="file.thumbnails.length === 2">
                <div class="w-1/2 h-full cover-background" :style="{backgroundImage: previewImage(file.thumbnails[0])}"></div>
                <div class="w-1/2 h-full cover-background" :style="{backgroundImage: previewImage(file.thumbnails[1])}"></div>
            </div>
            <div class="w-full h-full flex gap-0.5" v-else-if="file.thumbnails.length === 3">
                <div class="w-1/2 h-full cover-background" :style="{backgroundImage: previewImage(file.thumbnails[0])}"></div>
                <div class="flex flex-col gap-0.5 w-1/2 h-full">
                    <div class="w-full h-1/2 cover-background" :style="{backgroundImage: previewImage(file.thumbnails[1])}"></div>
                    <div class="w-full h-1/2 cover-background" :style="{backgroundImage: previewImage(file.thumbnails[2])}"></div>
                </div>
            </div>
            <div v-else class="h-full w-full flex items-center justify-center align-middle text-6xl text-neutral-content">
                <i class="fa-regular fa-folder" aria-hidden="true" />
            </div>
        </div>
        <div class="flex-none w-20 md:w-full h-16 md:h-32 cover-background" v-else-if="hasThumbnail()" :style="{backgroundImage: previewImage(file.thumbnail)}">

        </div>
        <div v-else class="w-full h-20 md:h-32">

        </div>
        <div class="flex gap-1 md:gap-2 items-center md:p-4 truncate">
            <div class="grow-0 md:hidden" v-if="file.visibility_id > 1">
                <i :class="visibilityClass()" aria-hidden="true" :title="visibilityTitle()"></i>
            </div>
            <div class="grow truncate">
                <span v-html="file.name" class=""></span>
            </div>
            <div class="hidden md:block grow-0" v-if="file.visibility_id > 1">
                <i :class="visibilityClass()" aria-hidden="true" :title="visibilityTitle()"></i>
            </div>
        </div>
    </div>

</template>

<script setup lang="ts">
import {ref, onMounted, watch, onBeforeMount} from 'vue'

const emit = defineEmits(['select'])


const props = defineProps<{
    file: Object,
    isBulking: Boolean,
    i18n: Object
}>()

const hasThumbnail = () => {
    return props.file.thumbnail !== null
}

const previewClass = () => {
    return
}
const previewImage = (url) => {
    return "url('" + url + "')"
}

const click = () => {
    emit('select', props.file)
}

const fileClass = () => {
    let css = 'rounded-xl shadow bg-base-100 overflow-hidden sm:w-48 cursor-pointer hover:shadow-lg relative flex flex-row md:flex-col gap-2 md:gap-0';

    if (!props.file.is_selected || !props.isBulking) {
        return css + '  '
    }
    return css + ' bg-base-300'
}

const visibilityClass = () => {
    switch(parseInt(props.file.visibility_id)) {
        case 2:
            return 'fa-regular fa-lock'
        case 3: // admin-self
            return 'fa-regular fa-user-lock'
        case 4:
            return 'fa-regular fa-user-secret'
        case 5:
            return 'fa-regular fa-users'
        default:
            return 'fa-regular fa-eye'
    }
}

const visibilityTitle = () => {
    return props.i18n['visibility.' + props.file.visibility_id]
}

</script>
