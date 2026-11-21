<template>
    <div class="flex flex-col gap-4">
        <!-- Unified Toolbar -->
        <div class="bg-base-100 rounded-lg p-3 flex flex-wrap items-center justify-between gap-2">
            <div class="flex flex-wrap items-center gap-2">
                <button type="button" class="btn2 btn-sm" @click="addSection">
                    <i class="fa-solid fa-plus" aria-hidden="true"></i>
                    {{ i18n.section }}
                </button>
                <button type="button" class="btn2 btn-sm btn-ghost" @click="toggleCollapseAll">
                    <i class="fa-solid" :class="allCollapsed ? 'fa-angles-down' : 'fa-angles-up'" aria-hidden="true"></i>
                    {{ allCollapsed ? i18n.expandAll : i18n.collapseAll }}
                </button>
            </div>

            <div class="relative" ref="menuRef">
                <button
                    type="button"
                    class="btn2 btn-sm btn-ghost"
                    :aria-expanded="menuOpen"
                    @click="menuOpen = !menuOpen"
                >
                    <i class="fa-solid fa-wand-magic-sparkles" aria-hidden="true"></i>
                    {{ i18n.templates }}
                    <i class="fa-solid fa-chevron-down text-[10px]" aria-hidden="true"></i>
                </button>
                <div
                    v-if="menuOpen"
                    class="absolute right-0 mt-1 w-64 rounded-lg bg-base-100 shadow-lg p-1.5 z-40 flex flex-col gap-0.5"
                >
                    <button
                        v-if="config.target !== 'default'"
                        type="button"
                        class="w-full text-left px-3 py-2 rounded text-sm hover:bg-base-200 flex items-center gap-2"
                        @click="applyTemplate(config.defaultLayout)"
                    >
                        <i class="fa-regular fa-copy w-4 text-center text-neutral-content" aria-hidden="true"></i>
                        <span class="truncate">{{ i18n.copy }}</span>
                    </button>
                    <button
                        v-for="source in config.copySources"
                        :key="source.id"
                        type="button"
                        class="w-full text-left px-3 py-2 rounded text-sm hover:bg-base-200 flex items-center gap-2"
                        @click="applyTemplate({ items: source.items })"
                    >
                        <i class="fa-regular fa-clone w-4 text-center text-neutral-content" aria-hidden="true"></i>
                        <span class="truncate">{{ i18n.copyFromRole.replace(':role', source.label) }}</span>
                    </button>
                    <button
                        type="button"
                        class="w-full text-left px-3 py-2 rounded text-sm hover:bg-base-200 flex items-center gap-2"
                        @click="applyTemplate(config.standard)"
                    >
                        <i class="fa-solid fa-rotate-left w-4 text-center text-neutral-content" aria-hidden="true"></i>
                        <span class="truncate">{{ i18n.standard }}</span>
                    </button>
                    <template v-if="hasCustomLayout">
                        <div class="my-1 border-t border-base-200"></div>
                        <button
                            type="button"
                            class="w-full text-left px-3 py-2 rounded text-sm hover:bg-error/10 text-error flex items-center gap-2"
                            @click="openResetDialog"
                        >
                            <i class="fa-regular fa-trash-can w-4 text-center" aria-hidden="true"></i>
                            <span class="truncate">{{ config.resetLabel }}</span>
                        </button>
                    </template>
                </div>
            </div>
        </div>

        <!-- Undo Banner -->
        <div
            v-if="undoState"
            class="bg-base-100 rounded-lg px-4 py-2.5 flex items-center justify-between gap-3 text-sm"
            role="status"
        >
            <span>{{ undoState.message }}</span>
            <div class="flex items-center gap-2 shrink-0">
                <button type="button" class="btn2 btn-xs btn-primary" @click="undo">
                    <i class="fa-solid fa-rotate-left" aria-hidden="true"></i>
                    {{ i18n.undo }}
                </button>
                <button
                    type="button"
                    class="btn2 btn-xs btn-ghost w-6 h-6 p-0!"
                    :aria-label="i18n.remove"
                    @click="undoState = null"
                >
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        </div>

        <!-- Two-Column Studio -->
        <div class="grid grid-cols-1 lg:grid-cols-[minmax(0,1fr)_320px] gap-6 items-start">
            <!-- Main Builder Column -->
            <div class="flex flex-col gap-3 min-w-0">
                <Draggable
                    v-model="items"
                    tag="ul"
                    class="list-none m-0 p-0 flex flex-col gap-3"
                    data-root="1"
                    :group="rootGroup"
                    handle=".sidebar-v2-section-drag, .sidebar-v2-handle"
                    filter="input, button, select, option, a, [data-child-list]"
                    :prevent-on-filter="false"
                    ghost-class="sidebar-v2-ghost"
                    chosen-class="shadow-md"
                    :animation="150"
                >
                    <li
                        v-for="(node, index) in items"
                        :key="node.id"
                        :data-section="isSection(node) ? '1' : null"
                        :data-section-id="isSection(node) ? node.id : null"
                        class="rounded-lg bg-base-100"
                        :class="{ 'sidebar-v2-section-drag cursor-move': isSection(node) }"
                    >
                        <SidebarRow
                            :section="isSection(node)"
                            :collapsed="Boolean(collapsed[node.id])"
                            :child-count="isSection(node) ? node.children.length : 0"
                            :is-bookmarks="node.id === 'bookmarks'"
                            :label="label(node)"
                            :entry="catalog[node.id]"
                            :i18n="i18n"
                            :sections="sections"
                            :removable="removable(node)"
                            :invalid="invalidSet.has(node.id)"
                            :inaccessible-reason="inaccessible[node.id]"
                            :role-name="config.targetLabel"
                            :bookmarks-url="config.bookmarksUrl"
                            @rename="rename(node, $event)"
                            @toggle-collapse="toggleCollapse(node.id)"
                            @remove="remove(items, index)"
                            @order="order(items, index, $event)"
                            @move="move(items, index, $event)"
                            @hide-all="hideAllInSection(node)"
                        />

                        <div v-if="isSection(node)" v-show="!collapsed[node.id]" class="px-3 pb-3 cursor-auto">
                            <Draggable
                                v-model="node.children"
                                tag="ul"
                                data-child-list="1"
                                class="list-none p-0 m-0 min-h-10 flex flex-col gap-1.5"
                                :group="childGroup"
                                handle=".sidebar-v2-handle"
                                ghost-class="sidebar-v2-ghost"
                                chosen-class="shadow-sm"
                                :animation="150"
                            >
                                <li
                                    v-for="(child, childIndex) in node.children"
                                    :key="child.id"
                                    class="rounded-lg bg-base-200"
                                >
                                    <SidebarRow
                                        :entry="catalog[child.id]"
                                        :i18n="i18n"
                                        :sections="sections"
                                        :removable="removable(child)"
                                        :inaccessible-reason="inaccessible[child.id]"
                                        :role-name="config.targetLabel"
                                        :bookmarks-url="config.bookmarksUrl"
                                        @remove="remove(node.children, childIndex)"
                                        @order="order(node.children, childIndex, $event)"
                                        @move="move(node.children, childIndex, $event)"
                                    />
                                </li>
                            </Draggable>
                            <div
                                v-if="node.children.length === 0"
                                class="mt-1 border border-dashed border-base-300 rounded-lg p-3 text-center text-xs text-neutral-content pointer-events-none"
                            >
                                {{ i18n.emptySectionDrop }}
                            </div>
                        </div>
                    </li>
                </Draggable>
            </div>

            <!-- Sticky Right Rail -->
            <aside class="lg:sticky lg:top-20 bg-base-100 rounded-lg p-3 flex flex-col gap-3">
                <div class="grid grid-cols-2 gap-1 p-1 rounded-lg bg-base-200" role="tablist">
                    <button
                        type="button"
                        role="tab"
                        :aria-selected="railTab === 'available'"
                        class="px-2.5 py-1.5 rounded text-xs font-semibold flex items-center justify-center gap-1.5 transition-colors"
                        :class="railTab === 'available' ? 'bg-base-100 text-base-content shadow-xs' : 'text-neutral-content hover:text-base-content'"
                        @click="railTab = 'available'"
                    >
                        <span>{{ i18n.tabAvailable }}</span>
                        <span class="px-1.5 py-0.2 rounded-full bg-base-200 text-[11px]">{{ available.length }}</span>
                    </button>
                    <button
                        type="button"
                        role="tab"
                        :aria-selected="railTab === 'preview'"
                        class="px-2.5 py-1.5 rounded text-xs font-semibold flex items-center justify-center gap-1.5 transition-colors"
                        :class="railTab === 'preview' ? 'bg-base-100 text-base-content shadow-xs' : 'text-neutral-content hover:text-base-content'"
                        @click="railTab = 'preview'"
                    >
                        <i class="fa-regular fa-eye text-[11px]" aria-hidden="true"></i>
                        <span>{{ i18n.tabPreview }}</span>
                    </button>
                </div>

                <!-- Available Items Tray -->
                <div v-if="railTab === 'available'" class="flex flex-col gap-3">
                    <input
                        v-if="available.length > 5"
                        v-model="search"
                        type="search"
                        :placeholder="i18n.searchItems"
                        class="w-full rounded-lg bg-base-200 px-3 py-1.5 text-sm border-0 focus:outline-none"
                    />

                    <p v-if="!available.length" class="text-xs text-neutral-content text-center py-4 mb-0">
                        {{ i18n.allAdded }}
                    </p>

                    <template v-else>
                        <p class="text-xs text-neutral-content mb-0">{{ i18n.addHelp }}</p>

                        <div v-if="availableCategories.length" class="flex flex-col gap-1.5">
                            <span class="text-[11px] font-semibold uppercase tracking-wider text-neutral-content px-1">
                                {{ i18n.categoriesGroup }}
                            </span>
                            <Draggable
                                :list="availableCategories"
                                tag="ul"
                                class="list-none p-0 m-0 flex flex-col gap-1.5 max-h-60 overflow-y-auto"
                                :group="trayGroup"
                                :clone="cloneEntry"
                                :sort="false"
                                ghost-class="sidebar-v2-ghost"
                                :animation="150"
                            >
                                <li
                                    v-for="entry in availableCategories"
                                    :key="entry.id"
                                    class="rounded-lg bg-base-200 px-2.5 py-1.5 flex items-center gap-2 cursor-move text-sm"
                                >
                                    <i class="fa-solid fa-grip-vertical text-neutral-content/60 text-xs shrink-0" aria-hidden="true"></i>
                                    <span class="w-4 text-center shrink-0 text-neutral-content">
                                        <i :class="entry.icon" aria-hidden="true"></i>
                                    </span>
                                    <span class="grow truncate">{{ entry.label }}</span>
                                    <i
                                        v-if="inaccessible[entry.id]"
                                        class="fa-regular fa-eye-slash text-warning text-xs shrink-0"
                                        :title="i18n.inaccessiblePermission.replace(':role', config.targetLabel)"
                                    ></i>
                                    <button
                                        type="button"
                                        class="btn2 btn-xs btn-ghost w-6 h-6 p-0! shrink-0"
                                        :aria-label="i18n.quickAdd"
                                        :title="i18n.quickAdd"
                                        @click="add(entry)"
                                    >
                                        <i class="fa-solid fa-plus text-xs"></i>
                                    </button>
                                </li>
                            </Draggable>
                        </div>

                        <div v-if="availableBookmarks.length" class="flex flex-col gap-1.5">
                            <span class="text-[11px] font-semibold uppercase tracking-wider text-neutral-content px-1">
                                {{ i18n.bookmarksGroup }}
                            </span>
                            <Draggable
                                :list="availableBookmarks"
                                tag="ul"
                                class="list-none p-0 m-0 flex flex-col gap-1.5 max-h-60 overflow-y-auto"
                                :group="trayGroup"
                                :clone="cloneEntry"
                                :sort="false"
                                ghost-class="sidebar-v2-ghost"
                                :animation="150"
                            >
                                <li
                                    v-for="entry in availableBookmarks"
                                    :key="entry.id"
                                    class="rounded-lg bg-base-200 px-2.5 py-1.5 flex items-center gap-2 cursor-move text-sm"
                                >
                                    <i class="fa-solid fa-grip-vertical text-neutral-content/60 text-xs shrink-0" aria-hidden="true"></i>
                                    <span class="w-4 text-center shrink-0 text-neutral-content">
                                        <i :class="entry.icon" aria-hidden="true"></i>
                                    </span>
                                    <span class="grow truncate">{{ entry.label }}</span>
                                    <Tippy v-if="entry.duplicates_category" :interactive="true" theme="kanka">
                                        <i class="fa-regular fa-clone text-warning text-xs shrink-0 cursor-help"></i>
                                        <template #content>
                                            <div class="flex flex-col gap-1.5 p-1 text-xs max-w-60">
                                                <p class="mb-0">{{ i18n.duplicateCategoryHelp }}</p>
                                                <a
                                                    v-if="config.bookmarksUrl"
                                                    :href="config.bookmarksUrl"
                                                    class="text-link inline-flex items-center gap-1 font-medium"
                                                >
                                                    <i class="fa-regular fa-bookmark" aria-hidden="true"></i>
                                                    <span>{{ i18n.manageBookmarks }}</span>
                                                </a>
                                            </div>
                                        </template>
                                    </Tippy>
                                    <i
                                        v-if="inaccessible[entry.id]"
                                        class="fa-regular fa-eye-slash text-warning text-xs shrink-0"
                                        :title="inaccessible[entry.id] === 'private' ? i18n.inaccessiblePrivate : i18n.inaccessiblePermission.replace(':role', config.targetLabel)"
                                    ></i>
                                    <button
                                        type="button"
                                        class="btn2 btn-xs btn-ghost w-6 h-6 p-0! shrink-0"
                                        :aria-label="i18n.quickAdd"
                                        :title="i18n.quickAdd"
                                        @click="add(entry)"
                                    >
                                        <i class="fa-solid fa-plus text-xs"></i>
                                    </button>
                                </li>
                            </Draggable>
                        </div>
                    </template>
                </div>

                <!-- Live Preview Tab -->
                <SidebarPreview
                    v-else
                    :items="items"
                    :catalog="catalog"
                    :inaccessible="inaccessible"
                    :role-name="config.targetLabel"
                    :i18n="i18n"
                />
            </aside>
        </div>

        <!-- Sticky Save Bar -->
        <div class="sticky bottom-4 z-30 bg-base-100 shadow-lg rounded-lg px-4 py-3 flex flex-wrap items-center justify-between gap-3">
            <div class="flex items-center gap-2 text-sm min-w-0">
                <span v-if="error" role="alert" class="text-error font-medium">{{ error }}</span>
                <span v-else-if="dirty" class="inline-flex items-center gap-2 text-warning-content font-medium">
                    <span class="w-2 h-2 rounded-full bg-warning-content"></span>
                    {{ i18n.unsavedChanges }}
                </span>
                <span v-else-if="savedNotice" class="inline-flex items-center gap-2 text-success font-medium">
                    <i class="fa-solid fa-check"></i>
                    {{ i18n.saved }}
                </span>
                <span v-else class="text-neutral-content">{{ i18n.allSaved }}</span>
            </div>

            <div class="flex items-center gap-2">
                <button
                    v-if="dirty"
                    type="button"
                    class="btn2 btn-sm btn-ghost disabled:opacity-40 disabled:pointer-events-none"
                    :disabled="saving"
                    @click="discard"
                >
                    {{ i18n.discard }}
                </button>
                <button
                    type="button"
                    class="btn2 btn-sm btn-primary disabled:opacity-40 disabled:pointer-events-none"
                    :class="{ 'btn-disabled': saving || (!dirty && hasCustomLayout) }"
                    :disabled="saving || (!dirty && hasCustomLayout)"
                    @click="save"
                >
                    <i v-if="saving" class="fa-solid fa-spinner fa-spin" aria-hidden="true"></i>
                    <i v-else class="fa-solid fa-floppy-disk" aria-hidden="true"></i>
                    {{ saving ? i18n.saving : i18n.save }}
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed, nextTick, onBeforeUnmount, onMounted, ref } from 'vue';
import { Tippy } from 'vue-tippy';
import { VueDraggableNext as Draggable } from 'vue-draggable-next';
import SidebarPreview from './SidebarPreview.vue';
import SidebarRow from './SidebarRow.vue';
import {
    addItemToTarget,
    cleanItems,
    findEmptySections,
    hideSectionItems,
    isSection,
    removeNodeInPlace,
} from './sidebarState.js';

