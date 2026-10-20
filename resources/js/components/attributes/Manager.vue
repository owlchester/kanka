
<template>
    <div class="text-center text-4xl p-4" v-if="loading">
        <i class="fa-solid fa-spinner fa-spin" aria-label="Loading" />
    </div>
    <div class="flex flex-col gap-2 lg:gap-5 relative h-full min-h-0 " v-else>
        <!-- Toolbar -->
        <div class="attributes-toolbar flex gap-2 lg:gap-2 items-center flex-wrap flex-none">
            <a role="button" v-bind:class="deleteClass()" @click="deleteAll()" v-if="hasSelected()">
                <i class="fa-regular fa-trash-can" aria-hidden="true" />
                <span v-html="trans('columns.delete')"></span>
                <span v-html="countSelected()" class="font-extrabold"></span>
            </a>
            <a role="button" @click="togglePrivate()" v-bind:class="togglePrivateClass()" v-if="isAdmin() && hasSelected()" >
                <i class="fa-regular fa-lock-open" aria-hidden="true" />
                <span v-html="trans('actions.toggle')"></span>
                <span v-html="countSelected()" class="font-extrabold"></span>
            </a>
            <input type="text" v-bind:placeholder="trans('actions.search')" class="grow md:flex-none md:w-80" v-model="searchTerm" v-if="!hasSelected()" />
            <div class="relative" v-if="!hasSelected()">
                <a role="button" @click="toggleFilters()" class="btn2 btn-outline btn-sm">
                    <i class="fa-regular fa-bars-filter" aria-hidden="true" />
                    <span v-html="trans('actions.filters')"></span>
                </a>
                <div class="border border-base-300 shadow-sm rounded bg-base-100 p-4 absolute right-0 flex flex-col gap-5 w-60" v-if="showFilters"  v-click-outside="onClickOutside">
                    <div class="flex gap-2">
                        <div>
                            <input type="checkbox" v-model="showHidden" value="1" id="_show_hidden_attributes" />
                        </div>
                        <label for="_show_hidden_attributes" v-html="trans('filters.show_hidden')"></label>
                    </div>
                </div>
            </div>
            <a href="https://docs.kanka.io/en/latest/features/properties.html" class="btn2 btn-ghost btn-sm" v-if="!hasSelected()">
                <i class="fa-regular fa-question-circle" aria-hidden="true" />
                <span v-html="trans('actions.help')"></span>
            </a>
        </div>

        <!-- Middle -->
        <div class="w-full flex flex-col gap-2 flex-1 min-h-0 overflow-hidden">
            <div class="flex flex-wrap items-center justify-between gap-2">
                <div class="flex flex-wrap gap-2" :aria-label="trans('sheets.title')">
                    <draggable v-model="sheets" handle=".sheet-handle" :disabled="sheets.length <= 1" class="flex flex-wrap gap-2" v-if="sheets.length" >
                        <div v-for="sheet in sheets" :key="sheet.key" class="flex items-center gap-2 rounded-full border border-base-300 bg-base-200 px-3 py-1.5 text-sm">
                            <span class="sheet-handle" :class="sheets.length > 1 ? 'cursor-grab' : 'cursor-default'" :title="sheets.length > 1 ? trans('sheets.reorder') : null">{{ sheet.name }}</span>
                            <button type="button" class="cursor-pointer" @click="removeSheet(sheet)" :aria-label="trans('sheets.remove')" :title="trans('sheets.remove')"><i class="fa-solid fa-xmark" aria-hidden="true" /></button>
                        </div>
                    </draggable>
                </div>
                    <button type="button" class="btn2 btn-outline btn-sm" @click="openSheetDialog()">
                    <i class="fa-regular fa-plus" aria-hidden="true" />
                    <span v-html="trans('sheets.add')"></span>
                </button>
            </div>

            <input type="hidden" name="sheets_present" value="1" />
            <input v-for="(sheet, index) in sheets" :key="'sheet-input-' + sheet.key" type="hidden" name="sheets[]" :value="JSON.stringify({id: sheet.id, source: sheet.source, reference: sheet.reference, sort_order: index})" />
            <div class="flex gap-2 border-b border-base-300 text-neutral-content items-center text-xs font-light px-4 flex-none">
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
            <div class="flex-1 min-h-0 overflow-y-auto">
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
            </div>
            <div v-if="visibleAttributes.length === 0" class="w-full px-5 italic" v-html="trans('filters.no_results')">
            </div>
        </div>

        <div class="flex-none">
            <attributes-manager-form
                :attributes="attributes"
                :visible-attributes="visibleAttributes"
                :i18n="i18n"
                :newAttributeID="newAttributeID"
                :max="meta.max"
                @incrementNewAttributeID="incrementNewAttributeID"
                @openTemplates="toggleTemplates"
            >
            </attributes-manager-form>
        </div>
    </div>

    <dialog class="dialog rounded-top md:rounded-2xl bg-base-100 min-w-fit shadow-md text-base-content" id="templates-dialog" aria-modal="true" v-if="!loading">
        <header class="flex gap-6 items-center p-4 md:p-6 justify-between">
            <h4 v-html="trans('templates.title')" class="text-lg font-normal"></h4>

            <button autofocus type="button" class="text-xl opacity-50 hover:opacity-100 focus:opacity-100 cursor-pointer text-decoration-none" aria-label="Close" v-on:click="closeModal()">
                <i class="fa-regular fa-circle-xmark" aria-hidden="true"></i>
                <span class="sr-only">Close</span>
            </button>
        </header>
        <article class="flex flex-col gap-4 p-4 md:p-6">
            <p class="text-neutral-content" v-html="trans('templates.helper')"></p>
            <label for="template_id" v-html="trans('templates.template')"></label>
            <select v-model="template" class="w-full" id="template_id">
                <option v-for="kit in templates" :key="kit.id" :value="kit.id">{{ kit.name }}</option>
            </select>
        </article>
        <footer class="flex flex-wrap gap-3 justify-end items-center p-4 md:px-6">
            <menu class="flex flex-wrap gap-3 ps-0">
                <div class="submit-group">
                    <a role="button" class="btn2 btn-primary" @click="loadTemplate()" v-html="trans('templates.load')">
                    </a>
                </div>
            </menu>
        </footer>
    </dialog>

    <dialog class="dialog rounded-top md:rounded-2xl bg-base-100 min-w-fit shadow-md text-base-content" id="sheets-dialog" aria-modal="true" v-if="!loading">
        <header class="flex gap-6 items-center p-4 md:p-6 justify-between">
            <h4 class="text-lg font-normal" v-html="trans('sheets.title')"></h4>
            <button autofocus type="button" class="text-xl opacity-50 hover:opacity-100 focus:opacity-100 cursor-pointer" aria-label="Close" @click="closeSheetDialog()">
                <i class="fa-regular fa-circle-xmark" aria-hidden="true"></i>
                <span class="sr-only">Close</span>
            </button>
        </header>
        <article class="flex flex-col gap-4 p-4 md:p-6">
            <p v-if="availableSheets.length" class="text-neutral-content" v-html="trans('sheets.choose')"></p>
            <p v-else class="text-neutral-content flex gap-1">
                <span v-html="trans('sheets.none_installed')"></span>
                <a :href="meta.sheet_library" target="_blank" rel="noopener" class="text-link" v-html="trans('sheets.library')"></a>
            </p>
            <div v-if="unattachedSheets.length" class="flex flex-col gap-2">
                <button v-for="option in unattachedSheets" :key="option.id" type="button" class="btn2 btn-outline justify-start text-base-content" @click="addSheet(option)">
                    <i class="fa-regular fa-file-lines" aria-hidden="true" />
                    <span class="font-medium text-base-content">{{ option.name }}</span>
                    <span class="ms-auto text-xs text-neutral-content" v-html="option.author"></span>
                </button>
            </div>
            <p v-if="availableSheets.length && unattachedSheets.length === 0" class="text-sm text-neutral-content" v-html="trans('sheets.all_added')"></p>
            <a v-if="availableSheets.length" :href="meta.sheet_library" target="_blank" rel="noopener" class="text-link self-start" v-html="trans('sheets.library')"></a>
        </article>
    </dialog>
