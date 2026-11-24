<template>
    <li
        class="box-comment min-w-0 px-3 py-1 sm:px-4"
        :class="[
            `message-author-${message.from_id}`,
            `message-real-author-${message.created_by}`,
            grouped ? 'message-followup' : 'message-first mt-3 rounded-t-lg pt-2 first:mt-0',
            endsGroup && 'rounded-b-lg pb-2',
            editing ? 'bg-base-300' : 'bg-base-200',
        ]"
    >
        <div :class="grouped ? 'sr-only' : 'flex flex-wrap items-baseline gap-x-2 gap-y-0.5'">
            <strong class="min-w-0 wrap-anywhere text-sm">
                <a v-if="!grouped && message.entity_url" class="text-link" :href="message.entity_url">{{ message.entity }}</a>
                <template v-else>{{ message.user ?? message.entity ?? trans.user_unknown }}</template>
            </strong>
            <time class="text-xs text-base-content/75" :datetime="message.created_at_iso" :title="timestamp">
                {{ message.created_at }}
            </time>
        </div>
        <div class="flex min-w-0 items-start gap-2">
            <p class="comment-text min-w-0 grow whitespace-pre-wrap wrap-anywhere py-1">{{ message.message }}</p>
            <span v-if="message.is_updated" class="mt-1.5 shrink-0 text-xs text-base-content/75" :title="message.updated_at">
                {{ trans.is_updated }}
            </span>
            <div class="shrink-0">
                <button
                    :id="`conversation-actions-${message.id}`"
                    ref="trigger"
                    v-tippy="popover"
                    type="button"
                    class="btn2 btn-sm btn-ghost min-h-8 min-w-8 shrink-0 justify-center"
                    :aria-expanded="expanded"
                    :aria-controls="expanded ? `conversation-options-${message.id}` : undefined"
                    :aria-label="trans.actions"
                >
                    <i class="fa-solid fa-ellipsis" aria-hidden="true"></i>
                </button>
                <div hidden>
                    <div
                        :id="`conversation-options-${message.id}`"
                        ref="menu"
                        class="flex min-w-44 max-w-[calc(100vw-2rem)] flex-col gap-1"
                        role="group"
                        :aria-label="trans.actions"
                        @keydown.esc.stop.prevent="close"
                        @keydown.tab="leaveMenu"
                    >
                        <template v-if="confirming">
                            <p class="px-2 pt-1 text-sm">{{ trans.confirm_delete }}</p>
                            <div class="flex justify-end gap-1">
                                <button type="button" class="btn2 btn-sm btn-default" @click="cancelDelete">{{ trans.cancel }}</button>
                                <button type="button" class="btn2 btn-sm btn-error" :disabled="busy" @click="remove">{{ trans.remove }}</button>
                            </div>
                        </template>
                        <template v-else>
                            <button v-if="canEdit" type="button" :class="actionClass" :disabled="busy || editing" @click="edit">
                                <i class="fa-solid fa-pen w-4 shrink-0 text-center" aria-hidden="true"></i>
                                {{ trans.edit }}
                            </button>
                            <button type="button" :class="actionClass" @click="copy">
                                <i class="fa-regular fa-copy w-4 shrink-0 text-center" aria-hidden="true"></i>
                                {{ trans.copy }}
                            </button>
                            <button v-if="canDelete" type="button" :class="actionClass" :disabled="busy" @click="confirmDelete">
                                <i class="fa-solid fa-trash w-4 shrink-0 text-center" aria-hidden="true"></i>
                                {{ trans.remove }}
                            </button>
                        </template>
                    </div>
                </div>
            </div>
        </div>
        <p v-if="failed" class="pb-2 text-right text-sm" role="alert">{{ trans.request_failed }}</p>
    </li>
</template>

<script setup>
import { computed, nextTick, ref } from 'vue'
import { directive as vTippy } from 'vue-tippy'

const props = defineProps({
    message: Object,
    grouped: Boolean,
    endsGroup: Boolean,
    canEdit: Boolean,
    canDelete: Boolean,
    busy: Boolean,
    editing: Boolean,
    failed: Boolean,
    trans: Object,
})
const emit = defineEmits(['edit', 'remove'])
const expanded = ref(false)
const confirming = ref(false)
const trigger = ref(null)
const menu = ref(null)
const actionClass = 'flex min-h-8 w-full items-center gap-2 rounded-md px-2 py-1.5 text-left hover:bg-base-200 focus-visible:bg-base-200 disabled:opacity-50'
const timestamp = computed(() => new Date(props.message.created_at_iso).toLocaleString(document.documentElement.lang || undefined))

const popover = {
    content: () => menu.value,
    appendTo: () => document.body,
    theme: 'kanka-dropdown',
    placement: 'bottom-end',
    trigger: 'click',
    interactive: true,
    role: 'presentation',
    aria: { content: null, expanded: false },
    zIndex: 890,
    onShow() {
        expanded.value = true
    },
    onMount: focusFirstAction,
    onHide() {
        if (menu.value?.contains(document.activeElement)) trigger.value?.focus({ preventScroll: true })
        expanded.value = false
        confirming.value = false
    },
}

function close() {
    trigger.value?._tippy?.hide()
}

function focusFirstAction() {
    menu.value?.querySelector('button:not(:disabled)')?.focus({ preventScroll: true })
}

function leaveMenu(event) {
    const actions = menu.value.querySelectorAll('button:not(:disabled)')
    if (event.target === (event.shiftKey ? actions[0] : actions[actions.length - 1])) {
        if (event.shiftKey) event.preventDefault()
        close()
    }
}

async function confirmDelete() {
    confirming.value = true
    await nextTick()
    focusFirstAction()
}

async function cancelDelete() {
    confirming.value = false
    await nextTick()
    focusFirstAction()
}

function remove() {
    close()
    emit('remove')
}

function edit() {
    close()
    emit('edit')
}

async function copy() {
    try {
        await navigator.clipboard.writeText(props.message.message)
    } catch {
        window.showToast(props.trans.copy_failed, 'error')
        return
    }

    close()
    window.showToast(props.trans.copied)
}
</script>
