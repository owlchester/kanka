<template>
    <aside v-if="pin" class="fixed top-0 right-0 h-screen w-80 bg-base-100 shadow-lg z-[1100] flex flex-col overflow-y-auto">
        <div
            class="p-4 flex flex-col justify-end bg-cover bg-center"
            :style="preview?.entity_image ? { backgroundImage: `url('${preview.entity_image}')` } : {}"
        >
            <div class="flex items-center justify-between gap-2">
                <h2 class="text-lg font-semibold">
                    <a v-if="preview?.entity_url" :href="preview.entity_url">{{ pin.name }}</a>
                    <template v-else>{{ pin.name }}</template>
                </h2>
                <button class="btn2 btn-default btn-sm flex-none" @click="$emit('close')">
                    <i class="fa-solid fa-xmark" aria-hidden="true" />
                </button>
            </div>
        </div>

        <div v-if="loading" class="p-4 flex items-center gap-2">
            <i class="fa-solid fa-spinner fa-spin" aria-hidden="true" />
            <span>loading....</span>
        </div>

        <div v-else-if="preview" class="p-4 flex flex-col gap-3 grow">
            <p class="text-sm opacity-75">{{ preview.type }} - {{ preview.group_name || 'Uncategorised' }}</p>

            <div v-if="preview.marker_entry" v-html="preview.marker_entry"></div>

            <template v-if="preview.entity_entry">
                <p v-if="preview.marker_entry" class="text-sm font-semibold">From entry</p>
                <div v-html="preview.entity_entry"></div>
            </template>

            <div class="mt-auto flex flex-col gap-2 pt-4">
                <a
                    v-if="preview.can_edit && preview.edit_url"
                    :href="preview.edit_url"
                    target="_blank"
                    class="btn2 btn-primary btn-block"
                >
                    Edit details
                </a>

                <div class="flex gap-2">
                    <button class="btn2 btn-default grow" @click="$emit('center')">Center</button>
                    <button v-if="preview.can_edit" class="btn2 grow" @click="duplicate">Duplicate</button>
                </div>

                <button v-if="preview.can_edit" class="btn2 btn-danger" @click="handleDelete">
                    {{ confirming ? 'Click again to confirm' : 'Delete marker' }}
                </button>
                <p v-if="error" class="text-sm text-error-content">{{ error }}</p>
            </div>
        </div>
    </aside>
</template>

<script setup>
import { ref, watch } from 'vue'

const props = defineProps({
    pin: { type: Object, default: null },
})

const emit = defineEmits(['close', 'center', 'deleted'])

const loading = ref(false)
const preview = ref(null)
const confirming = ref(false)
const error = ref(null)

function duplicate() {
    // No-op for now.
}

async function handleDelete() {
    if (! confirming.value) {
        confirming.value = true
        error.value = null

        return
    }

    try {
        const res = await axios.delete(props.pin.destroy_url)
        if (res.status === 204) {
            emit('deleted', props.pin)
        }
    } catch (e) {
        confirming.value = false
        error.value = 'Unable to delete this marker.'
    }
}

async function load(pin) {
    confirming.value = false
    error.value = null
    preview.value = null

    if (! pin) {
        return
    }

    loading.value = true
    try {
        const res = await axios.get(pin.preview_url)
        preview.value = res.data
    } finally {
        loading.value = false
    }
}

watch(() => props.pin, load, { immediate: true })
</script>
