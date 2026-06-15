<template>

    <dialog class="dialog rounded-2xl text-center bg-base-100 text-base-content" id="gallery-dialog" ref="galleryDialog" aria-modal="true" aria-labelledby="modal-card-label">
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

            <template v-else>
                <div class="alert alert-error p-2 rounded" v-if="error" v-html="error"></div>

                <p class="text-sm text-left text-base-content/70" v-if="!error && term && images.length">{{ trans.browse.search.results.replace(':term', term) }}</p>

                <div class="text-center py-4" v-if="!error && term && !images.length">
                    <p>{{ trans.browse.search.no_results.replace(':term', term) }}</p>
                    <p class="text-base-content/60 text-sm mt-1">{{ trans.browse.search.try_again }}</p>
                </div>

                <div :class="gridClass()" v-if="!error && images.length">
                    <div v-for="image in images" class="cursor-pointer shadow-sm rounded hover:shadow-lg overflow-hidden relative group" @click="selectImage(image)">
                        <div :class="previewSize('cover-background')" :style="{'backgroundImage': 'url(\'' + image.thumbnail + '\')'}" v-if="!image.folder" />
                        <div :class="previewSize('flex items-center align-middle justify-center text-4xl')" v-else>
                            <i :class="image.icon" aria-label="Folder" />
                        </div>
                        <div v-if="!image.folder" class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent text-white px-2 py-1 transition-opacity opacity-100 md:opacity-0 md:group-hover:opacity-100" :title="image.name">
                            <div class="truncate text-sm">{{ image.name }}</div>
                            <div class="truncate text-xs opacity-80" v-if="mode === 'large'">{{ image.ext }} · {{ image.size }}</div>
                        </div>
                        <div v-else class="truncate px-2 py-1 text-sm" :title="image.name">{{ image.name }}</div>
                    </div>
                </div>
            </template>
        </article>
    </dialog>
</template>

<script setup lang="ts">
import {ref, onMounted, watch, onBeforeMount} from 'vue'

const props = defineProps<{
    api: string,
    opened: boolean,
    i18n: undefined,
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
            if (err.response.status === 403) {
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
        return 'w-40 h-28 md:w-48 md:h-36 ' + extra
    }
    return 'w-20 h-16 ' + extra
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
    })
}

const toggle = (layout) => {
    mode.value = layout
}
</script>
