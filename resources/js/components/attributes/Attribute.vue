<template>
    <div v-bind:class="rowClass(attribute)">
        <div class="w-6 md:w-8 pt-2">
            <i class="fa-light fa-grip-vertical handle cursor-move" aria-hidden="true"/>
        </div>
        <div class="w-6 md:w-8 pt-2">
            <input v-bind:name="attributeName(attribute)" type="checkbox" v-model="attribute.is_checked" v-bind:value="attribute.id" v-bind:placeholder="placeholderName(attribute)" />
        </div>
        <div class="grow flex flex-col md:flex-row gap-1">
            <div v-if="attribute.is_section" class="grow">
                <input type="text" class="w-full" :value="attribute.name" v-bind:name="attributeName(attribute)" v-bind:placeholder="placeholderName(attribute)" />
            </div>
            <div v-else class="md:w-40 flex-none">
                <input type="text" class="w-full" :value="attribute.name" v-bind:name="attributeName(attribute)" v-bind:placeholder="placeholderName(attribute)" />
            </div>

            <div v-if="attribute.is_multiline" class="grow">
                <textarea class="w-full" rows="3" :value="attribute.value" v-bind:name="attributeValue(attribute)" v-bind:placeholder="placeholderValue(attribute)"></textarea>
            </div>
            <div v-else-if="attribute.is_checkbox" class="grow flex items-center">
                <input type="checkbox" :value="attribute.value" v-model="attribute.value" v-bind:name="attributeValue(attribute)" v-bind:placeholder="placeholderValue(attribute)" />
            </div>
            <div v-else-if="attribute.is_number" class="grow">
                <input type="number" class="w-full" :value="attribute.value" v-bind:name="attributeValue(attribute)" v-bind:placeholder="placeholderValue(attribute)" />
            </div>
            <div v-else-if="isLayout(attribute)" class="grow bg-base-200 rounded flex items-center select-none">
                <input type="hidden" v-bind:name="attributeValue(attribute)"  :value="attribute.value" />
                <div class="w-full break-normal px-2" v-html="attribute.value"></div>
            </div>
            <div v-else-if="!attribute.is_section" class="grow">
                <input type="text" class="w-full" :value="attribute.value" v-bind:name="attributeValue(attribute)" v-bind:placeholder="placeholderValue(attribute)" />
            </div>
        </div>

        <div class="flex text-xl gap-2 lg:block lg:text-base pt-2 flex-none">
            <a role="button" @click="pinnedToggle(attribute)" class="lg:w-16 text-center inline-block cursor-pointer text-base-content hover:text-accent">
                <i v-bind:class="pinnedClass(attribute)"  v-bind:aria-label="pinnedLabel(attribute)" />
                <input type="hidden" v-bind:name="pinnedFieldName(attribute)" value="1" v-if="attribute.is_pinned" />
            </a>
            <a v-if="props.isAdmin" role="button" @click="privateToggle(attribute)" class="lg:w-16 inline-block text-center cursor-pointer text-base-content hover:text-accent" >
                <i v-bind:class="privateClass(attribute)" v-bind:aria-label="privateLabel(attribute)" />
                <input type="hidden" v-bind:name="privateFieldName(attribute)" value="1" v-if="attribute.is_private" />
            </a>
            <a role="button" class="lg:w-16 inline-block text-center flex-none cursor-pointer hover:text-error text-base-content"  @click="$emit('remove', attribute)">
                <i class="fa-regular fa-trash-can" v-bind:aria-label="trans('columns.delete')" v-bind:title="trans('columns.delete')" />
            </a>
        </div>
        <input type="hidden" :value="hiddenValue(attribute)" v-bind:name="hiddenName(attribute)" />
    </div>
</template>

<script setup lang="ts">

import {ref} from "vue";

const props = defineProps<{
    attribute: Object
    i18n,
    isAdmin: Boolean,
    searchTerm: String,
}>()

const emit = defineEmits(['remove'])


const trans = (k) => {
    if (!k.includes('.')) {
        return k;
    }
    let blocks = k.split('.');
    return props.i18n[blocks[0]][blocks[1]];
};

const attributeName = (attribute) => {
    return 'attr_name[' + attribute.id + ']';
}
const attributeValue = (attribute) => {
    return 'attr_value[' + attribute.id + ']';
}

const rowClass = (attribute) => {
    if (props.searchTerm) {
        let lowerCase = props.searchTerm.toLowerCase()
        if (!attribute.name.toLowerCase().includes(lowerCase) &&
            !(attribute.value ? attribute.value.toLowerCase().includes(lowerCase) : false)) {
            return 'hidden'
        }
    }
    return 'flex gap-2 w-full px-4'
}


const hiddenName = (attribute) => {
    return 'attr_type[' + attribute.id + ']'
}


const pinnedFieldName = (attribute) => {
    return 'attr_is_pinned[' + attribute.id + ']'
}


const privateFieldName = (attribute) => {
    return 'attr_is_private[' + attribute.id + ']'
}



const placeholderName = (attribute) => {
    if (attribute.is_checkbox) {
        return trans('placeholders.checkbox_name')
    } else if (attribute.is_section) {
        return trans('placeholders.section_name')
    } else if (attribute.is_multiline) {
        return trans('placeholders.multiline_name')
    }
    return trans('placeholders.name')
}
const placeholderValue = (attribute) => {
    return trans('placeholders.value')
}

const hiddenValue = (attribute) => {
    if (attribute.is_checkbox) {
        return 3
    } else if (attribute.is_multiline) {
        return 2
    } else if (attribute.is_section) {
        return 4
    } else if (attribute.is_random) {
        return 5
    } else if (attribute.is_number) {
        return 6
    }
    return 1
}


const pinnedClass = (attribute) => {
    if (attribute.is_pinned) {
        return 'fa-solid fa-thumbtack rotate-45 transition-all';
    }
    return 'fa-regular fa-thumbtack transition-all';
}
const pinnedLabel = (attribute) => {
    if (attribute.is_pinned) {
        return 'Pinned';
    }
    return 'Unpinned';
}
const pinnedToggle = (attribute) => {
    attribute.is_pinned = !attribute.is_pinned;
    /*const attribute = attributes.value.find(attribute => attribute.id === id);
    if (attribute) {
        attribute.is_pinned = !attribute.is_pinned;
    }*/
}
const privateClass = (attribute) => {
    if (attribute.is_private) {
        return 'fa-solid fa-lock-keyhole';
    }
    return 'fa-regular fa-unlock-keyhole';
}
const privateLabel = (attribute) => {
    if (attribute.is_private) {
        return 'Private';
    }
    return 'Public';
}
const privateToggle = (attribute) => {
    attribute.is_private = !attribute.is_private;
    /*const attribute = attributes.value.find(attribute => attribute.id === id);
    if (attribute) {
        attribute.is_private = !attribute.is_private;
    }*/
}

const isLayout = (attribute) => {
    return attribute.name === '_layout';
}

</script>
