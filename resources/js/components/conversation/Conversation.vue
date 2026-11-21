<template>
    <div class="box-conversation flex min-w-0 flex-col overflow-hidden rounded-xl bg-base-100">
        <div
            ref="transcript"
            class="box-comments max-h-[60dvh] min-h-32 overflow-y-auto overscroll-contain p-4 [overflow-anchor:none] sm:px-6"
            role="region"
            :aria-label="trans.messages"
            tabindex="0"
        >
            <div v-if="loading" class="py-8 text-center text-sm text-base-content/75" role="status">
                {{ trans.loading }}
            </div>
            <div v-else-if="!ready" class="flex flex-col items-center gap-2 py-8 text-sm">
                <p role="alert">{{ trans.request_failed }}</p>
                <button type="button" class="btn2 btn-sm btn-default" @click="loadThread">{{ trans.retry }}</button>
            </div>
            <template v-else>
                <div v-if="hasEarlier" class="flex flex-col items-center gap-2 pb-3 pt-1">
                    <button
                        type="button"
                        class="btn2 btn-sm btn-default"
                        :aria-disabled="loadingEarlier || busy"
                        @click="loadEarlier"
                    >
                        {{ loadingEarlier ? trans.loading : trans.load_previous }}
                    </button>
                    <p v-if="historyError" class="text-sm" role="alert">{{ trans.request_failed }}</p>
                </div>

                <p v-if="!messages.length" class="flex flex-col gap-1 py-8 text-center text-sm" role="status">
                    <strong>{{ trans.empty }}</strong>
                    <span v-if="canPost" class="text-base-content/75">{{ trans.first_message }}</span>
                </p>
                <ol v-else ref="messageList" class="m-0 list-none p-0">
                    <Message
                        v-for="(message, index) in messages"
                        :key="message.id"
                        :message="message"
                        :grouped="groupsWith(message, messages[index - 1])"
                        :ends-group="!groupsWith(messages[index + 1], message)"
                        :can-edit="canManage && !closed && message.can_edit"
                        :can-delete="canManage && message.can_delete"
                        :busy="busy || loadingEarlier"
                        :editing="editing?.id === message.id"
                        :failed="failedDelete === message.id"
                        :trans="trans"
                        @edit="startEdit(message)"
                        @remove="removeMessage(message)"
                    />
                </ol>
            </template>
        </div>

        <div v-if="refreshError" class="flex flex-wrap items-center gap-2 px-4 pb-3 text-sm sm:px-6">
            <p role="alert">{{ trans.refresh_failed }}</p>
            <button type="button" class="btn2 btn-sm btn-default" :disabled="busy || loadingEarlier" @click="refresh">{{ trans.retry }}</button>
        </div>

        <Form
            v-if="ready && (canPost || editing)"
            ref="composer"
            v-model="body"
            v-model:speaker="speaker"
            :speakers="speakers"
            :editing="editing"
            :busy="saving"
            :blocked="busy || loadingEarlier"
            :error="writeError"
            :trans="trans"
            @submit="submitMessage"
            @cancel="cancelEdit"
        />
        <div v-else-if="closed || (canManage && !canPost)" class="flex flex-wrap items-center gap-2 bg-base-200 px-4 py-3 text-sm sm:px-6">
            <i :class="closed ? 'fa-solid fa-lock' : 'fa-solid fa-users'" aria-hidden="true"></i>
            <p>{{ closed ? trans.is_closed : trans.no_speaker }}</p>
            <button
                v-if="!closed && participants"
                type="button"
                class="btn2 btn-sm btn-default"
                @click="openParticipants"
            >{{ trans.participants }}</button>
        </div>
    </div>
</template>

<script setup>
import { computed, nextTick, onMounted, ref } from 'vue'
import Form from './Form.vue'
import Message from './Message.vue'
import { groupsWith, mergeMessages, readNewerMessages } from './thread.js'

const props = defineProps({
    api: String,
    send: String,
    target: String,
    speakers: Array,
    closed: Boolean,
    canManage: Boolean,
    participants: String,
    trans: Object,
})

const transcript = ref(null)
const messageList = ref(null)
const composer = ref(null)
const messages = ref([])
const ready = ref(false)
const loading = ref(true)
const hasEarlier = ref(false)
const loadingEarlier = ref(false)
const historyError = ref(false)
const refreshing = ref(false)
const refreshError = ref(false)
const saving = ref(false)
const deleting = ref(false)
const failedDelete = ref(null)
const writeError = ref('')
const editing = ref(null)
const draft = ref('')
const editBody = ref('')
const speaker = ref(props.speakers[0]?.id ?? null)
let newest = 0

const canPost = computed(() => props.canManage && !props.closed && (props.target === 'user' || props.speakers.length > 0))
const busy = computed(() => saving.value || deleting.value || refreshing.value)
const body = computed({
    get: () => editing.value ? editBody.value : draft.value,
    set: value => {
        if (editing.value) editBody.value = value
        else draft.value = value
    },
})