</template>

<script setup lang="ts">
import {ref, computed, onMounted, onBeforeUnmount} from 'vue'

const props = defineProps<{
    api: string,
}>()


const attributes = ref([])
const sheets = ref([])
const availableSheets = ref([])
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
const unattachedSheets = computed(() => availableSheets.value.filter(option => !isSheetAdded(option)))

onMounted(() => {
    fetch(props.api)
        .then(response => response.json())
        .then(response => {
            response.attributes.forEach(a => {
                attributes.value.push(a)
                visibleAttributes.value.push(a)
            })
            sheets.value = (response.sheets || []).map(sheet => ({...sheet, key: sheet.id, name: sheet.name || sheet.reference}))
            meta = response.meta;
            i18n = response.i18n;
            templates = Object.values(response.templates || {}).flatMap(group => Object.entries(group).map(([id, name]) => ({id, name})));
            availableSheets.value = response.available_sheets || [];
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
        return 'btn2 btn-ghost  btn-sm'
    }
    return 'btn2 btn-error btn-outline  btn-sm'
}

const getSelected = () => {
    return attributes.value.filter(attribute => attribute.is_checked == true);
}
const hasSelected = () => {
    return getSelected().length > 0;
}
const countSelected = () => {
    let selected = getSelected();
    return selected.length;
}

const deleteAll = () => {
    let selected = getSelected();
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
        return 'btn2 btn-ghost btn-sm'
    }
    return 'btn2 btn-outline  btn-sm'
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

const openSheetDialog = () => {
    window.openDialog('sheets-dialog')
}

const closeSheetDialog = () => {
    window.closeDialog('sheets-dialog')
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
            let marketplaceSheet = false
            response.forEach(attr => {
                if (attr.is_sheet) {
                    marketplaceSheet = true
                    if (!sheets.value.find(sheet => sheet.source === attr.source && sheet.reference === attr.reference)) {
                        const sheet = {id: null, source: attr.source, reference: attr.reference, name: attr.name, key: 'new-' + attr.reference}
                        sheets.value.push(sheet)
                    }
                    return
                }
                importAttribute(attr, marketplaceSheet)
            })
            closeModal()
            window.showToast(trans('toasts.template'))
            template.value = null
        })
}

const removeSheet = (sheet) => {
    sheets.value = sheets.value.filter(item => item.key !== sheet.key)
}

const isSheetAdded = (option) => {
    return sheets.value.some(sheet => sheet.plugin_uuid === option.id || sheet.reference === option.reference)
}

const addSheet = (option) => {
    if (isSheetAdded(option)) {
        return
    }

    fetch(meta.template + '?template=' + option.id)
        .then(response => response.json())
        .then(response => {
            const sheet = response.find(attribute => attribute.is_sheet)
            if (!sheet) {
                return
            }

            sheets.value.push({
                id: null,
                source: sheet.source,
                reference: sheet.reference,
                plugin_uuid: option.id,
                name: option.name,
                key: 'new-' + sheet.reference,
            })
            response.filter(attribute => !attribute.is_sheet).forEach(attribute => importAttribute(attribute, true))
            window.showToast(trans('toasts.template'))
            closeSheetDialog()
        })
}

const importAttribute = (attribute, preserveExisting = false) => {
    let ex = attributes.value.find(attr => attr.name == attribute.name)
    if (ex && preserveExisting) {
        ex.is_deleted = false
        refreshVisibleAttributes()
        return
    }
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
