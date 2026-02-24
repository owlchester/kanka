<template>
    <div class="flex gap-4 justify-between flex-wrap text-xs">
        <div class="flex items-center flex-wrap  gap-4">
            <button @click="addAttribute($event, '')" :class="btnClass()">
                <i class="fa-regular fa-shield md:text-xl" aria-hidden="true" />
                <span v-html="trans('types.attribute')"></span>
            </button>

            <button @click="addAttribute($event, 'multiline')" :class="btnClass()">
                <i class="fa-regular fa-align-justify md:text-xl" aria-hidden="true" />
                <span v-html="trans('types.multiline')"></span>
            </button>

            <button @click="addAttribute($event, 'number')" :class="btnClass()">
                <i class="fa-regular fa-hashtag md:text-xl" aria-hidden="true" />
                <span v-html="trans('types.number')"></span>
            </button>

            <button @click="addAttribute($event, 'section')" :class="btnClass()">
                <i class="fa-regular fa-layer-group md:text-xl" aria-hidden="true" />
                <span v-html="trans('types.section')"></span>
            </button>

            <button @click="addAttribute($event, 'checkbox')" :class="secondaryBtnClass()">
                <i class="fa-regular fa-check-square md:text-xl" aria-hidden="true" />
                <span v-html="trans('types.checkbox')"></span>
            </button>

            <button @click="addAttribute($event, 'random')" :class="secondaryBtnClass()">
                <i class="fa-regular fa-question-circle md:text-xl" aria-hidden="true" />
                <span v-html="trans('types.random')" class="text-xs truncate"></span>
            </button>
        </div>

        <button @click="openTemplates($event)" :class="secondaryBtnClass()" data-tooltip :data-title="trans('actions.load')">
            <i class="fa-regular fa-file-import md:text-xl" aria-hidden="true" />
            <span v-html="trans('types.templates')" class="text-xs truncate"></span>
        </button>
    </div>
</template>

<script setup lang="ts">

import {ref, onMounted} from "vue";

const props = defineProps<{
    attributes,
    visibleAttributes,
    i18n,
    newAttributeID,
    max
}>()

const emit = defineEmits(['incrementNewAttributeID', 'openTemplates'])

onMounted(() => {
    window.initTooltips();
})

const trans = (k) => {
    if (!k.includes('.')) {
        return k;
    }
    let blocks = k.split('.');
    return props.i18n[blocks[0]][blocks[1]];
};

const addAttribute = (event, type) => {
    event.preventDefault()
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

const openTemplates = (event) => {
    event.preventDefault()
    emit('openTemplates')
}

const btnClass = () => {
    return 'flex flex-col gap-1 items-center hover:bg-base-200 text-xs border border-base-200 rounded-xl px-4 py-3 cursor-pointer';
}
const secondaryBtnClass = (extra = '') => {
    return 'flex flex-col gap-1 items-center hover:bg-base-200 text-xs border border-base-300 rounded-xl px-4 py-3 cursor-pointer text-neutral-content ' + extra  ;
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

</script>


