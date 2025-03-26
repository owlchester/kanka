
<template>
    <div class="text-center text-4xl p-4" v-if="loading">
        <i class="fa-solid fa-spinner fa-spin" aria-label="Loading" />
    </div>
    <div class="flex flex-col gap-2 lg:gap-5 relative" v-else>
        <div class="flex gap-2 lg:gap-2 justify-end px-4 pt-4">
            <input type="text" v-bind:placeholder="trans('actions.search')" class="grow md:flex-none md:w-80" v-model="searchTerm" />
            <div class="relative">
                <a role="button" @click="toggleFilters()" class="btn2 btn-default btn-sm">
                    <i class="fa-solid fa-bars-filter" aria-hidden="true" />
                    <span v-html="trans('actions.filters')"></span>
                </a>
                <div class="border shadow rounded bg-base-100 p-4 absolute right-0 flex flex-col gap-5 w-60" v-if="showFilters"  v-click-outside="onClickOutside">
                    <div class="flex gap-2">
                        <div>
                            <input type="checkbox" v-model="showHidden" value="1" id="_show_hidden_attributes" />
                        </div>
                        <label for="_show_hidden_attributes" v-html="trans('filters.show_hidden')"></label>
                    </div>
                </div>
            </div>

        </div>
        <div class="flex gap-2 md:gap-5 flex-wrap px-4 pb-4">
            <a role="button" v-bind:class="deleteClass()" @click="deleteAll()">
                <i class="fa-solid fa-trash-can" aria-hidden="true" />
                <span v-html="trans('columns.delete')"></span>
            </a>
            <a role="button" @click="togglePrivate()" v-bind:class="togglePrivateClass()" v-if="isAdmin()">
                <i class="fa-solid fa-lock-open" aria-hidden="true" />
                <span v-html="trans('actions.toggle')"></span>
            </a>
            <a role="button" class="btn2 md:ml-auto" @click="toggleTemplates()">
                <i class="fa-regular fa-file-import" aria-hidden="true" />
                <span v-html="trans('actions.load')"></span>
            </a>
            <a href="https://docs.kanka.io/en/latest/features/attributes.html" target="_blank" class="btn2 btn-ghost">
                <i class="fa-solid fa-question-circle" aria-hidden="true" />
                <span v-html="trans('actions.help')"></span>
            </a>
        </div>
        <div class="w-full flex flex-col gap-2">
            <div class="flex gap-2 border-b text-neutral-content text-xs md:text-sm font-light px-4">
                <div class="w-6 md:w-8 flex-none"></div>
                <div class="w-6 md:w-8 flex-none">
                    <input type="checkbox" @change="toggleAll()" v-model="checkedAll" />
                </div>
                <div class="grow md:w-40 md:grow-0 flex-none" v-html="trans('columns.attribute')"></div>
                <div class="hidden md:block grow" v-html="trans('columns.value')"></div>
                <div class="hidden lg:block w-16 flex-none text-center">
                    <span class="truncate inline-block" v-html="trans('columns.pinned')"></span>
                </div>
                <div class="hidden lg:block w-16 flex-none text-center" v-if="isAdmin()" >
                    <span class="truncate inline-block" v-html="trans('columns.private')"></span>
                </div>
                <div class="hidden lg:block w-16 flex-none text-center">
                    <span class="truncate inline-block" v-html="trans('columns.delete')"></span>
                </div>
                <div class="lg:hidden flex-none text-center" v-html="trans('columns.preferences')">
                </div>
            </div>
            <draggable v-model="visibleAttributes" handle=".handle" class="w-full flex flex-col gap-2">
                <attributes-manager-attribute
                    v-for="attribute in visibleAttributes"
                    :key="attribute.id"
                    :attribute="attribute"
                    :attributes="attributes"
                    :isAdmin="isAdmin()"
                    :showHidden="showHidden"
                    :i18n="i18n"
                    :search-term="searchTerm"
                    :mention-api="meta.mentions"
                    @remove="removeAttribute"
                >
                </attributes-manager-attribute>
            </draggable>
            <div v-if="visibleAttributes.length === 0" class="w-full px-5 italic" v-html="trans('filters.no_results')">
            </div>
        </div>
        <attributes-manager-form
            :attributes="attributes"
            :visible-attributes="visibleAttributes"
            :i18n="i18n"
            :newAttributeID="newAttributeID"
            :max="meta.max"
            @incrementNewAttributeID="incrementNewAttributeID">
        </attributes-manager-form>
    </div>

    <dialog class="dialog rounded-top md:rounded-2xl bg-base-100 min-w-fit shadow-md text-base-content" id="templates-dialog" aria-modal="true" v-if="!loading">
        <header class="flex gap-6 items-center p-4 md:p-6 justify-between">
            <h4 v-html="trans('templates.title')" class="text-lg font-normal"></h4>

            <button autofocus type="button" class="text-xl opacity-50 hover:opacity-100 focus:opacity-100 cursor-pointer text-decoration-none" aria-label="Close" v-on:click="closeModal()">
                <i class="fa-regular fa-circle-xmark" aria-hidden="true"></i>
                <span class="sr-only">Close</span>
            </button>
        </header>
        <article>
            <label for="template_id" v-html="trans('templates.template')"></label>
            <select v-model="template" class="w-full" id="template_id">
                <optgroup v-for="(group, key) in templates" v-bind:label="key">
                    <option v-for="(option, id) in group" v-bind:value="id" v-html="option"></option>
                </optgroup>
            </select>
        </article>
        <footer class="bg-base-200 flex flex-wrap gap-3 justify-end items-center p-3 md:rounded-b">
            <menu class="flex flex-wrap gap-3 ps-0">
                <div class="submit-group">
                    <a role="button" class="btn2 btn-primary" @click="loadTemplate()" v-html="trans('templates.load')">
                    </a>
                </div>
            </menu>
        </footer>
    </dialog>
