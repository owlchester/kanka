<template>
    <i class="fa-solid fa-spinner fa-spin" aria-hidden="true" v-if="loading" />

    <dialog class="dialog rounded-2xl text-center bg-base-100 text-base-content" id="gallery-dialog" ref="dialog" aria-modal="true" aria-labelledby="modal-card-label">
        <header class="flex gap-6 items-center p-4 md:p-6 justify-between">
            <h4 v-html="trans('Entity search')" class="text-lg font-normal"></h4>
            <button type="button" class="text-base-content" @click="closeDialog()" title="Close">
                <i class="fa-regular fa-circle-xmark" aria-hidden="true"></i>
                <span class="sr-only">trans('close')</span>
            </button>
        </header>
        <article class="max-w-4xl p-4">

            <div class="flex gap-1 w-full" v-if="!loading">
                <div class="grow">
                    <input
                        type="text"
                        class="w-full"
                        :placeholder="trans('search-placeholder')"
                        @input="handleInput" ref="searchInput"
                        @keydown.down.prevent="highlightNext"
                        @keydown.up.prevent="highlightPrev"
                        @keydown.enter="handleEnter"
                    />
                </div>
            </div>

            <div class="text-center flex items-center justify-center w-full" v-if="loading || searching">
                <i class="fa-solid fa-spinner fa-spin" aria-label="Loading"></i>
            </div>

            <div class="flex flex-col gap-0.5 w-full" v-if="!loading && !searching">
                <div v-for="(entity, id) in entities" :key="entity.id" :class="entityClass(entity, id)" @click="select(entity)">
                    <div class="cover-background rounded-full h-6 w-6" :style="{ backgroundImage: backgroundImage(entity) }" v-if="entity.image"></div>
                    <span v-html="entity.name"></span>
                </div>
            </div>
        </article>
    </dialog>
</template>

<script setup lang="ts">

import { ref, onMounted, nextTick, watch} from 'vue';

const props = defineProps<{
    api: String,
    opened: boolean,
}>()

const loading = ref(false);
const searching = ref(false)
const dialog = ref();
const searchInput = ref();
const entities = ref();
const term = ref('')
const lastTerm = ref('')
const typingTimeout = ref(null);
const debounceDelay = 300
const highlightedIndex = ref(-1)


const emit = defineEmits(['selected', 'closed'])

const open = () => {
    loading.value = true;
    highlightedIndex.value = 0
    dialog.value.showModal()
    dialog.value.addEventListener('click', function (event) {
        let rect = this.getBoundingClientRect()
        let isInDialog = (rect.top <= event.clientY && event.clientY <= rect.top + rect.height &&
            rect.left <= event.clientX && event.clientX <= rect.left + rect.width)
        if (!isInDialog && event.target.tagName === 'DIALOG') {
            closeDialog()
        }
    });

    axios.get(props.api + '?v2=true&thumb=256')
        .then(res => {
            entities.value = res.data.entities
            loading.value = false

            nextTick(() => {
                searchInput.value?.focus()
            })

        })
        .catch(err => {
            loading.value = false
        })
}

const closeDialog = () => {
    dialog.value.close()
    highlightedIndex.value = -1;
    emit('closed')
}

const trans = (key) => {
    return key;
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
    searching.value = true

    axios.get(props.api + '?v2=true&thumb=256&q=' + lastTerm.value).then(res => {
        entities.value = res.data.entities
        searching.value = false
        highlightedIndex.value = 0
    })
}

const backgroundImage = (entity) => {
    return 'url(\'' + entity.image + '\')';
}

const entityClass = (entity, id) => {
    let css = 'flex gap-2 items-center cursor-pointer hover:bg-base-200 w-full rounded p-1';
    if (highlightedIndex.value == id) {
        css += ' bg-base-300';
    }
    return css;
}

const highlightNext = (event) => {
    if (highlightedIndex.value === -1) {
        return;
    }
    event.preventDefault();
    if (highlightedIndex.value < entities.value.length - 1) {
        highlightedIndex.value++;
    } else if (entities.value.length > 0) {
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
    } else if (entities.value.length > 0) {
        highlightedIndex.value = entities.value.length - 1;
    }
};

const handleEnter = (event) => {
    if (entities.value.length > 0 && highlightedIndex.value >= 0) {
        event.preventDefault();
        select(entities.value[highlightedIndex.value]);
    }
};

const select = (entity) => {
    emit('selected', entity)
    closeDialog()
}

</script>