const props = defineProps({ config: Object });
const config = props.config;
const i18n = config.i18n;
const inaccessible = config.inaccessible ?? {};
const catalog = Object.fromEntries(config.catalog.map((entry) => [entry.id, entry]));
const clone = (value) => JSON.parse(JSON.stringify(value));

const items = ref(cleanItems(clone(config.layout.items), catalog));
const initial = ref(JSON.stringify(items.value));
const revision = ref(config.revision);
const hasCustomLayout = ref(Boolean(config.hasCustomLayout));
const dirty = computed(() => JSON.stringify(items.value) !== initial.value);

const error = ref('');
const saving = ref(false);
const savedNotice = ref(false);
const railTab = ref('available');
const search = ref('');
const menuOpen = ref(false);
const menuRef = ref(null);
const collapsed = ref({});
const invalidSections = ref([]);
const undoState = ref(null);
let savedTimer = null;

const invalidSet = computed(() => new Set(invalidSections.value));
const label = (node) => node.label ?? i18n.sections[node.label_key] ?? node.id;
const sections = computed(() => items.value.filter(isSection).map((node) => ({ id: node.id, label: label(node) })));
const allCollapsed = computed(() => {
    const sectionNodes = items.value.filter(isSection);
    return sectionNodes.length > 0 && sectionNodes.every((node) => collapsed.value[node.id]);
});

