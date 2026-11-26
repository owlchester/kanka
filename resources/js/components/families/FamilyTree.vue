<template>
    <div class="flex flex-col gap-3 w-full">
        <!-- Toolbar -->
        <div v-if="!isLoading" class="flex flex-wrap items-center justify-between gap-2 bg-base-100 rounded-xl p-2.5">
            <!-- Left controls: View & Layout -->
            <div class="flex flex-wrap items-center gap-1.5">
                <button type="button" class="btn2 btn-sm btn-ghost" :title="texts?.actions?.fit || 'Fit'" @click="fitTree">
                    <i class="fa-solid fa-expand" aria-hidden="true"></i>
                    <span class="hidden sm:inline">{{ texts?.actions?.fit || 'Fit' }}</span>
                </button>

                <button type="button" class="btn2 btn-sm btn-ghost" :title="texts?.actions?.search || 'Search'" @click="searchOpen = true">
                    <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
                    <span class="hidden md:inline">{{ texts?.actions?.search || 'Search' }}</span>
                </button>

                <button
                    type="button"
                    class="btn2 btn-sm"
                    :class="showMinimap ? 'btn-primary' : 'btn-ghost'"
                    :title="texts?.actions?.minimap || 'Minimap'"
                    @click="showMinimap = !showMinimap"
                >
                    <i class="fa-regular fa-map" aria-hidden="true"></i>
                </button>

                <button
                    v-if="isEditing"
                    type="button"
                    class="btn2 btn-sm btn-ghost"
                    :title="graph.settings?.direction === 'LR' ? (texts?.actions?.direction_tb || 'Top to bottom') : (texts?.actions?.direction_lr || 'Left to right')"
                    @click="toggleDirection"
                >
                    <i class="fa-solid" :class="graph.settings?.direction === 'LR' ? 'fa-arrows-left-right' : 'fa-arrows-up-down'" aria-hidden="true"></i>
                </button>

                <button
                    v-if="isEditing"
                    type="button"
                    class="btn2 btn-sm"
                    :class="graph.settings?.compact ? 'btn-primary' : 'btn-ghost'"
                    :title="texts?.actions?.compact || 'Compact'"
                    @click="toggleCompact"
                >
                    <i class="fa-solid fa-compress" aria-hidden="true"></i>
                </button>

                <!-- Export -->
                <div class="relative">
                    <button type="button" class="btn2 btn-sm btn-ghost" @click="exportMenuOpen = !exportMenuOpen">
                        <i class="fa-solid fa-download" aria-hidden="true"></i>
                        <span class="hidden md:inline">{{ texts?.actions?.export || 'Export' }}</span>
                    </button>
                    <div
                        v-if="exportMenuOpen"
                        class="absolute left-0 mt-1 w-40 bg-base-100 rounded-xl shadow-sm border border-base-200 p-1 z-40 flex flex-col gap-0.5"
                    >
                        <button type="button" class="text-left text-sm px-3 py-1.5 rounded-lg hover:bg-base-200 cursor-pointer" @click="exportImage('png')">
                            {{ texts?.actions?.export_png || 'Export PNG' }}
                        </button>
                        <button type="button" class="text-left text-sm px-3 py-1.5 rounded-lg hover:bg-base-200 cursor-pointer" @click="exportImage('svg')">
                            {{ texts?.actions?.export_svg || 'Export SVG' }}
                        </button>
                    </div>
                </div>

                <!-- Admin Visibility Preview -->
                <select
                    v-if="isAdmin && !isEditing"
                    v-model="previewMode"
                    class="select select-bordered select-sm"
                    :title="texts?.preview?.label || 'Preview'"
                    @change="loadTree"
                >
                    <option value="">{{ texts?.preview?.admin || 'Admin view' }}</option>
                    <option value="member">{{ texts?.preview?.member || 'Member view' }}</option>
                    <option value="all">{{ texts?.preview?.all || 'Public view' }}</option>
                </select>
            </div>

            <!-- Right controls: Edit, Undo/Redo, Save -->
            <div v-if="permission && !previewMode" class="flex flex-wrap items-center gap-1.5">
                <template v-if="isEditing">
                    <button
                        type="button"
                        class="btn2 btn-sm btn-ghost"
                        :disabled="!canUndo"
                        :title="texts?.actions?.undo || 'Undo'"
                        @click="undo"
                    >
                        <i class="fa-solid fa-rotate-left" aria-hidden="true"></i>
                    </button>
                    <button
                        type="button"
                        class="btn2 btn-sm btn-ghost"
                        :disabled="!canRedo"
                        :title="texts?.actions?.redo || 'Redo'"
                        @click="redo"
                    >
                        <i class="fa-solid fa-rotate-right" aria-hidden="true"></i>
                    </button>
                    <button type="button" class="btn2 btn-sm btn-ghost" @click="resetTree">
                        <i class="fa-regular fa-redo" aria-hidden="true"></i>
                        {{ texts?.actions?.reset || 'Discard' }}
                    </button>
                    <button type="button" class="btn2 btn-sm btn-ghost text-error" @click="clearTree">
                        <i class="fa-regular fa-eraser" aria-hidden="true"></i>
                        {{ texts?.actions?.clear || 'Erase all' }}
                    </button>
                    <button
                        v-if="isDirty"
                        type="button"
                        class="btn2 btn-sm btn-primary"
                        :disabled="isSaving"
                        @click="saveTree"
                    >
                        <i class="fa-regular fa-save" aria-hidden="true"></i>
                        {{ texts?.actions?.save || 'Save' }}
                    </button>
                    <button
                        v-else
                        type="button"
                        class="btn2 btn-sm btn-outline"
                        @click="isEditing = false"
                    >
                        Done
                    </button>
                </template>
                <button v-else type="button" class="btn2 btn-sm btn-primary" @click="isEditing = true">
                    <i class="fa-regular fa-edit" aria-hidden="true"></i>
                    {{ texts?.actions?.edit || 'Edit' }}
                </button>
            </div>
        </div>

        <!-- Preview Banner -->
        <div v-if="previewMode" class="bg-info/15 text-info px-4 py-2 rounded-xl text-sm flex items-center justify-between">
            <span>
                <i class="fa-regular fa-eye mr-1.5" aria-hidden="true"></i>
                {{ (texts?.preview?.banner || 'Previewing tree as :mode.').replace(':mode', previewMode === 'all' ? (texts?.preview?.all || 'Public') : (texts?.preview?.member || 'Member')) }}
            </span>
            <button type="button" class="btn2 btn-xs btn-ghost" @click="previewMode = ''; loadTree()">
                Exit
            </button>
        </div>

        <!-- Loading -->
        <div v-if="isLoading" class="flex items-center justify-center py-20">
            <i class="fa-solid fa-spinner fa-spin fa-2x opacity-60" aria-hidden="true"></i>
            <span class="sr-only">Loading...</span>
        </div>

        <!-- Main Workspace: Canvas + Inspector -->
        <div v-else class="flex gap-4 items-stretch w-full">
            <div ref="canvasWrapper" class="kanka-ft-canvas flex-1">
                <!-- Empty State -->
                <div
                    v-if="graph.people.length === 0"
                    class="absolute inset-0 z-10 flex flex-col items-center justify-center gap-4 p-6 text-center"
                >
                    <div class="w-14 h-14 rounded-2xl bg-base-100 flex items-center justify-center text-2xl text-primary">
                        <i class="fa-solid fa-sitemap" aria-hidden="true"></i>
                    </div>
                    <div v-if="permission && isEditing" class="flex flex-col items-center gap-3">
                        <button
                            type="button"
                            class="btn2 btn-primary"
                            @click="openQuickAdd({ action: 'add-first' })"
                        >
                            <i class="fa-solid fa-plus" aria-hidden="true"></i>
                            {{ texts?.actions?.add_first || 'Add first person' }}
                        </button>
                    </div>
                    <div v-else class="text-sm text-neutral-content">
                        <button
                            v-if="permission && !previewMode"
                            type="button"
                            class="btn2 btn-primary"
                            @click="isEditing = true; openQuickAdd({ action: 'add-first' })"
                        >
                            <i class="fa-solid fa-plus" aria-hidden="true"></i>
                            {{ texts?.actions?.add_first || 'Add first person' }}
                        </button>
                    </div>
                </div>

                <VueFlow
                    v-model:nodes="vfNodes"
                    v-model:edges="vfEdges"
                    :node-types="nodeTypes"
                    :nodes-draggable="false"
                    :nodes-connectable="false"
                    :only-render-visible-elements="!isExporting"
                    :min-zoom="0.15"
                    :max-zoom="2.5"
                    @edge-click="onEdgeClick"
                    @pane-click="selection = null"
                >
                    <Background pattern-color="#94a3b8" :gap="24" :size="1" />
                    <Controls position="bottom-left" />
                    <MiniMap v-if="showMinimap" position="bottom-right" />
                </VueFlow>
            </div>

            <!-- Slide-Over Inspector -->
            <TreeInspector
                v-if="selection"
                :selection="selection"
                :graph="graph"
                :entities="entities"
                :linked-trees-map="linkedTrees"
                :texts="texts"
                :is-editing="isEditing"
                :can-create-character="canCreateCharacter"
                :search-api="search_api"
                :promote-api="promote_api"
                @close="selection = null"
                @update-person="handleUpdatePerson"
                @update-union="handleUpdateUnion"
                @update-link="handleUpdateLink"
                @delete-person="handleDeletePerson"
                @delete-union="handleDeleteUnion"
                @delete-link="handleDeleteLink"
                @quick-add="openQuickAdd"
                @link-character="handleLinkCharacter"
                @promote-character="handlePromoteCharacter"
            />
        </div>

        <!-- Quick Add Modal -->
        <QuickAddPopover
            :open="quickAddOpen"
            :context="quickAddContext"
            :search-api="search_api"
            :suggestions="suggestions"
            :existing-people="searchablePeople"
            :texts="texts"
            @close="quickAddOpen = false"
            @confirm="handleQuickAddConfirm"
        />

        <!-- Search Modal -->
        <TreeSearch
            :open="searchOpen"
            :people="searchablePeople"
            :placeholder="texts?.actions?.search || 'Search tree…'"
            :placeholder-badge="texts?.placeholders?.badge || 'Placeholder'"
            @close="searchOpen = false"
            @select="focusNodeById"
        />

        <!-- Premium Pitch Modal -->
        <dialog class="dialog rounded-t-2xl md:rounded-2xl bg-base-100 w-full md:w-[32rem] max-w-[90vw] shadow-sm text-base-content" id="family-tree-pitch" aria-modal="true" v-if="!isLoading">
            <header class="flex gap-6 items-center p-4 md:p-6 justify-between">
                <h4 class="text-lg font-normal" v-html="texts?.modals?.pitch?.title"></h4>
                <button autofocus type="button" class="text-xl opacity-50 hover:opacity-100 cursor-pointer" aria-label="Close" @click="closePitchModal">
                    <i class="fa-regular fa-circle-xmark" aria-hidden="true"></i>
                    <span class="sr-only">Close</span>
                </button>
            </header>
            <article class="max-w-2xl py-4 px-4 md:px-6">
                <p v-html="texts?.modals?.pitch?.content" class="text-neutral-content"></p>
                <div class="flex flex-col sm:flex-row gap-3 flex-wrap w-full mt-4">
                    <a href="https://kanka.io/premium" class="btn2 btn-outline btn-sm" v-html="texts?.modals?.pitch?.more"></a>
                    <a :href="subscribe_url" class="btn2 bg-boost text-white btn-sm" v-html="texts?.modals?.pitch?.subscription"></a>
                </div>
            </article>
        </dialog>
    </div>
