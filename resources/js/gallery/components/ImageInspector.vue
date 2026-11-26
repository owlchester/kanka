<template>
    <Teleport to="body">
        <div v-if="file" class="fixed inset-0 z-[1100] flex justify-end">
            <div class="fixed inset-0 bg-black/30 lg:bg-black/20" @click="$emit('close')"></div>

        <aside class="relative z-10 w-full sm:w-[420px] h-full bg-base-100 text-base-content shadow-2xl flex flex-col">
            <!-- Header -->
            <div class="flex items-center justify-between gap-2 px-4 py-3 shrink-0">
                <div class="flex items-center gap-2 min-w-0">
                    <i v-if="saving" class="fa-solid fa-spinner fa-spin text-primary text-xs" aria-label="Saving"></i>
                    <i v-else class="fa-regular fa-clipboard text-neutral-content text-xs" aria-hidden="true"></i>
                    <span class="text-xs font-semibold uppercase tracking-wide">{{ trans('details') }}</span>
                    <span v-if="saved" class="text-xs text-success flex items-center gap-1 ml-1">
                        <i class="fa-regular fa-check-double" aria-hidden="true"></i>
                        {{ trans('saved') }}
                    </span>
                    <span v-if="saveError" class="text-xs text-error-content ml-1">{{ saveError }}</span>
                </div>
                <button type="button" class="btn2 btn-ghost btn-xs" @click="$emit('close')" aria-label="Close">
                    <i class="fa-solid fa-xmark text-base" aria-hidden="true"></i>
                </button>
            </div>

            <!-- Scrollable Body -->
            <div class="flex-1 overflow-y-auto p-4 flex flex-col gap-4">
                <!-- Preview / Font Sample -->
                <div v-if="!file.is_folder && file.original" class="relative rounded-xl overflow-hidden bg-base-200 group cursor-pointer" @click="$emit('lightbox', file)">
                    <img
                        :src="file.original"
                        :alt="file.name"
                        class="w-full max-h-56 object-contain mx-auto"
                    />
                    <div class="absolute bottom-2 right-2 px-2 py-1 rounded-lg bg-black/60 text-white text-xs opacity-80 group-hover:opacity-100">
                        <i class="fa-regular fa-magnifying-glass-plus mr-1" aria-hidden="true"></i>
                        {{ file.width && file.height ? `${file.width} × ${file.height}` : '' }}
                    </div>
                </div>

                <div v-else-if="file.is_font" class="rounded-xl bg-base-200 p-4 flex flex-col gap-3">
                    <div class="text-2xl text-center py-2" :style="{ fontFamily: fontFamilyName }">
                        {{ trans('font_sample') }}
                    </div>
                    <button type="button" class="btn2 btn-default btn-xs self-center" @click="copyFontCss">
                        <i class="fa-regular fa-code" aria-hidden="true"></i>
                        <span>{{ trans('font_copy_css') }}</span>
                    </button>
                </div>

                <!-- Quick Actions -->
                <div v-if="!file.is_folder" class="flex flex-wrap gap-1.5">
                    <button type="button" class="btn2 btn-default btn-xs" @click="$emit('copy-url', file)">
                        <i class="fa-regular fa-link" aria-hidden="true"></i>
                        <span>{{ trans('copy_url') }}</span>
                    </button>
                    <button type="button" class="btn2 btn-default btn-xs" @click="$emit('copy-admin-link', file)">
                        <i class="fa-regular fa-share-nodes" aria-hidden="true"></i>
                        <span>{{ trans('copy_admin_link') }}</span>
                    </button>
                    <a :href="file.link" :download="file.name" class="btn2 btn-default btn-xs">
                        <i class="fa-regular fa-download" aria-hidden="true"></i>
                        <span>{{ trans('download') }}</span>
                    </a>
                    <button v-if="file.can_edit && !file.is_font && !file.is_svg" type="button" class="btn2 btn-default btn-xs" @click="$emit('focus', file)">
                        <i class="fa-regular fa-bullseye" aria-hidden="true"></i>
                        <span>{{ trans('focus_point') }}</span>
                    </button>
                    <button v-if="file.can_edit" type="button" class="btn2 btn-default btn-xs" :disabled="replacing" @click="replaceInputRef?.click()">
                        <i :class="replacing ? 'fa-solid fa-spinner fa-spin' : 'fa-regular fa-arrows-rotate'" aria-hidden="true"></i>
                        <span>{{ trans('replace_file') }}</span>
                    </button>
                    <input ref="replaceInputRef" type="file" accept="image/*, .svg, .woff2" class="hidden" @change="onReplaceSelected" />
                </div>

                <p v-if="!file.is_folder && file.can_edit" class="text-[11px] text-neutral-content -mt-2">
                    {{ trans('replace_hint') }}
                </p>

                <!-- Editable Fields -->
                <div class="flex flex-col gap-1">
                    <label class="text-xs font-semibold uppercase tracking-wide text-neutral-content">{{ trans('name') }}</label>
                    <input
                        v-if="file.can_edit"
                        type="text"
                        maxlength="191"
                        class="w-full bg-base-200 rounded-lg px-3 py-1.5 text-sm"
                        v-model="name"
                        @change="saveField"
                    />
                    <span v-else class="text-sm font-medium">{{ name }}</span>
                </div>

                <template v-if="!file.is_folder">
                    <div class="flex flex-col gap-1">
                        <label class="text-xs font-semibold uppercase tracking-wide text-neutral-content">{{ trans('description') }}</label>
                        <textarea
                            v-if="file.can_edit"
                            v-model="description"
                            maxlength="1000"
                            rows="3"
                            class="w-full bg-base-200 rounded-lg px-3 py-1.5 text-sm"
                            @change="saveField"
                        ></textarea>
                        <span v-else class="text-sm text-base-content/80">{{ description || '—' }}</span>
                    </div>

                    <div class="flex flex-col gap-1">
                        <label class="text-xs font-semibold uppercase tracking-wide text-neutral-content">{{ trans('author') }}</label>
                        <input
                            v-if="file.can_edit"
                            type="text"
                            v-model="author"
                            maxlength="191"
                            class="w-full bg-base-200 rounded-lg px-3 py-1.5 text-sm"
                            @change="saveField"
                        />
                        <span v-else class="text-sm">{{ author || '—' }}</span>
                    </div>
                </template>

                <div v-if="file.can_edit" class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div class="flex flex-col gap-1">
                        <label class="text-xs font-semibold uppercase tracking-wide text-neutral-content">{{ trans('visibility') }}</label>
                        <select class="w-full bg-base-200 rounded-lg px-2.5 py-1.5 text-sm" v-model="visibilityId" @change="saveField">
                            <option v-for="(label, id) in visibilities" :key="id" :value="Number(id)">{{ label }}</option>
                        </select>
                    </div>

                    <div class="flex flex-col gap-1">
                        <label class="text-xs font-semibold uppercase tracking-wide text-neutral-content">{{ trans('folder') }}</label>
                        <select class="w-full bg-base-200 rounded-lg px-2.5 py-1.5 text-sm" v-model="folderId" @change="saveFolderMove">
                            <option value="">{{ trans('home') }}</option>
                            <option v-for="f in availableTargetFolders" :key="f.id" :value="f.id">{{ f.name }}</option>
                        </select>
                    </div>
                </div>

                <!-- Categorized Used In -->
                <div v-if="!file.is_folder" class="flex flex-col gap-2 bg-base-200/50 rounded-xl p-3">
                    <div class="text-xs font-semibold uppercase tracking-wide text-neutral-content flex items-center gap-1.5">
                        <i class="fa-regular fa-cubes" aria-hidden="true"></i>
                        <span>{{ trans('used_in') }}</span>
                    </div>

                    <div v-if="loadingDetails" class="py-2 text-xs text-neutral-content flex items-center gap-2">
                        <i class="fa-solid fa-spinner fa-spin" aria-hidden="true"></i>
                        <span>{{ trans('checking_usage') }}</span>
                    </div>

                    <template v-else-if="usages">
                        <div v-if="!hasAnyUsage" class="text-xs text-neutral-content">
                            {{ trans('unused') }}
                        </div>

                        <div v-if="usages.entry_mentions.length > 0" class="flex flex-col gap-1">
                            <span class="text-xs font-medium">{{ trans('usage_entry_mentions') }}</span>
                            <p class="text-[11px] text-warning-content">{{ trans('usage_entry_mentions_note') }}</p>
                            <div class="flex flex-wrap gap-1.5 mt-0.5">
                                <a v-for="(m, idx) in usages.entry_mentions" :key="idx" :href="m.url" target="_blank" class="px-2 py-0.5 rounded-lg bg-base-100 text-xs hover:underline truncate max-w-full">
                                    {{ m.name }}
                                </a>
                            </div>
                        </div>

                        <div v-for="group in otherUsageGroups" :key="group.label" class="flex flex-col gap-1">
                            <span class="text-xs font-medium">{{ group.label }}</span>
                            <div class="flex flex-wrap gap-1.5">
                                <a v-for="(item, idx) in group.items" :key="idx" :href="item.url" target="_blank" class="px-2 py-0.5 rounded-lg bg-base-100 text-xs hover:underline truncate max-w-full">
                                    {{ item.name }}
                                </a>
                            </div>
                        </div>

                        <div v-if="usages.is_default" class="text-xs font-medium text-primary">
                            {{ trans('usage_default') }}
                        </div>
                    </template>
                </div>

                <!-- File Metadata Grid -->
                <div v-if="!file.is_folder" class="grid grid-cols-2 gap-y-1.5 text-xs bg-base-200/40 rounded-xl p-3">
                    <span class="text-neutral-content">{{ trans('size') }}</span>
                    <span class="text-right tabular-nums">{{ file.size }}</span>

                    <template v-if="file.width && file.height">
                        <span class="text-neutral-content">{{ trans('dimensions') }}</span>
                        <span class="text-right tabular-nums">{{ file.width }} × {{ file.height }}</span>
                    </template>

                    <span class="text-neutral-content">{{ trans('file_type') }}</span>
                    <span class="text-right uppercase">{{ file.ext }}</span>

                    <span class="text-neutral-content">{{ trans('uploaded_by') }}</span>
                    <span class="text-right truncate">{{ file.creator }}</span>

                    <template v-if="file.updated_at_human">
                        <span class="text-neutral-content">{{ trans('updated_at') }}</span>
                        <span class="text-right">{{ file.updated_at_human }}</span>
                    </template>
                </div>
            </div>

            <!-- Footer -->
            <div v-if="file.can_edit || !file.is_folder" class="px-4 py-3 flex items-center justify-between shrink-0">
                <a v-if="!file.is_folder" :href="file.link" target="_blank" class="btn2 btn-ghost btn-sm">
                    <i class="fa-solid fa-external-link" aria-hidden="true"></i>
                    <span>{{ trans('open') }}</span>
                </a>
                <span v-else></span>
                <button v-if="file.can_edit" type="button" class="btn2 btn-error btn-sm" @click="$emit('delete', file)">
                    <i class="fa-regular fa-trash-can" aria-hidden="true"></i>
                    <span>{{ trans('delete') }}</span>
                </button>
            </div>
        </aside>
        </div>
    </Teleport>