const used = computed(() => new Set(items.value.flatMap((node) => (isSection(node) ? node.children.map((c) => c.id) : [node.id]))));
const available = computed(() => config.catalog.filter((entry) => !used.value.has(entry.id)));
const matchesSearch = (entry) => !search.value.trim() || entry.label.toLowerCase().includes(search.value.trim().toLowerCase());
const availableCategories = computed(() => available.value.filter((entry) => entry.kind === 'category' && matchesSearch(entry)));
const availableBookmarks = computed(() => available.value.filter((entry) => entry.kind === 'bookmark' && matchesSearch(entry)));

const rootGroup = { name: 'sidebar-v2' };
const childGroup = { name: 'sidebar-v2', put: (to, from, element) => element.dataset.section !== '1' };
const trayGroup = { name: 'sidebar-v2', pull: 'clone', put: false };
const cloneEntry = (entry) => ({ id: entry.id });

const removable = (node) => (isSection(node) ? node.id !== 'bookmarks' : !catalog[node.id]?.required);

const snapshotForUndo = (message) => {
    undoState.value = { message, snapshot: clone(items.value) };
};

const undo = () => {
    if (!undoState.value) return;
    items.value = undoState.value.snapshot;
    undoState.value = null;
    invalidSections.value = [];
};

const toggleCollapse = (id) => {
    collapsed.value = { ...collapsed.value, [id]: !collapsed.value[id] };
};

