<template>
    <form class="flex min-w-0 flex-col gap-3 bg-base-200 px-4 py-4 sm:px-6" @submit.prevent="$emit('submit')">
        <div v-if="editing" class="flex flex-wrap items-center gap-x-2 gap-y-1 text-sm">
            <i class="fa-solid fa-pen text-base-content/75" aria-hidden="true"></i>
            <strong>{{ trans.editing }}</strong>
            <span class="wrap-anywhere text-base-content/75">{{ editing.entity ?? editing.user ?? trans.user_unknown }}</span>
        </div>
        <div v-else-if="speakers.length" class="flex min-w-0 flex-col gap-1 text-sm sm:flex-row sm:items-center sm:gap-2">
            <label v-if="speakers.length > 1" for="conversation-speaker" class="shrink-0 font-medium">{{ trans.speaking_as }}</label>
            <select
                v-if="speakers.length > 1"
                id="conversation-speaker"
                v-model="speaker"
                class="w-full min-w-0 sm:max-w-64"
                :disabled="busy"
            >
                <option v-for="option in speakers" :key="option.id" :value="option.id">{{ option.name }}</option>
            </select>
            <p v-else class="wrap-anywhere"><strong>{{ trans.speaking_as }}:</strong> {{ speakers[0].name }}</p>
        </div>

        <label for="conversation-message" class="sr-only">{{ trans.message }}</label>
        <textarea
            id="conversation-message"
            ref="input"
            v-model="body"
            class="field-sizing-content min-h-18 max-h-40 w-full resize-y rounded-lg"
            rows="2"
            maxlength="1000"
            :placeholder="trans.message"
            :readonly="busy"
            :enterkeyhint="useEnterForNewline ? 'enter' : undefined"
            :aria-describedby="showKeyboardHint ? 'conversation-keyboard-hint' : undefined"
            @keydown.enter="onEnter"
        ></textarea>
        <p v-if="error" class="text-sm" role="alert">{{ error }}</p>

        <div class="flex flex-wrap items-center justify-end gap-2">
            <p v-if="showKeyboardHint" id="conversation-keyboard-hint" class="mr-auto text-xs text-base-content/75">
                {{ trans.keyboard_hint }}
            </p>
            <button v-if="editing" type="button" class="btn2 btn-sm btn-default" :disabled="busy" @click="$emit('cancel')">
                {{ trans.cancel }}
            </button>
            <button type="submit" class="btn2 btn-sm btn-primary" :disabled="blocked || !body.trim()">
                <i v-if="busy" class="fa-solid fa-spinner fa-spin" aria-hidden="true"></i>
                <i v-else-if="!editing" class="fa-solid fa-paper-plane" aria-hidden="true"></i>
                {{ editing ? (busy ? trans.saving : trans.save) : (busy ? trans.sending : trans.send) }}
            </button>
        </div>
    </form>
</template>

<script setup>
import { computed, onMounted, onUnmounted, ref } from 'vue'

const props = defineProps({
    speakers: Array,
    editing: Object,
    busy: Boolean,
    blocked: Boolean,
    error: String,
    trans: Object,
})
const emit = defineEmits(['submit', 'cancel'])
const body = defineModel({ type: String, required: true })
const speaker = defineModel('speaker', { type: Number })
const input = ref(null)
const mobile = window.matchMedia('(width < 48rem), (pointer: coarse)')
const useEnterForNewline = ref(mobile.matches)
const showKeyboardHint = computed(() => !props.editing && !useEnterForNewline.value)

function updateKeyboardMode(event) {
    useEnterForNewline.value = event.matches
}

onMounted(() => mobile.addEventListener('change', updateKeyboardMode))
onUnmounted(() => mobile.removeEventListener('change', updateKeyboardMode))

function onEnter(event) {
    if (useEnterForNewline.value || event.shiftKey || event.isComposing) return
    event.preventDefault()
    if (!props.blocked && !event.repeat) emit('submit')
}

defineExpose({ focus: () => input.value?.focus({ preventScroll: !props.editing }) })
</script>
