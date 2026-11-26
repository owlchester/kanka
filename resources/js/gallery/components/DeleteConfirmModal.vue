<template>
    <dialog
        ref="dialogRef"
        class="dialog rounded-2xl bg-base-100 text-base-content p-0 w-full! max-w-xl!"
        @click.self="close"
    >
        <header class="flex items-center justify-between p-4 md:p-5">
            <div class="flex items-center gap-2 text-error-content">
                <i class="fa-regular fa-triangle-exclamation" aria-hidden="true"></i>
                <h4 class="text-lg font-medium">{{ trans('delete_title') }}</h4>
            </div>
            <button type="button" class="text-base-content cursor-pointer" @click="close" :aria-label="trans('cancel')">
                <i class="fa-regular fa-circle-xmark text-lg" aria-hidden="true"></i>
            </button>
        </header>

        <article class="px-4 md:px-6 pb-4 flex flex-col gap-3 max-h-[65vh] overflow-y-auto text-sm">
            <div v-if="loading" class="py-8 flex items-center justify-center gap-2 text-neutral-content">
                <i class="fa-solid fa-spinner fa-spin" aria-hidden="true"></i>
                <span>{{ trans('checking_usage') }}</span>
            </div>

            <template v-else-if="preview">
                <div class="bg-base-200 rounded-xl p-3 flex flex-wrap items-center justify-between gap-2 text-xs md:text-sm">
                    <span class="font-medium">
                        {{ preview.total_files }} file(s)
                        <template v-if="preview.total_folders > 0">
                            · {{ preview.total_folders }} folder(s)
                        </template>
                    </span>
                    <span class="text-neutral-content tabular-nums">{{ preview.total_size_readable }}</span>
                </div>

                <div v-if="preview.total_folders > 0" class="alert alert-warning p-3 rounded-xl text-xs">
                    <i class="fa-regular fa-folder-open mr-1.5" aria-hidden="true"></i>
                    {{ trans('delete_folder_warning') }}
                </div>

                <div v-if="preview.has_entry_mentions" class="alert alert-error p-3 rounded-xl text-xs flex flex-col gap-2">
                    <div class="font-medium flex items-start gap-2">
                        <i class="fa-regular fa-link-slash mt-0.5 shrink-0" aria-hidden="true"></i>
                        <span>{{ trans('delete_entry_warning') }}</span>
                    </div>
                    <div class="flex flex-wrap gap-1.5">
                        <a
                            v-for="(m, idx) in preview.impacts.entry_mentions"
                            :key="idx"
                            :href="m.url"
                            target="_blank"
                            class="px-2 py-0.5 rounded bg-black/15 hover:bg-black/25 text-xs underline truncate max-w-xs"
                        >
                            {{ m.name }}
                        </a>
                    </div>
                </div>

                <div v-if="preview.impacts.entity_assets.length > 0" class="alert alert-warning p-3 rounded-xl text-xs flex flex-col gap-1.5">
                    <div class="font-medium">{{ trans('delete_asset_warning') }}</div>
                    <div class="flex flex-wrap gap-1.5">
                        <a
                            v-for="(a, idx) in preview.impacts.entity_assets"
                            :key="idx"
                            :href="a.url"
                            target="_blank"
                            class="px-2 py-0.5 rounded bg-black/10 hover:bg-black/20 text-xs underline"
                        >
                            {{ a.name }}
                        </a>
                    </div>
                </div>

                <div v-if="otherImpactGroups.length > 0" class="flex flex-col gap-2">
                    <div v-for="group in otherImpactGroups" :key="group.label" class="bg-base-200/70 rounded-xl p-3 flex flex-col gap-1.5">
                        <span class="text-xs font-semibold uppercase tracking-wide text-neutral-content">{{ group.label }}</span>
                        <div class="flex flex-wrap gap-1.5">
                            <a
                                v-for="(item, idx) in group.items"
                                :key="idx"
                                :href="item.url"
                                target="_blank"
                                class="px-2 py-0.5 rounded bg-base-100 text-xs hover:underline truncate max-w-xs"
                            >
                                {{ item.name }}
                            </a>
                        </div>
                    </div>
                </div>

                <p v-if="!preview.has_impacts && preview.total_folders === 0" class="text-xs text-neutral-content">
                    {{ trans('delete_unused_note') }}
                </p>
            </template>
        </article>

        <footer class="px-4 md:px-6 py-3 flex items-center justify-end gap-2">
            <button type="button" class="btn2 btn-default btn-sm" :disabled="deleting" @click="close">
                {{ trans('cancel') }}
            </button>
            <button
                type="button"
                class="btn2 btn-error btn-sm"
                :disabled="loading || deleting"
                @click="$emit('confirm')"
            >
                <i v-if="deleting" class="fa-solid fa-spinner fa-spin" aria-hidden="true"></i>
                <span>{{ trans('delete_permanently') }}</span>
            </button>
        </footer>
    </dialog>
</template>

<script setup lang="ts">
import { computed, ref, watch } from 'vue'
import axios from 'axios'
import type { DeletePreviewData } from '../types'

const props = defineProps<{
    open: boolean
    ids: string[]
    previewApi: string
    deleting: boolean
    trans: (key: string) => string
}>()

const emit = defineEmits<{
    (e: 'close'): void
    (e: 'confirm'): void
}>()

const dialogRef = ref<HTMLDialogElement | null>(null)
const loading = ref(false)
const preview = ref<DeletePreviewData | null>(null)

watch(() => props.open, async (isOpen) => {
    if (!isOpen) {
        dialogRef.value?.close()
        return
    }
    dialogRef.value?.showModal()
    if (!props.ids.length) return
    loading.value = true
    preview.value = null
    try {
        const res = await axios.post(props.previewApi, { images: props.ids })
        preview.value = res.data
    } catch (err: any) {
        window.showToast?.(err.response?.data?.message ?? 'Failed to check item usage', 'error')
        close()
    } finally {
        loading.value = false
    }
})

const otherImpactGroups = computed(() => {
    if (!preview.value) return []
    const groups: Array<{ label: string; items: Array<{ name: string; url: string }> }> = []
    const imp = preview.value.impacts
    if (imp.entity_images.length) groups.push({ label: props.trans('usage_entity_images'), items: imp.entity_images })
    if (imp.entity_headers.length) groups.push({ label: props.trans('usage_entity_headers'), items: imp.entity_headers })
    if (imp.map_layers.length) groups.push({ label: props.trans('usage_map_layers'), items: imp.map_layers })
    if (imp.inventories.length) groups.push({ label: props.trans('usage_inventories'), items: imp.inventories })
    return groups
})

const close = () => {
    if (props.deleting) return
    dialogRef.value?.close()
    emit('close')
}
</script>