</template>

<script setup>
import { computed, markRaw, nextTick, onBeforeUnmount, onMounted, provide, ref } from 'vue';
import axios from 'axios';
import { VueFlow, useVueFlow } from '@vue-flow/core';
import { Background } from '@vue-flow/background';
import { Controls } from '@vue-flow/controls';
import { MiniMap } from '@vue-flow/minimap';
import { toPng, toSvg } from 'html-to-image';
import { createGraphStore, emptyGraph } from '../../families/graphStore';
import { layoutGraph, NODE_DIMENSIONS } from '../../families/layout';
import PersonNode from './PersonNode.vue';
import UnionNode from './UnionNode.vue';
import QuickAddPopover from './QuickAddPopover.vue';
import TreeInspector from './TreeInspector.vue';
import TreeSearch from './TreeSearch.vue';

const props = defineProps({
    api: { type: String, required: true },
    save_api: { type: String, required: true },
    entity_api: { type: String, required: true },
    promote_api: { type: String, required: true },
    search_api: { type: String, required: true },
    subscribe_url: { type: String, required: true },
    family_name: { type: String, default: 'family' },
    focus_entity: { type: String, default: '' },
    permission: { type: Boolean, default: false },
});

const nodeTypes = {
    person: markRaw(PersonNode),
    union: markRaw(UnionNode),
};

