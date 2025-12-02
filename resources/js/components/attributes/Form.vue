<template>
    <div class="flex flex-wrap gap-2 md:gap-5 lg:gap-10 justify-center justify-items-stretch items-center
     lg:border lg:rounded p-2 lg:p-5 text-xs md:text-sm m-0 lg:m-5 ">
        <div v-if="showAddForm" role="button" @click="addAttribute($event, '')" class="flex flex-col gap-1 items-center hover:text-primary">
            <i class="fa-regular fa-person text-xl md:text-2xl" aria-hidden="true" />
            <span v-html="trans('types.attribute')" class="text-xs"></span>
        </div>

        <div v-if="showAddForm" role="button" @click="addAttribute($event, 'multiline')" class="flex flex-col gap-1 items-center hover:text-primary">
            <i class="fa-regular fa-align-justify text-xl md:text-2xl" aria-hidden="true" />
            <span v-html="trans('types.multiline')" class="text-xs"></span>
        </div>

        <div v-if="showAddForm" role="button" @click="addAttribute($event, 'number')" class="flex flex-col gap-1 items-center hover:text-primary">
            <i class="fa-regular fa-hashtag text-xl md:text-2xl" aria-hidden="true" />
            <span v-html="trans('types.number')" class="text-xs"></span>
        </div>

        <div v-if="showAddForm" role="button" @click="toggleAddForm()" class="rounded-full w-12 lg:w-16 h-12 lg:h-16 bg-primary text-primary-content text-2xl flex items-center justify-center shadow-md flex-none">
            <i class="fa-regular fa-times" aria-hidden="true" />
            <span class="sr-only">Close new attribute form</span>
        </div>

        <div v-if="showAddForm" role="button" @click="addAttribute($event, 'section')" class="flex flex-col gap-1 items-center hover:text-primary">
            <i class="fa-regular fa-layer-group text-xl md:text-2xl" aria-hidden="true" />
            <span v-html="trans('types.section')" class="text-xs"></span>
        </div>

        <div v-if="showAddForm" role="button" @click="addAttribute($event, 'checkbox')" class="flex flex-col gap-1 items-center hover:text-primary">
            <i class="fa-regular fa-check-square text-xl md:text-2xl" aria-hidden="true" />
            <span v-html="trans('types.checkbox')" class="text-xs"></span>
        </div>

        <div v-if="showAddForm" role="button" @click="addAttribute($event, 'random')" class="flex flex-col gap-1 items-center hover:text-primary">
            <i class="fa-regular fa-question-circle text-xl md:text-2xl" aria-hidden="true" />
            <span v-html="trans('types.random')" class="text-xs truncate"></span>
        </div>

        <div v-if="!showAddForm" role="button" @click="toggleAddForm()" class="rounded-full w-12 lg:w-16 h-12 lg:h-16 bg-primary text-primary-content text-2xl flex items-center justify-center shadow-md">
            <i class="fa-regular fa-plus" aria-hidden="true" />
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
    newAttributeID,
    max
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

const addAttribute = (event, type) => {
    if (reachedMax(event)) {
        return;
    }
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

/**
 * Check if the form has space for some extra fields to be send
 * @param event
 */
const reachedMax = (event) => {
    const form = event.target.closest('form')
    const inputFields = form.getElementsByTagName('input')
    const selectFields = form.getElementsByTagName('select')
    const buttonFields = form.getElementsByTagName('button')

    // Exclude unnamed fields, as attributes have multiple fields but are
    // compressed into a single json input field to allow more attributes
    const namedInputFields = Array.from(inputFields).filter(input => input.hasAttribute('name'));
    const namedSelectFields = Array.from(selectFields).filter(input => input.hasAttribute('name'));
    const namedButtonFields = Array.from(buttonFields).filter(input => input.hasAttribute('name'));

    const totalFields = namedInputFields.length + namedSelectFields.length + namedButtonFields.length
    if (totalFields >= (props.max - 1)) {
        window.showToast(props.i18n['toasts']['max_reached'].replace(/:count/, totalFields), 'error')
        return true;
    }
    return false;
}

const toggleAddForm = () => {
    showAddForm.value = !showAddForm.value
}
</script>