</template>

<script setup lang="ts">
import { computed, ref, watch } from 'vue'
import axios from 'axios'
import type { GalleryFileItem, GalleryFolderNode, GalleryUsages } from '../types'

const props = defineProps<{
    file: GalleryFileItem | null
    visibilities: Record<string, string>
    folderTree: GalleryFolderNode[]
    trans: (key: string) => string
}>()

const emit = defineEmits<{
    (e: 'close'): void
    (e: 'updated', file: GalleryFileItem, movedFolderChanged: boolean): void
    (e: 'replaced', file: GalleryFileItem, usedSpace: number): void
    (e: 'delete', file: GalleryFileItem): void
    (e: 'focus', file: GalleryFileItem): void
    (e: 'lightbox', file: GalleryFileItem): void
    (e: 'copy-url', file: GalleryFileItem): void
    (e: 'copy-admin-link', file: GalleryFileItem): void
}>()

const loadingDetails = ref(false)
const usages = ref<GalleryUsages | null>(null)
const saving = ref(false)
const saved = ref(false)
const saveError = ref<string | null>(null)
const replacing = ref(false)
const replaceInputRef = ref<HTMLInputElement | null>(null)

const name = ref('')
const description = ref('')
const author = ref('')
const visibilityId = ref(1)
const folderId = ref('')