const { fitView, getNodesBounds } = useVueFlow();

const store = createGraphStore();
const graph = ref(emptyGraph());
const entities = ref({});
const linkedTrees = ref({});
const suggestions = ref([]);
const texts = ref({});
const canCreateCharacter = ref(false);
const isAdmin = ref(false);

const vfNodes = ref([]);
const vfEdges = ref([]);
const isLoading = ref(true);
const isEditing = ref(false);
const isSaving = ref(false);
const isExporting = ref(false);
const isDirty = ref(false);
const canUndo = ref(false);
const canRedo = ref(false);

const selection = ref(null);
const focusedNodeId = ref(null);
const quickAddOpen = ref(false);
const quickAddContext = ref(null);
const searchOpen = ref(false);
const showMinimap = ref(false);
const exportMenuOpen = ref(false);
const previewMode = ref('');
const canvasWrapper = ref(null);

let layoutSeq = 0;
let focusTimer = null;

function syncStoreFlags() {
    graph.value = store.getState();
    isDirty.value = store.isDirty();
    canUndo.value = store.canUndo();
    canRedo.value = store.canRedo();
}

async function refreshLayout(shouldFit = false) {
    const seq = ++layoutSeq;
    const { nodes, edges } = await layoutGraph(graph.value, entities.value, linkedTrees.value, texts.value);
    if (seq !== layoutSeq) {
        return;
    }
    vfNodes.value = nodes;
    vfEdges.value = edges;

    if (shouldFit && nodes.length > 0) {
        await nextTick();
        fitView({ padding: 0.2, duration: 300 });
    }
}