const toggleCollapseAll = () => {
    const target = !allCollapsed.value;
    const next = {};
    for (const node of items.value) {
        if (isSection(node)) {
            next[node.id] = target;
        }
    }
    collapsed.value = next;
};

const rename = (node, value) => {
    node.label = value;
    delete node.label_key;
    if (value.trim()) {
        invalidSections.value = invalidSections.value.filter((id) => id !== node.id);
    }
};

const addSection = async () => {
    const id = `section-${crypto.randomUUID?.() ?? `${Date.now()}-${Math.random().toString(36).slice(2)}`}`;
    items.value.push({ id, label: i18n.sectionName, children: [] });
    await nextTick();
    const input = document.querySelector(`[data-section-id="${id}"] input`);
    input?.scrollIntoView({ block: 'center', behavior: 'smooth' });
    input?.focus({ preventScroll: true });
    input?.select();
};

const add = (entry) => {
    addItemToTarget(items.value, entry.id, 'bookmarks');
};

const remove = (list, index) => {
    const node = list[index];
    if (isSection(node) && node.id !== 'bookmarks') {
        snapshotForUndo(i18n.sectionRemoved);
    }
    removeNodeInPlace(list, index, catalog);
};

const hideAllInSection = (section) => {
    snapshotForUndo(i18n.sectionItemsHidden);
    hideSectionItems(section, catalog);
};