const fontFamilyName = computed(() => props.file ? `kanka-preview-${props.file.id.slice(0, 8)}` : '')

const injectFontPreview = (file: GalleryFileItem) => {
    if (!file.is_font) return
    const id = `font-style-${file.id}`
    if (document.getElementById(id)) return
    const style = document.createElement('style')
    style.id = id
    style.textContent = `@font-face { font-family: '${fontFamilyName.value}'; src: url('${file.link}') format('woff2'); }`
    document.head.appendChild(style)
}

watch(() => props.file?.id, async () => {
    const f = props.file
    if (!f) return
    name.value = f.name || ''
    description.value = f.description || ''
    author.value = f.author || ''
    visibilityId.value = Number(f.visibility_id)
    folderId.value = f.folder_id || ''
    saving.value = false
    saved.value = false
    saveError.value = null
    usages.value = null

    if (f.is_font) {
        injectFontPreview(f)
    }

    if (!f.is_folder) {
        loadingDetails.value = true
        try {
            const res = await axios.get(f.api.show)
            usages.value = res.data.data?.usages ?? null
        } catch {
            // Non-fatal
        } finally {
            loadingDetails.value = false
        }
    }
}, { immediate: true })

const availableTargetFolders = computed(() => {
    if (!props.file) return props.folderTree
    return props.folderTree.filter(f => f.id !== props.file!.id)
})

