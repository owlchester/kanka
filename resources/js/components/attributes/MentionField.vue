<template>
    <div class="relative">
        <input
            type="text"
            class="w-full"
            v-if="type === 'text'"
            v-model="attribute[property]"
            :id="property + '-' + attribute.id"
            v-bind:placeholder="placeholder"
            @input="onInput"
            ref="textarea"
            @keydown.down.prevent="highlightNext"
            @keydown.up.prevent="highlightPrev"
            @keydown.enter.prevent="selectMention"
            @keydown.esc="hideSuggestions"
            @blur="onBlur"
        />
        <textarea
            type="text"
            class="w-full"
            v-else-if="type === 'textarea'"
            v-model="attribute[property]"
            :id="property + '-' + attribute.id"
            v-bind:placeholder="placeholder"
            @input="onInput"
            rows="3"
            ref="textarea"
            @keydown.down="highlightNext"
            @keydown.up="highlightPrev"
            @keydown.enter="handleEnter"
            @keydown.esc="hideSuggestions"
            @blur="onBlur"
        ></textarea>
        <ul class="absolute w-full left-0 bg-base-100 shadow list-none p-2 m-0 z-[1000]" v-if="suggestions.length" v-click-outside="hideSuggestions">
            <li
                v-for="(suggestion, id) in suggestions"
                :key="suggestion.id"
                :class="suggestionClass(id)"
                @click="selectSuggestion(suggestion)"
                v-html="suggestion.name">
            </li>
        </ul>
    </div>
</template>

<script setup lang="ts">

import { ref, nextTick } from 'vue';

const props = defineProps<{
    attribute: Object
    placeholder: String,
    type: String,
    property: String,
    mentionApi: String,
}>()

const suggestions = ref([])
const highlightedIndex = ref(-1)
const mentionTargetField = ref(null)
const textarea = ref(null)

const emit = defineEmits(['update:modelValue', 'field-blur'])

const onInput = (event) => {
    const value = event.target.value
    const cursorPos = event.target.selectionStart;
    const textBeforeCursor = value.substring(0, cursorPos);
    const mentionMatch = textBeforeCursor.match(/@(\w{3,})$/);

    mentionTargetField.value = event.target.dataset.type;
    if (mentionMatch) {
        let url = props.mentionApi + '?q=' +  mentionMatch[1];
        fetch (url)
            .then(response => response.json())
            .then(response => {
                suggestions.value = response
                highlightedIndex.value = 0
            });
    } else {
        suggestions.value = []
    }
}

const highlightNext = (event) => {
    if (highlightedIndex.value === -1) {
        return;
    }
    event.preventDefault();
    if (highlightedIndex.value < suggestions.value.length - 1) {
        highlightedIndex.value++;
    } else if (suggestions.value.length > 0) {
        highlightedIndex.value = 0;
    }
};

const highlightPrev = (event) => {
    if (highlightedIndex.value === -1) {
        return;
    }
    event.preventDefault();
    if (highlightedIndex.value > 0) {
        highlightedIndex.value--;
    } else if (suggestions.value.length > 0) {
        highlightedIndex.value = suggestions.value.length - 1;
    }
};

const handleEnter = (event) => {
    if (suggestions.value.length > 0 && highlightedIndex.value >= 0) {
        event.preventDefault();
        selectMention();
    }
};

const selectMention = () => {
    if (highlightedIndex.value >= 0 && highlightedIndex.value < suggestions.value.length) {
        selectSuggestion(suggestions.value[highlightedIndex.value]);
    }
};

const suggestionClass = (index) => {
    if (index === highlightedIndex.value) {
        return "p-1 bg-primary text-primary-content"
    }
    return 'p-1'
}

const hideSuggestions = () => {
    suggestions.value = [];
    highlightedIndex.value = -1;
};

const selectSuggestion = (suggestion) => {
    const cursorPos = textarea.value.selectionStart;
    const textBeforeCursor = props.attribute[props.property].substring(0, cursorPos);
    const mentionMatch = textBeforeCursor.match(/@(\w{3,})$/);
    if (mentionMatch) {
        const mentionText = `@${mentionMatch[1]}`;
        const start = textBeforeCursor.lastIndexOf(mentionText);

        const replace = `[${suggestion.model_type}:${suggestion.id}] `
        props.attribute[props.property] = props.attribute[props.property].replace(mentionText, replace);
        suggestions.value = [];
        highlightedIndex.value = -1;

        nextTick(() => {
            textarea.value.setSelectionRange(start + replace.length, start + replace.length);
            textarea.value.focus();
        });
    }
};

const onBlur = () => {
    emit('field-blur');
}

</script>