function openParticipants() {
    window.openDialog('primary-dialog', props.participants)
}

function scrollToLatest() {
    transcript.value.scrollTop = transcript.value.scrollHeight
}

async function loadThread() {
    loading.value = true
    try {
        const { data } = await window.axios.get(props.api)
        messages.value = data.data.messages
        hasEarlier.value = data.data.previous
        newest = messages.value.at(-1)?.id ?? 0
        ready.value = true
    } catch {
        ready.value = false
    } finally {
        loading.value = false
    }
    if (ready.value) {
        await nextTick()
        scrollToLatest()
    }
}

async function loadEarlier(event) {
    const oldest = messages.value[0]?.id
    if (!hasEarlier.value || loadingEarlier.value || busy.value || !oldest) return
    const button = event.currentTarget
    loadingEarlier.value = true
    historyError.value = false
    try {
        const { data } = await window.axios.get(props.api, { params: { oldest } })
        const anchor = messageList.value.firstElementChild
        const previousTop = anchor.getBoundingClientRect().top
        const restoreFocus = document.activeElement === button
        messages.value = mergeMessages(messages.value, data.data.messages)
        hasEarlier.value = data.data.previous
        loadingEarlier.value = false
        await nextTick()
        transcript.value.scrollTop += anchor.getBoundingClientRect().top - previousTop
        if (restoreFocus && (!hasEarlier.value || button.getBoundingClientRect().bottom <= transcript.value.getBoundingClientRect().top)) {
            transcript.value.focus({ preventScroll: true })
        }
    } catch {
        historyError.value = true
    } finally {
        loadingEarlier.value = false
    }
}

async function refresh() {
    if (refreshing.value) return
    refreshing.value = true
    refreshError.value = false
    try {
        await readNewerMessages(newest, async cursor => {
            const { data } = await window.axios.get(props.api, { params: { newest: cursor } })
            return data.data
        }, async (incoming, cursor) => {
            const box = transcript.value
            const atEnd = box.scrollHeight - box.scrollTop - box.clientHeight < 32
            messages.value = mergeMessages(incoming, messages.value)
            newest = cursor
            await nextTick()
            if (atEnd) scrollToLatest()
        })
    } catch {
        refreshError.value = true
    } finally {
        refreshing.value = false
    }
}

async function startEdit(message) {
    if (busy.value || loadingEarlier.value || editing.value?.id === message.id) return
    editing.value = message
    editBody.value = message.message
    writeError.value = ''
    await nextTick()
    composer.value?.focus()
}

async function cancelEdit() {
    const id = editing.value?.id
    editing.value = null
    writeError.value = ''
    await nextTick()
    document.getElementById(`conversation-actions-${id}`)?.focus({ preventScroll: true })
}

async function submitMessage() {
    const text = body.value.trim()
    if (busy.value || loadingEarlier.value || !text) return
    const original = editing.value
    if (!original && (!canPost.value || (props.target === 'entity' && speaker.value === null))) return
    saving.value = true
    writeError.value = ''
    let sent = false
    try {
        if (original) {
            const { data } = await window.axios.put(original.delete_url, { message: text })
            messages.value = mergeMessages(messages.value, [data.data])
            await cancelEdit()
        } else {
            const payload = { message: text }
            if (props.target === 'entity') payload.entity_id = speaker.value
            const { data } = await window.axios.post(props.send, payload)
            messages.value = mergeMessages(messages.value, [data.data])
            draft.value = ''
            sent = true
        }
    } catch (error) {
        const response = error.response
        writeError.value = response?.status === 422 ? (Object.values(response.data?.errors ?? {})[0]?.[0] ?? props.trans.request_failed) : props.trans.request_failed
    } finally {
        saving.value = false
    }
    if (sent) {
        await nextTick()
        scrollToLatest()
        composer.value?.focus()
        await refresh()
    } else if (writeError.value) {
        await nextTick()
        composer.value?.focus()
    }
}

async function removeMessage(message) {
    if (busy.value || loadingEarlier.value) return
    deleting.value = true
    failedDelete.value = null
    try {
        await window.axios.delete(message.delete_url)
        if (editing.value?.id === message.id) await cancelEdit()
        const index = messages.value.findIndex(item => item.id === message.id)
        messages.value = messages.value.filter(item => item.id !== message.id)
        if (!messages.value.length && hasEarlier.value) await loadThread()
        else {
            await nextTick()
            if (document.activeElement === document.body) {
                const neighbor = messages.value[index] ?? messages.value.at(-1)
                const fallback = document.getElementById(`conversation-actions-${neighbor?.id}`) ?? transcript.value
                fallback.focus({ preventScroll: true })
            }
        }
    } catch {
        failedDelete.value = message.id
    } finally {
        deleting.value = false
    }
}

onMounted(loadThread)
</script>
