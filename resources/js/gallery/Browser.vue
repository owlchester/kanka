<template>

    <dialog class="dialog rounded-2xl bg-base-100 text-base-content" id="gallery-dialog" ref="galleryDialog" aria-modal="true" aria-labelledby="modal-card-label">
        <header class="flex gap-6 items-center p-4 md:p-6 justify-between">
            <h4 v-html="trans.browse.title" class="text-lg font-normal"></h4>
            <button type="button" class="text-base-content" @click="closeBrowser()" title="Close">
                <i class="fa-regular fa-circle-xmark" aria-hidden="true"></i>
                <span class="sr-only">Close</span>
            </button>
        </header>
        <article class="max-w-4xl p-4 flex flex-col gap-4 md:min-w-2xl">
            <div class="flex gap-2 justify-between" v-if="!loading && !error">
                <div class="grow">
                    <input type="text" class="w-full" :placeholder="trans.browse.search.placeholder" @input="handleInput" />
                </div>

                <div class="flex rounded-lg bg-base-200 p-0.5 text-xs gap-0.5 shrink-0">
                    <button
                        type="button"
                        class="rounded px-2 py-1 transition-colors cursor-pointer flex gap-1 items-center"
                        :class="mode === 'large' ? 'bg-base-100' : 'bg-transparent text-neutral-content'"
                        @click="toggle('large')"
                    >
                        <i class="fa-regular fa-grid-2" aria-hidden="true"></i>
                        {{ trans.browse.layouts.large }}
                    </button>
                    <button
                        type="button"
                        class="rounded px-2 py-1 transition-colors cursor-pointer flex gap-1 items-center"
                        :class="mode === 'small' ? 'bg-base-100' : 'bg-transparent text-neutral-content'"
                        @click="toggle('small')"
                    >
                        <i class="fa-regular fa-grid-4" aria-hidden="true"></i>
                         {{ trans.browse.layouts.small }}
                    </button>
                </div>
            </div>

            <div class="md:h-36 md:w-80 text-center flex items-center justify-center w-full" v-if="loading || searching">
                <i class="fa-solid fa-spinner fa-spin" aria-label="Loading"></i>
            </div>

            <template v-else class="flex flex-col gap-4">
                <div class="alert alert-error p-2 rounded-lg" v-if="error" v-html="error"></div>

                <p class="text-sm text-left uppercase font-medium text-neutral-content" v-if="!error && term">{{ trans.browse.search.results?.replace(':term', term) }}</p>

                <div class="text-center py-4" v-if="!error && term && !images.length">
                    <i class="fa-regular fa-search text-neutral-content text-2xl mb-4" aria-hidden="true"></i>
                    <p>{{ trans.browse.search.no_results?.replace(':term', term) }}</p>
                    <p class="text-base-content/60 text-sm mt-1">{{ trans.browse.search.try_again }}</p>
                </div>

                <div v-if="!error && folders.length" :class="gridClass()">
                    <div
                        v-for="folder in folders"
                        class="border border-base-200 rounded-lg flex gap-3 p-3 cursor-pointer hover:shadow-lg w-40 md:w-48 items-center group hover:bg-base-200 justify-between"
                        :title="folder.name"
                        @click="selectImage(folder)"
                    >
                        <div class="rounded-lg flex items-center justify-center w-10 h-10 bg-base-200 group-hover:bg-base-300 flex-none">
                            <i :class="folder.icon" aria-label="Folder" />
                        </div>
                        <div class="flex flex-col grow overflow-hidden">
                            <div class="truncate w-full font-medium" :class="mode === 'large' ? 'text-sm' : 'text-xs'">{{ folder.name }}</div>
                            <div class="text-xs text-neutral-content" v-if="folder.image_count !== null && folder.image_count !== undefined">{{ Number(folder.image_count) === 1 ? trans.browse.folder_count_one : trans.browse.folder_count?.replace(':count', String(folder.image_count)) }}</div>
                        </div>
                        <i class="fa-regular fa-chevron-right text-neutral-content" aria-label="Open folder" v-if="folder.image_count !== undefined && folder.image_count !== null" />
                    </div>
                </div>

                <div :class="gridClass()" v-if="!error && imageItems.length">
                    <div v-for="image in imageItems" class="cursor-pointer shadow-sm rounded-lg hover:shadow-lg overflow-hidden relative group" @click="selectImage(image)">
                        <div :class="previewSize('cover-background')" :style="{'backgroundImage': 'url(\'' + image.thumbnail + '\')'}" />
                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent text-white px-2 py-1 transition-opacity opacity-100 md:opacity-0 md:group-hover:opacity-100" :title="image.name">
                            <div class="truncate text-sm">{{ image.name }}</div>
                            <div class="truncate text-xs opacity-80" v-if="mode === 'large'">{{ image.ext }} · {{ image.size }}</div>
                        </div>
                    </div>
                </div>
            </template>
        </article>
    </dialog>