const order = (list, index, delta) => {
    const destination = index + delta;
    if (destination < 0 || destination >= list.length) return;
    list.splice(destination, 0, list.splice(index, 1)[0]);
};

const move = (list, index, destination) => {
    const target = destination === 'root' ? items.value : items.value.find((node) => node.id === destination)?.children;
    if (!target || target === list) return;
    target.push(list.splice(index, 1)[0]);
};

const applyTemplate = (layout) => {
    menuOpen.value = false;
    snapshotForUndo(i18n.templateApplied);
    items.value = cleanItems(clone(layout.items), catalog);
    invalidSections.value = [];
};

const openResetDialog = () => {
    menuOpen.value = false;
    const dialog = document.getElementById(config.resetDialogId);
    if (dialog?.showModal) {
        dialog.showModal();
    }
};

const discard = () => {
    items.value = JSON.parse(initial.value);
    invalidSections.value = [];
    undoState.value = null;
    error.value = '';
};

const handleOutsideClick = (event) => {
    if (menuOpen.value && menuRef.value && !menuRef.value.contains(event.target)) {
        menuOpen.value = false;
    }
};

const beforeUnload = (event) => {
    if (dirty.value && !saving.value) {
        event.preventDefault();
        event.returnValue = '';
    }
};

onMounted(() => {
    window.addEventListener('beforeunload', beforeUnload);
    document.addEventListener('click', handleOutsideClick);
});

