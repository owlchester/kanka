
<template>
    <div class="text-center text-4xl p-4" v-if="loading">
        <i class="fa-solid fa-spinner fa-spin" aria-label="Loading" />
    </div>
    <div class="flex flex-col gap-2 lg:gap-5 relative" v-else>
        <div class="flex gap-5 justify-end px-4 pt-4">
            <input type="text" v-bind:placeholder="trans('actions.search')" class="md:w-80" v-model="searchTerm" />
            <div class="relative">
                <a role="button" @click="toggleFilters()" class="btn2 btn-default">
                    <i class="fa-solid fa-filter" aria-hidden="true" />
                    <span v-html="trans('actions.filters')"></span>
                </a>
                <div class="border shadow rounded bg-base-100 p-4 absolute top-12 right-0 flex flex-col gap-5 w-60" v-if="showFilters"  v-click-outside="onClickOutside">
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
                <i class="fa-regular fa-star" aria-hidden="true" />
                <span v-html="trans('actions.load')"></span>
            </a>
            <a href="https://docs.kanka.io" class="btn2 btn-ghost">
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
            <draggable v-model="attributes" handle=".handle" class="w-full flex flex-col gap-2">
                <attributes-manager-attribute
                    v-for="attribute in visibleAttributes()"
                    :key="attribute.id"
                    :attribute="attribute"
                    :isAdmin="isAdmin()"
                    :i18n="i18n"
                    :searchTerm="searchTerm"
                    @remove="remove"
                ></attributes-manager-attribute>
                <div v-if="visibleAttributes().length === 0" class="w-full p-2 italic" v-html="trans('filters.no_results')">
                </div>
            </draggable>
            <div class="flex gap-2 items-center rounded odd:bg-base-200" v-if="showHidden" v-for="attribute in hiddenAttributes()" :key="attribute.id">
                <div class="w-6 md:w-8 p-2">
                    <i class="fa-solid fa-user-secret" aria-hidden="true"></i>
                </div>
                <div class="w-6 md:w-8 p-2"></div>
                <div class="md:w-40 p-2" v-html="attribute.name"></div>
                <div class="grow p-2" v-html="attribute.value"></div>
            </div>
        </div>
        <attributes-manager-form :attributes="attributes" :i18n="i18n" :newAttributeID="newAttributeID" @incrementNewAttributeID="incrementNewAttributeID"></attributes-manager-form>
    </div>

    <dialog class="dialog rounded-top md:rounded-2xl bg-base-100 min-w-fit shadow-md text-base-content" id="templates-dialog" aria-modal="true" v-if="!loading">
        <header class="bg-base-200 sm:rounded-t">
            <h4 v-html="trans('templates.title')"></h4>

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


const attributes = ref([]);
var i18n = [];
var meta = [];
var templates = [];
const loading = ref(true);
const checkedAll = ref(false)
const deletedAttributes = ref([]);
const dragging = ref(false)
const showHidden = ref(false)
const showFilters = ref(false)
const showTemplates = ref(false)
const searchTerm = ref(null)
const template = ref(null)
var newAttributeID = ref(0)

onMounted(() => {
    fetch(props.api)
        .then(response => response.json())
        .then(response => {
            response.attributes.forEach(a => {
                attributes.value.push(a);
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
    }
};

const trans = (k) => {
    //console.log('i18n');
    if (!k.includes('.')) {
        return k;
    }
    let blocks = k.split('.');
    return i18n[blocks[0]][blocks[1]];
};

const toggleAll = () => {
    let checked = checkedAll.value;
    attributes.value.forEach(attribute => {
        attribute.is_checked = checked;
    });
}
const remove = (attribute) => {
    attribute.is_deleted = true
    attribute.is_checked = false
    deletedAttributes.value.push(attribute.id);
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


const isAdmin = () => {
    return meta.is_admin;
}

const visibleAttributes = () => {
    let attr = attributes.value.filter(attr => !attr.is_deleted && !attr.is_hidden)
    return attr;
}

const hiddenAttributes = () => {
    let attr = attributes.value
        .filter(attr => !attr.is_deleted)
        .filter(a => a.is_hidden === true)

    if (searchTerm.value) {
        return attr.filter(function (attr) {
            return attr.name.includes(searchTerm.value) ||
                (attr.value ? attr.value.includes(searchTerm.value) : false)
        })
    }
    return attr;
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
    console.log('url', url)
    fetch(url)
        .then(response => response.json())
        .then(response => {
            console.log(response)
            response.forEach(attr => importAttribute(attr))
            closeModal()
            window.showToast(trans('toasts.template_loaded'))
            template.value = null
            console.log(attributes)
        })
}

const importAttribute = (attribute) => {
    let ex = attributes.value.find(attr => attr.name == attribute.name && !attr.is_deleted);
    console.log(ex)
    if (ex) {
        return
    }

    console.log('adding')

    attribute['id'] = newAttributeID.value--
    attributes.value.push(attribute)
}

const incrementNewAttributeID = () => {
    newAttributeID.value--
}

</script>
