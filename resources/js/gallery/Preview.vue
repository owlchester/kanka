<template>
    <div :class="fileClass()" @click="click">
        <input type="checkbox" v-model="file.is_selected" v-if="isBulking" class="!absolute top-4 left-4" />
        <div class="w-full h-32" v-if="file.is_folder">
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
        <div class="w-full h-32 cover-background" v-else-if="hasThumbnail()" :style="{backgroundImage: previewImage(file.thumbnail)}">

        </div>
        <div v-else class="w-full h-32">

        </div>
        <div class="flex gap-2 items-center p-4">
            <div class="grow truncate">
                <span v-html="file.name"></span>
            </div>
            <div v-if="file.visibility.class">
                <i :class="file.visibility.class" aria-hidden="true" :title="file.visibility.key"></i>
            </div>
        </div>
    </div>

</template>

<script setup lang="ts">
import {ref, onMounted, watch, onBeforeMount} from 'vue'

const emit = defineEmits(['select'])


const props = defineProps<{
    file: Object,
    isBulking: Boolean
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
    let css = 'rounded-xl shadow bg-base-100 overflow-hidden w-[12rem] cursor-pointer hover:shadow-lg relative';
    if (!props.file.is_selected || !props.isBulking) {
        return css + '  '
    }
    return css + ' bg-base-300'
}

</script>