async function ensureEntityLoaded(entityId) {
    const id = Number(entityId);
    if (!id || entities.value[id]) {
        return;
    }
    const url = props.entity_api.replace('/0', `/${id}`);
    const resp = await axios.get(url);
    if (resp.data && resp.data.id) {
        entities.value = { ...entities.value, [resp.data.id]: resp.data };
    }
}

async function loadTree() {
    isLoading.value = true;
    selection.value = null;
    try {
        const params = previewMode.value ? { preview_visibility: previewMode.value } : {};
        const resp = await axios.get(props.api, { params });
        const data = resp.data || {};
        store.setInitial(data.graph || emptyGraph());
        entities.value = data.entities || {};
        linkedTrees.value = data.linked_trees || {};
        suggestions.value = data.suggestions || [];
        canCreateCharacter.value = Boolean(data.can_create_character);
        isAdmin.value = Boolean(data.is_admin);
        texts.value = data.texts || {};
        syncStoreFlags();
        await refreshLayout(true);

        if (props.focus_entity) {
            const target = graph.value.people.find((p) => Number(p.entity_id) === Number(props.focus_entity));
            if (target) {
                await nextTick();
                focusNodeById(target.id);
            }
        }
    } finally {
        isLoading.value = false;
    }
}

function focusNodeById(nodeId) {
    clearTimeout(focusTimer);
    focusedNodeId.value = nodeId;
    fitView({ nodes: [nodeId], padding: 1.4, duration: 450 });
    focusTimer = setTimeout(() => {
        focusedNodeId.value = null;
    }, 3600);
}

