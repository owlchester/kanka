<template>
    <div v-if="!isLoading && permission" class="flex flex-wrap gap-2 mb-5 justify-end items-center">
        <button v-if="!isEditing" class="btn2 btn-sm btn-primary" @click="startEditing">
            <i class="fa-regular fa-edit" aria-hidden="true"></i>
            {{ texts.actions.edit }}
        </button>
        <button v-if="isEditing" class="btn2 btn-sm" @click="resetTree">
            <i class="fa-regular fa-redo" aria-hidden="true"></i>
            {{ texts.actions.reset }}
        </button>
        <button v-if="isEditing" class="btn2 btn-sm" @click="clearTree">
            <i class="fa-regular fa-eraser" aria-hidden="true"></i>
            {{ texts.actions.clear }}
        </button>
        <button v-if="isEditing" class="btn2 btn-sm" @click="openAddNode">
            <i class="fa-regular fa-user" aria-hidden="true"></i>
            {{ texts.actions.founder }}
        </button>
        <button v-if="isEditing && isDirty" class="btn2 btn-primary" @click="saveTree">
            <i class="fa-regular fa-save" aria-hidden="true"></i>
            {{ texts.actions.save }}
        </button>
    </div>

    <div
        ref="familytree"
        class="family-tree overflow-auto w-full h-full min-h-50 block relative"
        :class="{ 'is-panning': isPanning }"
        @pointerdown="startPan"
        @pointermove="pan"
        @pointerup="endPan"
        @pointercancel="endPan"
    >
        <div class="family-tree-zoom absolute top-0 right-0 z-10 flex gap-1">
            <button class="btn2 btn-ghost btn-sm" aria-label="Zoom in" @click="zoom(0.15)">
                <i class="fa-regular fa-square-plus" aria-hidden="true"></i>
            </button>
            <button class="btn2 btn-ghost btn-sm" aria-label="Zoom out" @click="zoom(-0.15)">
                <i class="fa-regular fa-square-minus" aria-hidden="true"></i>
            </button>
        </div>

        <div v-if="isLoading" class="text-center px-5">
            <i class="fa-solid fa-spinner fa-spin fa-2x" aria-hidden="true"></i>
            <span class="sr-only">Loading...</span>
        </div>

        <div v-else class="family-tree-scroll-area">
            <div v-if="!graph.nodes.length && isEditing" class="family-tree-empty">
                <button class="btn2 btn-primary" @click="openAddNode">
                    <i class="fa-regular fa-plus" aria-hidden="true"></i>
                    {{ texts.actions.first }}
                </button>
            </div>
            <div
                v-else
                class="family-tree-canvas"
                :style="canvasStyle"
            >
                <svg class="family-tree-edges" :width="layout.width" :height="layout.height" aria-hidden="true">
                    <defs>
                        <marker id="family-tree-arrow" markerWidth="8" markerHeight="8" refX="7" refY="4" orient="auto">
                            <path d="M0,0 L8,4 L0,8 z" />
                        </marker>
                    </defs>
                    <path
                        v-for="edge in layout.edges"
                        :key="edge.id"
                        :class="edgeClasses(edge)"
                        :d="edge.path"
                        :data-type="edge.type === 'child' ? edge.child_type : undefined"
                        :data-status="edge.partner_status"
                        :style="edgeStyle(edge)"
                        @click="isEditing && openEditEdge(edge)"
                    />
                </svg>

                <div
                    v-for="node in layout.nodes"
                    :key="node.id"
                    class="family-node-entity rounded-2xl px-2 flex items-center absolute overflow-hidden text-base leading-none"
                    :class="nodeClasses(node)"
                    :style="nodeStyle(node)"
                    :data-uuid="node.id"
                    :data-entity="node.entity_id || undefined"
                    :data-type="node.childType"
                >
                    <div class="flex items-center gap-1 max-w-full w-full">
                        <div class="flex-none">
                            <span v-if="node.isUnknown" class="truncate">
                                <i class="fa-regular fa-3x fa-question" aria-hidden="true"></i>
                            </span>
                            <a v-else-if="entity(node)" :href="entity(node).url">
                                <img :src="entity(node).thumb" class="rounded-full entity-image w-10 h-10" :alt="entity(node).name" />
                            </a>
                        </div>
                        <div class="grow justify-center truncate">
                            <a v-if="!node.isUnknown && entity(node)" :href="entity(node).url" class="truncate flex gap-1" :title="entity(node).name">
                                <span class="truncate">{{ entity(node).name }}</span>
                                <span v-if="entity(node).status" class="self-end text-neutral-content text-xs">
                                    <i :class="entity(node).status.icon" :title="entity(node).status.name" aria-hidden="true"></i>
                                </span>
                            </a>
                            <span v-else class="block"><i>{{ texts.unknown }}</i></span>
                            <span v-if="node.hasChildRelationship" class="family-tree-card-child-type text-2xs uppercase">
                                {{ childCardLabel(node) }}
                            </span>
                            <span v-if="node.hasPartnerRelationship" class="family-tree-card-partner-type text-2xs uppercase">
                                {{ partnerCardLabel(node) }}
                            </span>
                            <span v-if="entity(node)?.birth" class="text-xs">{{ entity(node).birth }}</span>
                            <span v-if="entity(node)?.birth && entity(node)?.death" class="text-xs"> - </span>
                            <span v-if="entity(node)?.death" class="text-xs">✝ {{ entity(node).death }}</span>
                            <div v-if="isEditing" class="flex gap-2 mt-1">
                                <button class="cursor-pointer" :title="texts.modals.entity.edit.title" @click="openEditNode(node)">
                                    <i class="fa-regular fa-pencil" aria-hidden="true"></i><span class="sr-only">{{ texts.modals.entity.edit.title }}</span>
                                </button>
                                <button class="cursor-pointer" :title="texts.modals.relation.add.title" @click="openAddPartner(node.id)">
                                    <i class="fa-regular fa-user-plus" aria-hidden="true"></i><span class="sr-only">{{ texts.modals.relation.add.title }}</span>
                                </button>
                                <button class="cursor-pointer" :title="texts.modals.entity.child.title" @click="openAddChild(node.id)">
                                    <i class="fa-regular fa-baby" aria-hidden="true"></i><span class="sr-only">{{ texts.modals.entity.child.title }}</span>
                                </button>
                                <button class="cursor-pointer" :title="texts.modals.entity.remove.title" @click="removeNode(node.id)">
                                    <i class="fa-regular fa-trash-can" aria-hidden="true"></i><span class="sr-only">{{ texts.modals.entity.remove.title }}</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <dialog v-if="!isLoading" id="family-tree-modal" class="dialog rounded-top md:rounded-2xl bg-base-100 min-w-fit shadow-md text-base-content" aria-modal="true">
        <header class="flex gap-6 items-center p-4 md:p-6 justify-between">
            <h4 class="text-lg font-normal">{{ modalTitle }}</h4>
            <button autofocus type="button" class="text-xl opacity-50 hover:opacity-100 focus:opacity-100 cursor-pointer" aria-label="Close" @click="closeModal">
                <i class="fa-regular fa-circle-xmark" aria-hidden="true"></i>
                <span class="sr-only">Close</span>
            </button>
        </header>
        <article class="max-w-2xl py-4 px-4 md:px-6">
            <div class="flex flex-col gap-5 w-full">
                <div v-if="isNodeModal" class="field flex flex-col gap-1 w-full">
                    <label>{{ texts.modals.fields.character }}</label>
                    <select ref="entityField" class="select2 w-full" style="width: 100%" :data-url="search_api" data-placeholder="Choose a character" data-language="en" data-allow-clear="true" name="character_id_ft" data-dropdown-parent="#family-tree-modal" v-model="selectedEntityId">
                        <option v-for="suggestion in suggestions" :key="suggestion.id" :value="suggestion.id">{{ suggestion.name }}</option>
                    </select>
                </div>
                <div v-if="isNodeModal" class="field checkbox flex flex-col gap-1">
                    <label><input v-model="isUnknown" type="checkbox" /> {{ texts.modals.fields.unknown }}</label>
                    <p class="help-block text-neutral-content">{{ texts.modals.entity.edit.helper }}</p>
                </div>
                <div v-if="isPartnerModal" class="field flex flex-col gap-1">
                    <label>{{ texts.modals.fields.partner_status }}</label>
                    <select v-model="partnerStatus" class="w-full">
                        <option value="current">{{ texts.modals.fields.partners.current }}</option>
                        <option value="former">{{ texts.modals.fields.partners.former }}</option>
                    </select>
                </div>
                <div v-if="isChildModal" class="field flex flex-col gap-1">
                    <label>{{ texts.modals.fields.child_type }}</label>
                    <select v-model.number="childTypeValue" class="w-full">
                        <option v-for="(type, value) in texts.child_types" :key="value" :value="Number(value)">{{ type.label }}</option>
                    </select>
                </div>
                <div v-if="isPartnerModal || (isChildModal && childTypeValue === 5)" class="field flex flex-col gap-1">
                    <label>{{ isChildModal ? texts.modals.fields.custom_role : texts.modals.fields.relation }}</label>
                    <input v-model="role" type="text" maxlength="70" class="w-full" @keyup.enter="saveModal" />
                </div>
                <div v-if="isNodeModal || isEdgeModal" class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div class="field flex flex-col gap-1">
                        <label>{{ texts.modals.fields.colour }}</label>
                        <input v-model="colour" type="text" maxlength="7" class="w-full" />
                    </div>
                    <div class="field flex flex-col gap-1">
                        <label>{{ texts.modals.fields.visibility.title }}</label>
                        <select v-model.number="visibility" class="w-full">
                            <option :value="1">{{ texts.modals.fields.visibility.all }}</option>
                            <option :value="2">{{ texts.modals.fields.visibility.admins }}</option>
                            <option :value="5">{{ texts.modals.fields.visibility.members }}</option>
                        </select>
                    </div>
                    <div class="field flex flex-col gap-1 sm:col-span-2">
                        <label>{{ texts.modals.fields.css }}</label>
                        <input v-model="cssClass" type="text" maxlength="70" class="w-full" />
                    </div>
                </div>
            </div>
        </article>
        <footer class="flex flex-wrap gap-3 justify-end items-center p-4 md:px-6">
            <button class="btn2 btn-primary" @click="saveModal">{{ texts.actions.save }}</button>
        </footer>
    </dialog>
