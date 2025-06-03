<template>
    <div v-bind:class="rowClass(attribute)">
        <div v-if="attribute.template" class="basis-full w-full">
            <p v-html="attribute.template.text" class="text-neutral-content"></p>
        </div>
        <div class="w-6 md:w-8 pt-2" v-if="!attribute.is_hidden">
            <i class="fa-light fa-grip-vertical handle cursor-move" aria-hidden="true"/>
        </div>
        <div class="w-6 md:w-8 pt-2" v-else>
            <i class="fa-regular fa-user-secret" aria-hidden="true"/>
        </div>
        <div class="w-6 md:w-8 pt-2">
            <input type="checkbox"
                   v-model="attribute.is_checked"
                   tabindex="-1"
                   v-bind:value="attribute.id"
                   v-bind:placeholder="placeholderName(attribute)" />
        </div>
        <div class="grow flex flex-col md:flex-row gap-2">
            <div v-if="attribute.is_section" class="grow">
                <input type="text"
                       class="w-full"
                       v-model="attribute.name"
                       :id="'name-' + attribute.id"
                       v-bind:placeholder="placeholderName(attribute)" />
            </div>
            <div v-else-if="attribute.is_hidden" class="md:w-40 flex-none bg-base-200 rounded flex items-center">
                <div class="w-full break-normal px-2" v-html="attribute.name"></div>
            </div>
            <div v-else class="md:w-40 flex-none">
                <attributes-manager-mention-field
                    :attribute="attribute"
                    :placeholder="placeholderName(attribute)"
                    type="text"
                    property="name"
                    :mentionApi="mentionApi"
                    @field-blur="checkIfRanged()"
                />
            </div>

            <div v-if="attribute.is_multiline" class="grow">
                <attributes-manager-mention-field
                    :attribute="attribute"
                    :placeholder="placeholderValue(attribute)"
                    type="textarea"
                    property="value"
                    :mentionApi="mentionApi"
                />
            </div>
            <div v-else-if="attribute.is_checkbox" class="grow flex items-center">
                <input type="checkbox"
                       v-model="attribute.value"
                       :id="'value-' + attribute.id"
                       v-bind:placeholder="placeholderValue(attribute)" />
            </div>
            <div v-else-if="attribute.is_number" class="grow relative">
                <input
                    type="number"
                    class="w-full"
                    v-model="attribute.value"
                    :id="'value-' + attribute.id"
                    v-bind:placeholder="placeholderValue(attribute)"
                    v-bind:min="attributeMin(attribute)"
                    v-bind:max="attributeMax(attribute)"
                />
            </div>
            <div v-else-if="isDisabled(attribute)" class="grow bg-base-200 rounded flex items-center select-none">
                <div class="w-full break-normal px-2" v-html="attribute.value"></div>
            </div>
            <div v-else-if="!attribute.is_section" class="grow">
                <attributes-manager-mention-field
                    :attribute="attribute"
                    :placeholder="placeholderValue(attribute)"
                    type="text"
                    property="value"
                    :mentionApi="mentionApi"
                    v-if="!isRanged"
                />
                <select
                    v-else
                    class="w-full"
                    v-model="attribute.value"
                    :id="'value-' + attribute.id">
                    <option v-for="(value, index) in rangedOptions(attribute)" :key="index" v-bind:value="value" v-html="value"></option>
                </select>
            </div>
        </div>

        <div class="flex text-xl gap-2 lg:text-base pt-2 flex-none">
            <a role="button" @click="pinnedToggle(attribute)" class="w-6 lg:w-16 text-center inline-block cursor-pointer text-base-content hover:text-accent" v-if="!attribute.is_hidden">
                <i v-bind:class="pinnedClass(attribute)"  v-bind:aria-label="pinnedLabel(attribute)" />
            </a>
            <a v-if="props.isAdmin && !attribute.is_hidden" role="button" @click="privateToggle(attribute)" class="w-6 lg:w-16 inline-block text-center cursor-pointer text-base-content hover:text-accent" >
                <i v-bind:class="privateClass(attribute)" v-bind:aria-label="privateLabel(attribute)" />
            </a>
            <a role="button" class="w-6 lg:w-16 inline-block text-center flex-none cursor-pointer hover:text-error text-base-content" @click="$emit('remove', attribute)" v-if="!attribute.is_hidden">
                <i class="fa-regular fa-trash-can" v-bind:aria-label="trans('columns.delete')" v-bind:title="trans('columns.delete')" />
            </a>
        </div>

        <input type="hidden" name="attribute[]" :value="configValue(attribute)" />
    </div>