function fitTree() {
    fitView({ padding: 0.2, duration: 350 });
}

function openQuickAdd(context) {
    quickAddContext.value = context;
    quickAddOpen.value = true;
}

async function handleQuickAddConfirm({ context, personData, peopleData, unionType, unionRole, linkKind, linkLabel }) {
    quickAddOpen.value = false;
    const list = Array.isArray(peopleData) && peopleData.length > 0 ? peopleData : [personData];

    const entityIdsToLoad = [...new Set(list.map((p) => p?.entity_id).filter(Boolean))];
    if (entityIdsToLoad.length > 0) {
        await Promise.all(entityIdsToLoad.map((id) => ensureEntityLoaded(id)));
    }

    switch (context?.action) {
        case 'add-first':
            store.addFirstPerson(list[0]);
            break;
        case 'add-parent':
            store.addParent(context.personId, list[0], linkKind, linkLabel);
            break;
        case 'add-partner':
            store.addPartner(context.personId, list[0], unionType, unionRole);
            break;
        case 'add-child':
            store.addChildrenFromPerson(context.personId, list, linkKind, linkLabel);
            break;
        case 'add-union-child':
            store.addChildrenFromUnion(context.unionId, list, linkKind, linkLabel);
            break;
    }

    syncStoreFlags();
    await refreshLayout(false);
}

function handleUpdatePerson({ id, patch }) {
    store.updatePerson(id, patch);
    syncStoreFlags();
    refreshLayout(false);
}

function handleUpdateUnion({ id, patch }) {
    store.updateUnion(id, patch);
    syncStoreFlags();
    refreshLayout(false);
}

function handleUpdateLink({ id, patch }) {
    store.updateLink(id, patch);
    syncStoreFlags();
    refreshLayout(false);
}

function handleDeletePerson(personId) {
    if (!confirm(texts.value?.inspector?.delete_person_confirm || 'Remove this person from the family tree?')) {
        return;
    }
    store.deletePerson(personId);
    selection.value = null;
    syncStoreFlags();
    refreshLayout(false);
}

function handleDeleteUnion(unionId) {
    store.deleteUnion(unionId);
    selection.value = null;
    syncStoreFlags();
    refreshLayout(false);
}

function handleDeleteLink(linkId) {
    store.deleteLink(linkId);
    selection.value = null;
    syncStoreFlags();
    refreshLayout(false);
}

async function handleLinkCharacter({ personId, entityId }) {
    await ensureEntityLoaded(entityId);
    store.updatePerson(personId, { entity_id: entityId, placeholder: null });
    syncStoreFlags();
    await refreshLayout(false);
}

async function handlePromoteCharacter({ personId, entity }) {
    entities.value = { ...entities.value, [entity.id]: entity };
    store.promotePlaceholder(personId, entity.id);
    syncStoreFlags();
    await refreshLayout(false);
    window.showToast?.(texts.value?.inspector?.promote_success || 'Character created and linked.');
}

function toggleDirection() {
    const next = graph.value.settings?.direction === 'LR' ? 'TB' : 'LR';
    store.updateSettings({ direction: next });
    syncStoreFlags();
    refreshLayout(true);
}

function toggleCompact() {
    const next = !graph.value.settings?.compact;
    store.updateSettings({ compact: next });
    syncStoreFlags();
    refreshLayout(true);
}

function undo() {
    if (store.undo()) {
        selection.value = null;
        syncStoreFlags();
        refreshLayout(false);
    }
}

function redo() {
    if (store.redo()) {
        selection.value = null;
        syncStoreFlags();
        refreshLayout(false);
    }
}

function resetTree() {
    if (!isDirty.value || confirm(texts.value?.modals?.reset?.confirm || 'Discard unsaved changes?')) {
        store.reset();
        selection.value = null;
        isEditing.value = false;
        syncStoreFlags();
        refreshLayout(true);
        window.showToast?.(texts.value?.toasts?.reseted || 'Family tree reset.');
    }
}