</template>

<script>
import axios from 'axios'
import { layoutFamilyTree } from '../../family-tree-layout.js'

export default {
    props: {
        api: undefined,
        save_api: undefined,
        entity_api: undefined,
        search_api: undefined,
        permission: undefined,
        subscribe_url: undefined,
    },
    data() {
        return {
            graph: { version: 2, nodes: [], edges: [] },
            entities: {},
            suggestions: [],
            texts: { actions: {}, fields: {}, modals: { entity: {}, relations: {} }, child_types: {} },
            isEditing: false,
            isLoading: true,
            isDirty: false,
            originalGraph: undefined,
            modalMode: undefined,
            modalNodeId: undefined,
            modalEdgeId: undefined,
            sourceNodeId: undefined,
            selectedEntityId: '',
            isUnknown: false,
            role: '',
            partnerStatus: 'current',
            childTypeValue: 1,
            cssClass: '',
            colour: '',
            visibility: 1,
            scale: 1,
            modal: 'family-tree-modal',
            isPanning: false,
            panStart: { x: 0, y: 0, scrollLeft: 0, scrollTop: 0 },
        }
    },
    computed: {
        layout() {
            return layoutFamilyTree(this.graph)
        },
        canvasStyle() {
            return {
                width: `${this.layout.width}px`,
                height: `${this.layout.height}px`,
                transform: `scale(${this.scale})`,
                transformOrigin: 'top left',
            }
        },
        modalEdge() {
            return this.graph.edges.find((edge) => edge.id === this.modalEdgeId)
        },
        isNodeModal() {
            return ['node-add', 'node-edit', 'partner-add', 'child-add'].includes(this.modalMode)
        },
        isEdgeModal() {
            return this.modalMode === 'edge-edit'
        },
        isPartnerModal() {
            return this.modalMode === 'partner-add' || (this.isEdgeModal && this.modalEdge?.type === 'partner')
        },
        isChildModal() {
            return this.modalMode === 'child-add' || (this.isEdgeModal && this.modalEdge?.type === 'child')
        },
        modalTitle() {
            if (this.modalMode === 'partner-add') return this.texts.modals.relation.add.title
            if (this.modalMode === 'child-add') return this.texts.modals.entity.child.title
            if (this.modalMode === 'edge-edit') return this.texts.modals.relation.edit.title
            return this.modalMode === 'node-edit' ? this.texts.modals.entity.edit.title : this.texts.modals.entity.add.title
        },
    },
    methods: {
        entity(node) {
            return node?.entity_id ? this.entities[node.entity_id] : undefined
        },
        childType(value) {
            return this.texts.child_types?.[value] || this.texts.child_types?.[1] || { label: '', icon: '' }
        },
        childCardLabel(node) {
            return node.childType === 5
                ? (node.childRole || this.childType(node.childType).label)
                : this.childType(node.childType).label
        },
        partnerCardLabel(node) {
            const status = node.partnerStatus === 'former' ? this.texts.modals.fields.partners.former : null
            if (node.partnerRole && status) {
                return `${node.partnerRole} (${status})`
            }

            return node.partnerRole || status || this.texts.unknown
        },
        nodeClasses(node) {
            return [node.cssClass, node.isUnknown ? 'unknown-character' : '', node.childType ? `family-node-child-type-${node.childType}` : '']
        },
        nodeStyle(node) {
            return { left: `${node.x}px`, top: `${node.y}px`, '--family-tree-node-colour': node.colour || '' }
        },
        edgeClasses(edge) {
            return [
                'family-tree-edge',
                `family-tree-edge-${edge.type}`,
                edge.partner_status === 'former' ? 'family-tree-edge-former' : '',
                edge.cssClass || '',
            ]
        },
        edgeStyle(edge) {
            return edge.colour ? { stroke: edge.colour } : {}
        },
        zoom(amount) {
            this.scale = Math.min(2, Math.max(0.5, this.scale + amount))
        },
        startPan(event) {
            const target = event.target instanceof Element ? event.target : null
            if (event.button !== 0 || target?.closest('button, a, input, select, path, .family-node-entity')) {
                return
            }
            this.isPanning = true
            this.panStart = {
                x: event.clientX,
                y: event.clientY,
                scrollLeft: this.$refs.familytree.scrollLeft,
                scrollTop: this.$refs.familytree.scrollTop,
            }
            event.currentTarget.setPointerCapture(event.pointerId)
        },
        pan(event) {
            if (!this.isPanning) {
                return
            }
            this.$refs.familytree.scrollLeft = this.panStart.scrollLeft - (event.clientX - this.panStart.x)
            this.$refs.familytree.scrollTop = this.panStart.scrollTop - (event.clientY - this.panStart.y)
            event.preventDefault()
        },
        endPan(event) {
            if (!this.isPanning) {
                return
            }
            this.isPanning = false
            if (event.currentTarget.hasPointerCapture?.(event.pointerId)) {
                event.currentTarget.releasePointerCapture(event.pointerId)
            }
        },
        startEditing() {
            this.isEditing = true
        },
        resetTree() {
            if (!this.isDirty || confirm(this.texts.modals.reset.confirm)) {
                this.graph = JSON.parse(JSON.stringify(this.originalGraph))
                this.isEditing = false
                this.isDirty = false
                window.showToast(this.texts.toasts.reseted)
            }
        },
        clearTree() {
            if (confirm(this.texts.modals.clear.confirm)) {
                this.graph = { version: 2, nodes: [], edges: [] }
                this.isDirty = this.originalGraph.nodes.length > 0
                window.showToast(this.texts.toasts.cleared)
            }
        },
        openAddNode() {
            this.resetModal()
            this.modalMode = 'node-add'
            this.showDialog()
        },
        openAddPartner(sourceNodeId) {
            this.resetModal()
            this.modalMode = 'partner-add'
            this.sourceNodeId = sourceNodeId
            this.showDialog()
        },
        openAddChild(sourceNodeId) {
            this.resetModal()
            this.modalMode = 'child-add'
            this.sourceNodeId = sourceNodeId
            this.showDialog()
        },
        openEditNode(node) {
            this.resetModal()
            this.modalMode = 'node-edit'
            this.modalNodeId = node.id
            this.selectedEntityId = node.entity_id || ''
            this.isUnknown = node.isUnknown
            this.cssClass = node.cssClass || ''
            this.colour = node.colour || ''
            this.visibility = node.visibility || 1
            this.showDialog()
        },
        openEditEdge(edge) {
            this.resetModal()
            this.modalMode = 'edge-edit'
            this.modalEdgeId = edge.id
            this.role = edge.role || ''
            this.partnerStatus = edge.partner_status || 'current'
            this.childTypeValue = Number(edge.child_type || 1)
            this.cssClass = edge.cssClass || ''
            this.colour = edge.colour || ''
            this.visibility = edge.visibility || 1
            this.showDialog()
        },
        showDialog() {
            this.$nextTick(() => {
                window.openDialog(this.modal)
                window.initForeignSelect?.()
                window.triggerEvent?.()
            })
        },
        closeModal() {
            this.modalMode = undefined
            this.modalNodeId = undefined
            this.modalEdgeId = undefined
            this.sourceNodeId = undefined
            window.closeDialog(this.modal)
            this.$refs.entityField?.tomselect?.clear()
        },
        resetModal() {
            this.modalMode = undefined
            this.modalNodeId = undefined
            this.modalEdgeId = undefined
            this.sourceNodeId = undefined
            this.selectedEntityId = ''
            this.isUnknown = false
            this.role = ''
            this.partnerStatus = 'current'
            this.childTypeValue = 1
            this.cssClass = ''
            this.colour = ''
            this.visibility = 1
        },
        selectedId() {
            return this.$refs.entityField?.tomselect?.getValue() || this.selectedEntityId
        },
        async fetchEntity(id) {
            const url = this.entity_api.replace('/0', `/${id}`)
            const response = await axios.get(url)
            this.entities[response.data.id] = response.data
            return response.data
        },
        newId() {
            return globalThis.crypto?.randomUUID?.() || `local-${Date.now()}-${Math.random()}`
        },
        async saveModal() {
            if (this.modalMode === 'edge-edit') {
                this.saveEdge()
                return
            }

            const entityId = this.selectedId()
            if (!entityId && !this.isUnknown) {
                this.closeModal()
                return
            }
            if (this.modalMode === 'child-add' && this.childTypeValue === 5 && !this.role.trim()) {
                window.showToast(this.texts.modals.entity.child.custom_required)
                return
            }

            let entity = null
            if (entityId && !this.isUnknown) {
                entity = await this.fetchEntity(entityId)
            }
            if (this.modalMode === 'node-edit') {
                const node = this.graph.nodes.find((item) => item.id === this.modalNodeId)
                Object.assign(node, this.nodeData(entityId, this.isUnknown))
                this.isDirty = true
                this.closeModal()
                return
            }

            const node = { id: this.newId(), ...this.nodeData(entityId, this.isUnknown) }
            this.graph.nodes.push(node)
            if (this.modalMode === 'partner-add' || this.modalMode === 'child-add') {
                this.graph.edges.push({
                    id: this.newId(),
                    source: this.sourceNodeId,
                    target: node.id,
                    type: this.modalMode === 'child-add' ? 'child' : 'partner',
                    role: this.modalMode === 'child-add' && this.childTypeValue !== 5 ? null : (this.role || null),
                    child_type: this.modalMode === 'child-add' ? this.childTypeValue : undefined,
                    partner_status: this.modalMode === 'partner-add' ? this.partnerStatus : undefined,
                    cssClass: this.cssClass,
                    colour: this.colour,
                    visibility: this.visibility,
                })
            }
            this.isDirty = true
            window.showToast(this.modalMode === 'child-add' ? this.texts.toasts.entity.child : this.texts.toasts.entity.add)
            this.closeModal()
        },
        nodeData(entityId, unknown) {
            return {
                entity_id: unknown ? null : Number(entityId),
                isUnknown: unknown,
                cssClass: this.cssClass,
                colour: this.colour,
                visibility: this.visibility,
            }
        },
        saveEdge() {
            const edge = this.modalEdge
            if (!edge) return
            if (edge.type === 'child' && this.childTypeValue === 5 && !this.role.trim()) {
                window.showToast(this.texts.modals.entity.child.custom_required)
                return
            }
            edge.role = this.role || null
            edge.cssClass = this.cssClass
            edge.colour = this.colour
            edge.visibility = this.visibility
            if (edge.type === 'child') {
                edge.child_type = this.childTypeValue
            } else {
                edge.partner_status = this.partnerStatus
            }
            this.isDirty = true
            window.showToast(edge.type === 'child' ? this.texts.toasts.relations.edit : this.texts.toasts.relations.edit)
            this.closeModal()
        },
        removeNode(id) {
            if (!confirm(this.texts.modals.entity.remove.confirm)) return
            this.graph.nodes = this.graph.nodes.filter((node) => node.id !== id)
            this.graph.edges = this.graph.edges.filter((edge) => edge.source !== id && edge.target !== id)
            this.isDirty = true
            window.showToast(this.texts.toasts.entity.removed)
        },
        saveTree() {
            axios.post(this.save_api, { data: this.graph })
                .then((response) => {
                    if (response.status === 204) return
                    this.graph = response.data.nodes ? { version: response.data.version, nodes: response.data.nodes, edges: response.data.edges } : this.graph
                    this.originalGraph = JSON.parse(JSON.stringify(this.graph))
                    this.isDirty = false
                    this.isEditing = false
                    window.showToast(this.texts.toasts.saved)
                })
                .catch((error) => console.error('save family tree error', error))
        },
        async loadTree() {
            const response = await axios.get(this.api)
            this.graph = {
                version: response.data.version || 2,
                nodes: response.data.nodes || [],
                edges: response.data.edges || [],
            }
            this.entities = response.data.entities || {}
            this.suggestions = response.data.suggestions || []
            this.texts = response.data.texts
            this.originalGraph = JSON.parse(JSON.stringify(this.graph))
            this.isLoading = false
        },
    },
    mounted() {
        this.loadTree().catch((error) => console.error('load family tree error', error))
    },
}
</script>
