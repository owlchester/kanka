<template>
    <div class="flex flex-wrap gap-2 md:gap-5 lg:gap-10 justify-center justify-items-stretch items-center
     lg:border lg:rounded bg-base-200 lg:bg-inherit p-2 lg:p-5 text-xs md:text-sm m-0 lg:m-5 ">
        <div v-if="showAddForm" role="button" @click="addAttribute('')" class="flex flex-col gap-1 items-center hover:text-primary">
            <i class="fa-solid fa-person text-xl md:text-2xl" aria-hidden="true" />
            <span v-html="trans('types.attribute')" class="text-xs"></span>
        </div>

        <div v-if="showAddForm" role="button" @click="addAttribute('multiline')" class="flex flex-col gap-1 items-center hover:text-primary">
            <i class="fa-solid fa-align-justify text-xl md:text-2xl" aria-hidden="true" />
            <span v-html="trans('types.multiline')" class="text-xs"></span>
        </div>

        <div v-if="showAddForm" role="button" @click="addAttribute('number')" class="flex flex-col gap-1 items-center hover:text-primary">
            <i class="fa-solid fa-hashtag text-xl md:text-2xl" aria-hidden="true" />
            <span v-html="trans('types.number')" class="text-xs"></span>
        </div>

        <div v-if="showAddForm" role="button" @click="toggleAddForm()" class="rounded-full w-12 lg:w-16 h-12 lg:h-16 bg-primary text-primary-content text-2xl flex items-center justify-center shadow-md flex-none">
            <i class="fa-solid fa-times" aria-hidden="true" />
            <span class="sr-only">Close new attribute form</span>
        </div>

        <div v-if="showAddForm" role="button" @click="addAttribute('section')" class="flex flex-col gap-1 items-center hover:text-primary">
            <i class="fa-solid fa-layer-group text-xl md:text-2xl" aria-hidden="true" />
            <span v-html="trans('types.section')" class="text-xs"></span>
        </div>

        <div v-if="showAddForm" role="button" @click="addAttribute('checkbox')" class="flex flex-col gap-1 items-center hover:text-primary">
            <i class="fa-regular fa-check-square text-xl md:text-2xl" aria-hidden="true" />
            <span v-html="trans('types.checkbox')" class="text-xs"></span>
        </div>

        <div v-if="showAddForm" role="button" @click="addAttribute('random')" class="flex flex-col gap-1 items-center hover:text-primary">
            <i class="fa-solid fa-question-circle text-xl md:text-2xl" aria-hidden="true" />
            <span v-html="trans('types.random')" class="text-xs truncate"></span>
        </div>

        <div v-if="!showAddForm" role="button" @click="toggleAddForm()" class="rounded-full w-12 lg:w-16 h-12 lg:h-16 bg-primary text-primary-content text-2xl flex items-center justify-center shadow-md">
            <i class="fa-solid fa-plus" aria-hidden="true" />
            <span class="sr-only">Open new attribute form</span>
        </div>
    </div>
</template>

<script setup lang="ts">

import {ref} from "vue";

const props = defineProps<{
    attributes,
    visibleAttributes,
    i18n,
    newAttributeID
}>()

const showAddForm = ref(false)

const emit = defineEmits(['incrementNewAttributeID'])

const trans = (k) => {
    if (!k.includes('.')) {
        return k;
    }
    let blocks = k.split('.');
    return props.i18n[blocks[0]][blocks[1]];
};

const addAttribute = (type) => {
    emit('incrementNewAttributeID')
    let attribute = {
        id: props.newAttributeID,
        name: '',
        value: '',
        is_deleted: false,
        is_hidden: false,
        is_pinned: false,
        is_private: false,
        is_checked: false,

        is_section: type === 'section',
        is_number: type === 'number',
        is_multiline: type === 'multiline',
        is_checkbox: type === 'checkbox',
        is_random: type === 'random',
    }

    props.attributes.push(attribute)
    props.visibleAttributes.push(attribute)
}

const toggleAddForm = () => {
    showAddForm.value = !showAddForm.value
}
</script>