function clearTree() {
    if (confirm(texts.value?.modals?.clear?.confirm || 'Erase all entries from the family tree?')) {
        store.clear();
        selection.value = null;
        syncStoreFlags();
        refreshLayout(false);
        window.showToast?.(texts.value?.toasts?.cleared || 'Family tree erased.');
    }
}

async function saveTree() {
    if (isSaving.value) {
        return;
    }
    isSaving.value = true;
    try {
        const resp = await axios.post(props.save_api, { data: store.getState() });
        if (resp.status === 204) {
            window.openDialog?.('family-tree-pitch');
            return;
        }
        const data = resp.data || {};
        store.markClean(data.graph || store.getState());
        entities.value = data.entities || entities.value;
        linkedTrees.value = data.linked_trees || linkedTrees.value;
        syncStoreFlags();
        await refreshLayout(false);
        window.showToast?.(texts.value?.toasts?.saved || 'Family tree saved.');
    } catch {
        window.openDialog?.('family-tree-pitch');
    } finally {
        isSaving.value = false;
    }
}

function closePitchModal() {
    window.closeDialog?.('family-tree-pitch');
}

function onEdgeClick({ edge }) {
    if (edge?.data?.kind === 'lineage' && edge.data.link) {
        selection.value = { type: 'link', id: edge.data.link.id };
    } else if (edge?.data?.kind === 'union-partner' && edge.data.union) {
        selection.value = { type: 'union', id: edge.data.union.id };
    }
}

function computeFallbackBounds() {
    if (vfNodes.value.length === 0) {
        return { x: 0, y: 0, width: 400, height: 300 };
    }
    let minX = Infinity;
    let minY = Infinity;
    let maxX = -Infinity;
    let maxY = -Infinity;
    for (const node of vfNodes.value) {
        const x = node.position?.x ?? 0;
        const y = node.position?.y ?? 0;
        let w = NODE_DIMENSIONS.normal.width;
        let h = NODE_DIMENSIONS.normal.height;
        if (node.type === 'union') {
            w = node.data?.union?.role ? NODE_DIMENSIONS.unionWithRole.width : NODE_DIMENSIONS.union.width;
            h = node.data?.union?.role ? NODE_DIMENSIONS.unionWithRole.height : NODE_DIMENSIONS.union.height;
        } else if (node.data?.compact) {
            w = NODE_DIMENSIONS.compact.width;
            h = NODE_DIMENSIONS.compact.height;
        }
        minX = Math.min(minX, x);
        minY = Math.min(minY, y);
        maxX = Math.max(maxX, x + w);
        maxY = Math.max(maxY, y + h);
    }
    return {
        x: minX,
        y: minY,
        width: Math.max(1, maxX - minX),
        height: Math.max(1, maxY - minY),
    };
}