onBeforeUnmount(() => {
    window.removeEventListener('beforeunload', beforeUnload);
    document.removeEventListener('click', handleOutsideClick);
    if (savedTimer) clearTimeout(savedTimer);
});

const syncRevisionInputs = (nextRevision) => {
    document.querySelectorAll('[data-sidebar-revision-input]').forEach((input) => {
        input.value = nextRevision;
    });
};

const markActiveRoleCustom = () => {
    const tab = document.querySelector(`[data-sidebar-role-tab="${config.target}"] [data-custom-badge]`);
    tab?.classList.remove('hidden');
    document.querySelector('[data-inheriting-banner]')?.classList.add('hidden');
};

const save = async () => {
    const empty = findEmptySections(items.value);
    if (empty.length) {
        invalidSections.value = empty;
        const nextCollapsed = { ...collapsed.value };
        empty.forEach((id) => {
            nextCollapsed[id] = false;
        });
        collapsed.value = nextCollapsed;
        await nextTick();
        const input = document.querySelector(`[data-section-id="${empty[0]}"] input`);
        input?.scrollIntoView({ block: 'center', behavior: 'smooth' });
        input?.focus({ preventScroll: true });
        return;
    }

    saving.value = true;
    error.value = '';
    savedNotice.value = false;

    try {
        const response = await fetch(config.url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                Accept: 'application/json',
                'X-Sidebar-Inline': '1',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify({
                action: 'save',
                target: config.target,
                revision: revision.value,
                items: items.value,
            }),
        });
        if (!response.ok) {
            const data = await response.json();
            throw new Error(Object.values(data.errors ?? {}).flat().join(' ') || i18n.error);
        }
        const payload = await response.json();
        revision.value = payload.revision;
        hasCustomLayout.value = Boolean(payload.hasCustomLayout);
        initial.value = JSON.stringify(items.value);
        undoState.value = null;
        syncRevisionInputs(payload.revision);
        markActiveRoleCustom();
        savedNotice.value = true;
        if (savedTimer) clearTimeout(savedTimer);
        savedTimer = setTimeout(() => {
            savedNotice.value = false;
        }, 3000);
    } catch (exception) {
        error.value = exception.message || i18n.error;
    } finally {
        saving.value = false;
    }
};
</script>
