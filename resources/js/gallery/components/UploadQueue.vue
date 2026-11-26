<template>
    <div
        v-if="items.length > 0"
        class="fixed bottom-4 right-4 z-[65] w-80 max-w-[calc(100vw-2rem)] bg-base-100 rounded-2xl shadow-2xl overflow-hidden flex flex-col"
    >
        <div class="flex items-center justify-between px-4 py-2.5 bg-base-200/70 text-sm font-medium">
            <div class="flex items-center gap-2">
                <i v-if="hasActive" class="fa-solid fa-spinner fa-spin text-primary" aria-hidden="true"></i>
                <i v-else class="fa-regular fa-circle-check text-success" aria-hidden="true"></i>
                <span>{{ uploadSummary }}</span>
            </div>
            <button type="button" class="text-neutral-content hover:text-base-content cursor-pointer" @click="$emit('clear-finished')" aria-label="Close">
                <i class="fa-solid fa-xmark" aria-hidden="true"></i>
            </button>
        </div>

        <div class="max-h-60 overflow-y-auto divide-y divide-base-200">
            <div v-for="item in items" :key="item.uid" class="p-3 flex flex-col gap-1.5 text-xs">
                <div class="flex items-center justify-between gap-2">
                    <span class="truncate font-medium">{{ item.name }}</span>
                    <div class="flex items-center gap-1.5 shrink-0">
                        <span v-if="item.status === 'uploading'" class="tabular-nums text-neutral-content">{{ item.progress }}%</span>
                        <button
                            v-if="item.status === 'uploading' || item.status === 'queued'"
                            type="button"
                            class="text-error-content hover:underline cursor-pointer"
                            @click="$emit('cancel', item.uid)"
                        >
                            {{ trans('cancel') }}
                        </button>
                        <button
                            v-else-if="item.status === 'error'"
                            type="button"
                            class="text-primary hover:underline cursor-pointer"
                            @click="$emit('retry', item.uid)"
                        >
                            Retry
                        </button>
                        <i v-else-if="item.status === 'done'" class="fa-solid fa-check text-success" aria-hidden="true"></i>
                    </div>
                </div>

                <div v-if="item.status === 'uploading' || item.status === 'queued'" class="w-full h-1 bg-base-200 rounded-full overflow-hidden">
                    <div class="h-1 bg-primary transition-all duration-150" :style="{ width: item.progress + '%' }"></div>
                </div>

                <p v-if="item.error" class="text-error-content">{{ item.error }}</p>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { computed } from 'vue'
import type { UploadQueueItem } from '../types'

const props = defineProps<{
    items: UploadQueueItem[]
    trans: (key: string) => string
}>()

defineEmits<{
    (e: 'cancel', uid: string): void
    (e: 'retry', uid: string): void
    (e: 'clear-finished'): void
}>()

const hasActive = computed(() => props.items.some(i => i.status === 'uploading' || i.status === 'queued'))

const uploadSummary = computed(() => {
    const active = props.items.filter(i => i.status === 'uploading' || i.status === 'queued').length
    if (active > 0) {
        return `${props.trans('upload_files')} (${active})`
    }
    const errors = props.items.filter(i => i.status === 'error').length
    if (errors > 0) {
        return `${props.items.length - errors}/${props.items.length} uploaded`
    }
    return `${props.items.length} uploaded`
})
</script>
