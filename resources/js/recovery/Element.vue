<template>
    <div v-if="!file.is_hidden" :class="fileClass()" @click="click">
        <input v-if="!file.url" type="checkbox" v-model="file.is_selected" class="!absolute top-4 left-4" @click="startBulking"/>
        <div class="flex-none w-20 md:w-full h-16 md:h-32">
            <div class="h-full w-full flex items-center justify-center align-top text-l">
                <span v-html="file.name" class=""></span>
                <span v-html="trans(file.type_id)" class=""></span>
            </div>
        </div>
        <div class="w-full flex items-center justify-center align-top">
            <span v-html="file.type" class=""></span>
        </div>
        <div class="flex gap-1 md:gap-2 items-center md:p-4  text-neutral-content">
            <div class="grow">
                Deleted by: 
                <span v-html="file.deleted_name" class=""></span>
                 -  
                <span v-html="file.date" class=""></span>
                <span v-if="file.url" v-html="file.url" class=""></span>

            </div>
        </div>
        <div v-if="!file.url" class="flex items-center justify-center grow">
            <button :class="buttonClass()" @click="restoreElement()" v-html="trans('recover')" ></button>
        </div>
    </div>

</template>

<script setup lang="ts">
import {ref, onMounted, watch, onBeforeMount} from 'vue'
import {matches} from "lodash";

const emit = defineEmits(['select', 'recover'])

const props = defineProps<{
    file: Object,
    isBulking: Boolean,
    i18n: Object
}>()

const restoring = ref(false)

const click = () => {
    emit('select', props.file)
    props.file.is_selected = !props.file.is_selected
}

const submit = () => {
    emit('select', props.file)
}

const fileClass = () => {
    let css = 'rounded-xl shadow bg-base-100 overflow-hidden sm:w-[12rem] cursor-pointer hover:shadow-lg relative flex flex-row md:flex-col gap-2 md:gap-0';

    if (!props.file.is_selected) {
        return css + '  '
    }
    return css + ' bg-base-300'
}

const trans = (key) => {
    if (!props.i18n[key]) {
        console.error('Missing trans', key, props.i18n)
        return 'MISSING'
    }
    return props.i18n[key]
}

const buttonClass = () => {
    let css = 'btn2 btn-secondary'
    if (restoring.value) {
        css += ' loading btn-disabled'
    }
    return css
}

const restoreElement = () => {
    emit('recover', props.file)
    restoring.value = true
}


</script>