const hasAnyUsage = computed(() => {
    if (!usages.value) return false
    const u = usages.value
    return u.is_default
        || u.entry_mentions.length > 0
        || u.entity_images.length > 0
        || u.entity_headers.length > 0
        || u.map_layers.length > 0
        || u.entity_assets.length > 0
        || u.inventories.length > 0
})

const otherUsageGroups = computed(() => {
    if (!usages.value) return []
    const u = usages.value
    const groups: Array<{ label: string; items: Array<{ name: string; url: string }> }> = []
    if (u.entity_images.length) groups.push({ label: props.trans('usage_entity_images'), items: u.entity_images })
    if (u.entity_headers.length) groups.push({ label: props.trans('usage_entity_headers'), items: u.entity_headers })
    if (u.map_layers.length) groups.push({ label: props.trans('usage_map_layers'), items: u.map_layers })
    if (u.entity_assets.length) groups.push({ label: props.trans('usage_entity_assets'), items: u.entity_assets })
    if (u.inventories.length) groups.push({ label: props.trans('usage_inventories'), items: u.inventories })
    return groups
})

const saveField = async () => {
    if (!props.file || saving.value) return
    saving.value = true
    saved.value = false
    saveError.value = null
    try {
        const res = await axios.post(props.file.api.update, {
            name: name.value,
            description: description.value || null,
            author: author.value || null,
            visibility_id: visibilityId.value,
        })
        saved.value = true
        emit('updated', res.data.data, false)
    } catch (err: any) {
        saveError.value = err.response?.data?.message ?? 'Save failed'
    } finally {
        saving.value = false
    }
}

const saveFolderMove = async () => {
    if (!props.file || saving.value) return
    saving.value = true
    saved.value = false
    saveError.value = null
    try {
        const res = await axios.post(props.file.api.update, {
            name: name.value,
            description: description.value || null,
            author: author.value || null,
            visibility_id: visibilityId.value,
            folder_id: folderId.value || null,
        })
        saved.value = true
        emit('updated', res.data.data, true)
    } catch (err: any) {
        folderId.value = props.file.folder_id || ''
        saveError.value = err.response?.data?.message ?? 'Move failed'
    } finally {
        saving.value = false
    }
}

const onReplaceSelected = async (e: Event) => {
    const input = e.target as HTMLInputElement
    const selected = input.files?.[0]
    if (!selected || !props.file || replacing.value) return

    replacing.value = true
    const formData = new FormData()
    formData.append('file', selected)

    try {
        const res = await axios.post(props.file.api.replace, formData, {
            headers: { 'Content-Type': 'multipart/form-data' },
        })
        window.showToast?.(res.data.toast)
        emit('replaced', res.data.data, res.data.used)
    } catch (err: any) {
        const msg = err.response?.data?.error
            ?? err.response?.data?.errors?.file?.[0]
            ?? err.response?.data?.message
            ?? 'Replace failed'
        window.showToast?.(msg, 'error')
    } finally {
        replacing.value = false
        input.value = ''
    }
}

const copyFontCss = async () => {
    if (!props.file) return
    const css = `@font-face {\n  font-family: '${props.file.name}';\n  src: url('${props.file.link}') format('woff2');\n  font-display: swap;\n}`
    await navigator.clipboard.writeText(css)
    window.showToast?.(props.trans('copied'))
}
</script>