async function exportImage(format) {
    exportMenuOpen.value = false;
    if (vfNodes.value.length === 0) {
        return;
    }

    const previousSelection = selection.value;
    selection.value = null;
    focusedNodeId.value = null;
    isExporting.value = true;

    try {
        await nextTick();
        await new Promise((resolve) => requestAnimationFrame(resolve));

        const el = canvasWrapper.value?.querySelector('.vue-flow__viewport');
        if (!el) {
            return;
        }

        // Ensure SVG edge paths have explicit fill="none" and inlined stroke styles for html-to-image
        el.querySelectorAll('.vue-flow__edge-path').forEach((pathEl) => {
            pathEl.setAttribute('fill', 'none');
            const computed = window.getComputedStyle(pathEl);
            if (computed.stroke && computed.stroke !== 'none') {
                pathEl.style.stroke = computed.stroke;
            }
            if (computed.strokeWidth) {
                pathEl.style.strokeWidth = computed.strokeWidth;
            }
            if (computed.strokeDasharray && computed.strokeDasharray !== 'none') {
                pathEl.style.strokeDasharray = computed.strokeDasharray;
            }
        });

        el.querySelectorAll('.vue-flow__edge-textbg').forEach((rectEl) => {
            const computedFill = window.getComputedStyle(rectEl).fill;
            const safeFill = computedFill && computedFill !== 'none' && computedFill !== 'rgb(0, 0, 0)'
                ? computedFill
                : '#ffffff';
            rectEl.setAttribute('fill', safeFill);
            rectEl.style.fill = safeFill;
        });

        el.querySelectorAll('.vue-flow__edge-text').forEach((textEl) => {
            const computed = window.getComputedStyle(textEl);
            const safeFill = computed.fill && computed.fill !== 'none' ? computed.fill : '#1f2937';
            textEl.setAttribute('fill', safeFill);
            textEl.style.fill = safeFill;
            if (computed.fontSize) {
                textEl.style.fontSize = computed.fontSize;
            }
            if (computed.fontWeight) {
                textEl.style.fontWeight = computed.fontWeight;
            }
        });

        let bounds = typeof getNodesBounds === 'function' ? getNodesBounds(vfNodes.value) : null;
        if (!bounds || !Number.isFinite(bounds.width) || bounds.width <= 0 || bounds.height <= 0) {
            bounds = computeFallbackBounds();
        }

        const padding = 48;
        const imageWidth = Math.ceil(bounds.width + padding * 2);
        const imageHeight = Math.ceil(bounds.height + padding * 2);

        const bg = window.getComputedStyle(document.body).backgroundColor;
        const backgroundColor = bg && bg !== 'rgba(0, 0, 0, 0)' && bg !== 'transparent' ? bg : '#ffffff';

        const options = {
            backgroundColor,
            width: imageWidth,
            height: imageHeight,
            cacheBust: true,
            style: {
                width: `${imageWidth}px`,
                height: `${imageHeight}px`,
                transform: `translate(${-bounds.x + padding}px, ${-bounds.y + padding}px) scale(1)`,
            },
            filter: (node) => {
                if (!node || !node.classList) {
                    return true;
                }
                if (
                    node.classList.contains('vue-flow__edge-interaction') ||
                    node.classList.contains('kanka-ft-action-btn') ||
                    node.classList.contains('vue-flow__handle')
                ) {
                    return false;
                }
                return true;
            },
        };

        const slug = (props.family_name || 'family').toLowerCase().replace(/[^a-z0-9]+/g, '-');
        const dataUrl = format === 'svg' ? await toSvg(el, options) : await toPng(el, { ...options, pixelRatio: 2 });

        const a = document.createElement('a');
        a.href = dataUrl;
        a.download = `${slug}-family-tree.${format}`;
        a.click();
        window.showToast?.(texts.value?.toasts?.exported || 'Family tree exported.');
    } finally {
        isExporting.value = false;
        selection.value = previousSelection;
    }
}

const searchablePeople = computed(() =>
    (graph.value.people || []).map((p) => {
        const entity = p.entity_id ? entities.value[p.entity_id] : null;
        const label = entity?.name || p.placeholder?.name || texts.value?.placeholders?.unknown || 'Unknown';
        return {
            id: p.id,
            label,
            isPlaceholder: !p.entity_id,
        };
    })
);

function onKeyDown(e) {
    if ((e.metaKey || e.ctrlKey) && e.key.toLowerCase() === 'k') {
        e.preventDefault();
        searchOpen.value = true;
        return;
    }
    if (isEditing.value && (e.metaKey || e.ctrlKey) && e.key.toLowerCase() === 'z') {
        e.preventDefault();
        if (e.shiftKey) {
            redo();
        } else {
            undo();
        }
        return;
    }
    if (e.key === 'Escape') {
        selection.value = null;
        quickAddOpen.value = false;
        searchOpen.value = false;
        exportMenuOpen.value = false;
    }
}

provide('familyTreeContext', {
    isEditing,
    focusedNodeId,
    texts,
    selectElement: (sel) => {
        selection.value = sel;
    },
    openQuickAdd,
});

onMounted(() => {
    window.addEventListener('keydown', onKeyDown);
    loadTree();
});

onBeforeUnmount(() => {
    window.removeEventListener('keydown', onKeyDown);
    clearTimeout(focusTimer);
});
</script>