</template>

<script setup lang="ts">
import {ref, onMounted, onBeforeUnmount} from 'vue'

const props = defineProps<{
    api: string,
}>()


const attributes = ref([])
const visibleAttributes = ref([])
let i18n = []
let meta = []
let templates = []
const loading = ref(true)
const checkedAll = ref(false)
const deletedAttributes = ref([])
const dragging = ref(false)
const showHidden = ref(false)
const showFilters = ref(false)
const showTemplates = ref(false)
const searchTerm = ref(null)
const template = ref(null)
const newAttributeID = ref(0)

onMounted(() => {
    fetch(props.api)
        .then(response => response.json())
        .then(response => {
            response.attributes.forEach(a => {
                attributes.value.push(a)
                visibleAttributes.value.push(a)
            })
            meta = response.meta;
            i18n = response.i18n;
            templates = response.templates;
            loading.value = false;
        });
    window.addEventListener('keydown', handleKeyDown);
});

onBeforeUnmount(() => {
    window.removeEventListener('keydown', handleKeyDown);
});

const handleKeyDown = (event) => {
    const activeElement = document.activeElement;
    const tagName = activeElement.tagName.toLowerCase();
    // Don't listen to keydown events if the user is focused on a field
    if (['select', 'input', 'textarea', 'button'].includes(tagName)) {
        return
    }
    if (event.ctrlKey && event.key === 'z') {
        if (deletedAttributes.value.length === 0) {
            return
        }
        // Undo the last delete
        event.preventDefault();
        let id = deletedAttributes.value.pop();
        let attribute = attributes.value.find(attribute => attribute.id === id);
        if (attribute) {
            attribute.is_deleted = false;
        }
        refreshVisibleAttributes()
    }
};

const trans = (k) => {
    if (!k.includes('.')) {
        return k;
    }
    let blocks = k.split('.');
    return i18n[blocks[0]][blocks[1]];
};

const toggleAll = () => {
    let checked = checkedAll.value;
    attributes.value.forEach(attribute => {
        if (attribute.is_hidden && !showHidden.value) {
            return
        }
        attribute.is_checked = checked;
    });
}
const remove = (attribute) => {
    attribute.is_deleted = true
    attribute.is_checked = false
    deletedAttributes.value.push(attribute.id);
}
const removeAttribute = (attribute) => {
    remove(attribute)
    refreshVisibleAttributes()
}

const deleteClass = () => {
    let checked = attributes.value.find(attribute => attribute.is_checked == true);
    if (!checked) {
        return 'btn2 btn-ghost'
    }
    return 'btn2 btn-error'
}

const deleteAll = () => {
    let selected = attributes.value.filter(attribute => attribute.is_checked);
    if (selected.length === 0) {
        return window.showToast(trans('toasts.no_attributes_selected'),
        'error');
    }
    selected.forEach(attribute => {
        remove(attribute);
    });
    refreshVisibleAttributes()
    checkedAll.value = false;
    window.showToast(trans('toasts.toggle_deleted'));
}

const togglePrivateClass = () => {
    let checked = attributes.value.find(attribute => attribute.is_checked == true);
    if (!checked) {
        return 'btn2 btn-ghost'
    }
    return 'btn2'
}
const togglePrivate = () => {
    let selected = attributes.value.filter(attribute => attribute.is_checked);

    if (selected.length === 0) {
        return window.showToast(trans('toasts.no_attributes_selected'),
            'error');
    }
    let newState = null
    selected.forEach(attribute => {
        if (newState === null)
            newState = !attribute.is_private
        attribute.is_private = newState
    });
    window.showToast(trans('toasts.toggled_privacy'));
}

const refreshVisibleAttributes = () => {
    visibleAttributes.value = undeletedAttributes()
}


const isAdmin = () => {
    return meta.is_admin;
}

const undeletedAttributes = () => {
    return attributes.value.filter(attr => !attr.is_deleted)
}

const toggleFilters = () => {
    showFilters.value = true
}

const toggleTemplates = () => {
    showTemplates.value = true
    window.openDialog('templates-dialog')
}

const closeModal = () => {
    window.closeDialog('templates-dialog')
}

const onClickOutside = () => {
    showFilters.value = false
    showTemplates.value = false
}

const loadTemplate = () => {
    if (!template.value) {
        closeModal()
        return
    }

    let url = meta.template + '?template=' + template.value
    fetch(url)
        .then(response => response.json())
        .then(response => {
            response.forEach(attr => importAttribute(attr))
            closeModal()
            window.showToast(trans('toasts.template'))
            template.value = null
        })
}

const importAttribute = (attribute) => {
    // Don't re-import existing attributes, unless they've been deleted
    let ex = attributes.value.find(attr => attr.name == attribute.name)
    if (ex && !ex.is_deleted) {
        return
    }


    attribute['id'] = newAttributeID.value--
    attributes.value.push(attribute)
    visibleAttributes.value.push(attribute)
}

const incrementNewAttributeID = () => {
    newAttributeID.value--
}

</script>