</template>

<script setup lang="ts">

import {onMounted, ref} from "vue"

const props = defineProps<{
    attribute: Object,
    attributes: Object
    i18n,
    isAdmin: Boolean,
    showHidden: Boolean,
    searchTerm: String,
    mentionApi: String,
}>()

const emit = defineEmits(['remove'])
const isRanged = ref(false)


onMounted(() => {
    checkIfRanged()
})

const trans = (k) => {
    if (!k.includes('.')) {
        return k
    }
    let blocks = k.split('.')
    return props.i18n[blocks[0]][blocks[1]]
}

const attributeName = (attribute) => {
    return 'attr_name[' + attribute.id + ']'
}
const attributeValue = (attribute) => {
    return 'attr_value[' + attribute.id + ']'
}

const rowClass = (attribute) => {
    if (props.searchTerm) {
        let lowerCase = props.searchTerm.toLowerCase()
        if (!attribute.name.toLowerCase().includes(lowerCase) &&
            !(attribute.value ? attribute.value.toLowerCase().includes(lowerCase) : false)) {
            return 'hidden'
        }
    }
    if (!props.showHidden && attribute.is_hidden) {
        return 'hidden'
    }
    return 'flex gap-2 w-full px-4 ' + (attribute.template ? 'flex-wrap' : null)
}

const typeName = (attribute) => {
    return 'attr_type[' + attribute.id + ']'
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

const typeValue = (attribute) => {
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
        return 'fa-solid fa-thumbtack rotate-45 transition-all'
    }
    return 'fa-regular fa-thumbtack transition-all'
}

const pinnedLabel = (attribute) => {
    if (attribute.is_pinned) {
        return 'Pinned'
    }
    return 'Unpinned'
}

const pinnedToggle = (attribute) => {
    attribute.is_pinned = !attribute.is_pinned
    /*const attribute = attributes.value.find(attribute => attribute.id === id);
    if (attribute) {
        attribute.is_pinned = !attribute.is_pinned;
    }*/
}

const privateClass = (attribute) => {
    if (attribute.is_private) {
        return 'fa-solid fa-lock-keyhole'
    }
    return 'fa-regular fa-unlock-keyhole'
}

const privateLabel = (attribute) => {
    if (attribute.is_private) {
        return 'Private'
    }
    return 'Public'
}

const privateToggle = (attribute) => {
    attribute.is_private = !attribute.is_private
}

const isDisabled = (attribute) => {
    return attribute.is_hidden || attribute.name === '_layout'
}

const configValue = (attribute) => {
    return JSON.stringify({
        id: attribute.id,
        name: attribute.name,
        value: attribute.value,
        type: typeValue(attribute),
        is_private: attribute.is_private,
        is_pinned: attribute.is_pinned,
        is_hidden: attribute.is_hidden,
        source_id: attribute.source_id,
    })
}

const attributeMin = (attribute) => {
    const regex = /\[range:(\d+),(\d+)\]/
    const match = attribute.name.match(regex)
    if (!match) {
        return null
    }
    return parseInt(match[1])
}

const attributeMax = (attribute) => {
    const regex = /\[range:(\d+),(\d+)\]/
    const match = attribute.name.match(regex)
    if (!match) {
        return null
    }
    return parseInt(match[2])
}

const checkIfRanged = () => {
    const regex = /\[range:(.*)+\]/
    const match = props.attribute.name.match(regex)
    if (match) {
        isRanged.value = true
    } else {
        isRanged.value = false
    }
}

const rangedOptions = (attribute) => {
    const regex = /\[range:(.*)+\]/
    const match = attribute.name.match(regex)
    let rangedOptions = []
    if (match) {
        rangedOptions = match[1].split(',').map(value => value.trim()).map(value => parseMentions(value))
        rangedOptions.unshift([])
    }
    return rangedOptions
}

const parseMentions = (value) => {
    const regex = /\{(.*)+\}/
    const match = value.match(regex)
    if (!match) {
        return value
    }
    // look for an attribute names like that
    const mentionName = match[1]
    const mentionedAttribute = props.attributes.filter(attribute => attribute.name == mentionName)
    if (mentionedAttribute.length === 0) {
        return value
    }

    return mentionedAttribute[0].value.trim()
}

</script>