</template>

<script setup lang="ts">
import {ref, computed, onMounted, watch, onBeforeMount} from 'vue'

const props = defineProps<{
    api: string,
    opened: boolean,
    i18n: unknown,
}>()

const trans = ref(null)

onBeforeMount(() => {
    // if props.i18n is a string, it's a JSON string
    if (props.i18n && typeof props.i18n === 'string') {
        trans.value = JSON.parse(props.i18n)
    } else {
        trans.value = props.i18n;
    }
})

const emit = defineEmits(['selected', 'closed'])

const loading = ref(true)
const searching = ref(false)
const galleryDialog = ref()
const images = ref([])
const folders = computed(() => images.value.filter(i => i.folder))
const imageItems = computed(() => images.value.filter(i => !i.folder))
const term = ref('')
const lastTerm = ref('')
const typingTimeout = ref(null)
const error = ref(null)
const debounceDelay = 300
const mode = ref('large')

const open = () => {
    loading.value = true
    galleryDialog.value.showModal()
    galleryDialog.value.addEventListener('click', function (event) {
        let rect = this.getBoundingClientRect()
        let isInDialog = (rect.top <= event.clientY && event.clientY <= rect.top + rect.height &&
            rect.left <= event.clientX && event.clientX <= rect.left + rect.width)
        if (!isInDialog && event.target.tagName === 'DIALOG') {
            closeBrowser()
        }
    });

    axios.get(props.api)
        .then(res => {
            images.value = res.data.images
            loading.value = false
        })
        .catch(err => {
            loading.value = false
            if (err.response?.status === 403) {
                error.value = err.response.data.message //You aren\'t a member of any roles that have access to the gallery'
                // Let's give more hints to the users confused by this
                error.value += '<p>' + trans.value.browse.unauthorized + '</p>'
            }
        })
}

const closeBrowser = () => {
    galleryDialog.value.close()
    emit('closed')
}

const previewSize = (extra) => {
    extra = extra ?? ''
    if (mode.value === 'large') {
        return 'w-40 h-40 md:w-48 md:h-48 ' + extra
    }
    return 'w-24 h-24 ' + extra
}


const gridClass = () => {
    if (mode.value === 'small') {
        return 'flex flex-wrap gap-2 md:gap-2'
    }
    return 'flex flex-wrap gap-2 md:gap-4'
}

const selectImage = (image) => {
    if (image.folder) {
        loading.value = true
        axios.get(image.url).then(res => {
            images.value = res.data.images
            loading.value = false
        })
        return;
    }

    emit('selected', image)
    closeBrowser()
}

watch(() => props.opened, (newVal, oldVal) => {
    if (newVal) {
        open()
    }
})

const handleInput = (event) => {
    term.value = event.target.value
    if (typingTimeout.value) {
        clearTimeout(typingTimeout.value)
    }

    typingTimeout.value = setTimeout(() => {
        search()
    }, debounceDelay)
}

const search = () => {
    if (lastTerm.value == term.value) {
        return
    }

    lastTerm.value = term.value
    searching.value= true

    axios.get(props.api + '?term=' + lastTerm.value).then(res => {
        images.value = res.data.images
        searching.value = false
    }).catch(() => {
        searching.value = false
    })
}

const toggle = (layout) => {
    mode.value = layout
}
</script>
