<template>
    <div class="family-tree-prototype">
        <div class="family-tree-toolbar flex flex-wrap gap-2 mb-4 items-center">
            <button v-if="canEdit && !isEditing" class="btn2 btn-sm btn-primary" @click="isEditing = true">
                <i class="fa-regular fa-edit" aria-hidden="true"></i>
                Edit graph
            </button>
            <button v-if="canEdit && isEditing" class="btn2 btn-sm btn-primary" @click="saveGraph" :disabled="saving">
                <i class="fa-regular fa-save" aria-hidden="true"></i>
                {{ saving ? 'Saving...' : 'Save graph' }}
            </button>
            <button v-if="canEdit && isEditing" class="btn2 btn-sm" @click="resetGraph">Reset</button>
            <button v-if="canEdit && isEditing" class="btn2 btn-sm" @click="clearGraph">Clear</button>
            <button v-if="canEdit && isEditing && nodes.length === 0" class="btn2 btn-sm btn-primary" @click="startAddNode">
                <i class="fa-regular fa-user-plus" aria-hidden="true"></i>
                Add first person
            </button>
            <span class="family-tree-prototype-note text-sm text-neutral-content">
                Flat graph prototype: {{ nodes.length }} people, {{ edges.length }} relationships
            </span>
            <span v-if="selectedNode" class="text-sm text-neutral-content">
                Selected: {{ selectedNodeLabel }}
            </span>
        </div>

        <div class="family-tree-prototype-layout">
            <div ref="cyContainer" class="family-tree-canvas" aria-label="Family tree graph"></div>

            <aside v-if="isEditing" class="family-tree-editor bg-base-200 rounded-box p-4">
                <h3 class="text-lg mb-3">Graph editor</h3>
                <p v-if="!selectedNode && !selectedEdge" class="text-sm text-neutral-content mb-4">
                    <span v-if="nodes.length">Select a person or relationship to edit it.</span>
                    <span v-else>The graph is empty. Add a person to get started.</span>
                </p>
                <button v-if="!selectedNode && !selectedEdge && !nodes.length" class="btn2 btn-sm btn-primary" @click="startAddNode">
                    Add first person
                </button>

                <template v-if="selectedNode">
                    <h4 class="font-semibold mb-2">{{ selectedNodeLabel }}</h4>
                    <div class="flex flex-wrap gap-2 mb-4">
                        <button class="btn2 btn-sm" @click="startAddEdge('partner')">Add partner</button>
                        <button class="btn2 btn-sm" @click="startAddEdge('parent')">Add parent/child</button>
                        <button class="btn2 btn-sm" @click="startAddNode">Add person</button>
                    </div>
                    <button class="btn2 btn-sm btn-error mb-4" @click="removeSelectedNode">Delete person</button>
                </template>

                <template v-if="selectedEdge">
                    <h4 class="font-semibold mb-2">Relationship</h4>
                    <RelationshipFields v-model="edgeForm" />
                    <div class="flex gap-2 mt-3">
                        <button class="btn2 btn-sm btn-primary" @click="updateSelectedEdge">Update</button>
                        <button class="btn2 btn-sm btn-error" @click="removeSelectedEdge">Delete</button>
                    </div>
                </template>

                <template v-if="editorMode === 'add-node'">
                    <hr class="my-4">
                    <h4 class="font-semibold mb-2">Add person</h4>
                    <label class="block text-sm mb-2">
                        Character
                        <select
                            ref="entitySelect"
                            v-model="newNodeEntityId"
                            class="select2 w-full mt-1"
                            :data-url="search_api"
                            data-placeholder="Search for any character"
                            data-allow-clear="true"
                            data-language="en"
                        >
                            <option value="">Search for any character</option>
                        </select>
                    </label>
                    <button class="btn2 btn-sm mb-2" @click="addUnknownNode">Add unknown person</button>
                    <button class="btn2 btn-sm btn-primary" @click="addEntityNode" :disabled="!newNodeEntityId">Add selected character</button>
                </template>

                <template v-if="editorMode === 'add-edge' && selectedNode">
                    <hr class="my-4">
                    <h4 class="font-semibold mb-2">Add relationship</h4>
                    <RelationshipFields v-model="edgeForm" />
                    <label class="block text-sm mb-2">
                        Connect to
                        <select v-model="targetNodeId" class="w-full mt-1">
                            <option value="">Choose a person</option>
                            <option v-for="node in availableTargets" :key="node.id" :value="node.id">
                                {{ nodeLabel(node) }}
                            </option>
                        </select>
                    </label>
                    <button class="btn2 btn-sm btn-primary mt-2" @click="addEdge" :disabled="!targetNodeId">Connect people</button>
                </template>
            </aside>
        </div>
    </div>
</template>

<style>
@import 'cytoscape-panzoom/cytoscape.js-panzoom.css';
</style>

<script setup>
import axios from 'axios'
import { computed, nextTick, onBeforeUnmount, onMounted, ref, watch } from 'vue'
import RelationshipFields from './FamilyTreeRelationshipFields.vue'

const props = defineProps({
    api: String,
    save_api: String,
    entity_api: String,
    search_api: String,
    permission: [String, Boolean],
})

const cyContainer = ref(null)
const cy = ref(null)
const nodes = ref([])
const edges = ref([])
const entities = ref({})
const suggestions = ref([])
const texts = ref({})
const originalGraph = ref({ nodes: [], edges: [] })
const isEditing = ref(false)
const saving = ref(false)
const selectedNode = ref(null)
const selectedEdge = ref(null)
const editorMode = ref(null)
const entitySelect = ref(null)
const targetNodeId = ref('')
const newNodeEntityId = ref('')
const edgeForm = ref({ type: 'partner', role: '', parentage: '' })

const canEdit = computed(() => props.permission === true || props.permission === '1')
const selectedNodeLabel = computed(() => selectedNode.value ? nodeLabel(selectedNode.value) : '')
const availableTargets = computed(() => nodes.value.filter(node => node.id !== selectedNode.value?.id))

const nodeLabel = (node) => {
    if (node.isUnknown || !node.entity_id) {
        return node.role || 'Unknown person'
    }

    return entities.value[node.entity_id]?.name || `Character #${node.entity_id}`
}

const makeId = () => window.crypto?.randomUUID?.() || `prototype-${Date.now()}-${Math.random().toString(16).slice(2)}`

const graph = () => ({ nodes: nodes.value, edges: edges.value })

const applyData = (data, remember = false) => {
    nodes.value = Array.isArray(data.nodes) ? data.nodes : []
    edges.value = Array.isArray(data.edges) ? data.edges : []
    entities.value = data.entities || {}
    suggestions.value = data.suggestions || []
    texts.value = data.texts || {}

    if (remember) {
        originalGraph.value = JSON.parse(JSON.stringify(graph()))
    }
}

const buildElements = () => [
    ...nodes.value.map(node => {
        const entity = node.entity_id ? entities.value[node.entity_id] : null

        return {
            group: 'nodes',
            data: {
                id: node.id,
                label: nodeLabel(node),
                image: node.isUnknown ? '' : entity?.thumb || '',
                colour: node.colour || '#64748b',
            },
            classes: `${node.isUnknown ? 'unknown' : ''} ${node.cssClass || ''}`,
        }
    }),
    ...edges.value.map(edge => ({
        group: 'edges',
        data: {
            id: edge.id,
            source: edge.source,
            target: edge.target,
            type: edge.type,
            role: edge.role || edge.parentage || '',
            colour: edge.colour || '#64748b',
        },
        classes: edge.type,
    })),
]

const runLayout = () => {
    if (!cy.value) return

    cy.value.elements().layout({
        name: 'dagre',
        rankDir: 'TB',
        nodeSep: 70,
        rankSep: 110,
        edgeSep: 30,
        fit: true,
        padding: 45,
        animate: false,
        // Dagre requires a positive rank length for every edge. A zero-length
        // partner edge can produce a route without control points.
        minLen: 1,
        edgeWeight: 1,
    }).run()
}

const renderGraph = () => {
    if (!cy.value) return

    cy.value.elements().remove()
    cy.value.add(buildElements())
    runLayout()
}

const selectNode = (node) => {
    selectedNode.value = nodes.value.find(item => item.id === node.id()) || null
    selectedEdge.value = null
    editorMode.value = null
}

const selectEdge = (edge) => {
    selectedEdge.value = edges.value.find(item => item.id === edge.id()) || null
    selectedNode.value = null
    editorMode.value = null
    if (selectedEdge.value) {
        edgeForm.value = {
            type: selectedEdge.value.type,
            role: selectedEdge.value.role || '',
            parentage: selectedEdge.value.parentage || '',
        }
    }
}

const startAddEdge = (type) => {
    edgeForm.value = { type, role: '', parentage: '' }
    targetNodeId.value = ''
    editorMode.value = 'add-edge'
    selectedEdge.value = null
}

const startAddNode = () => {
    newNodeEntityId.value = ''
    editorMode.value = 'add-node'
}

watch(editorMode, async mode => {
    if (mode !== 'add-node') {
        return
    }

    await nextTick()
    window.initForeignSelect?.()
})

const addNode = (entityId = null) => {
    const node = {
        id: makeId(),
        entity_id: entityId ? Number(entityId) : null,
        isUnknown: !entityId,
        role: '',
        colour: '',
        cssClass: '',
        visibility: 1,
    }
    nodes.value.push(node)
    selectedNode.value = node
    editorMode.value = null
    renderGraph()
}

const addUnknownNode = () => addNode()

const addEntityNode = async () => {
    if (!newNodeEntityId.value) return

    const response = await axios.get(props.entity_api.replace('/0', `/${newNodeEntityId.value}`))
    entities.value[response.data.id] = response.data
    addNode(response.data.id)
}

const addEdge = () => {
    if (!selectedNode.value || !targetNodeId.value) return

    edges.value.push({
        id: makeId(),
        source: selectedNode.value.id,
        target: targetNodeId.value,
        type: edgeForm.value.type,
        role: edgeForm.value.role,
        parentage: edgeForm.value.type === 'parent' ? edgeForm.value.parentage : '',
        colour: '',
        cssClass: '',
        visibility: 1,
    })
    editorMode.value = null
    targetNodeId.value = ''
    renderGraph()
}

const updateSelectedEdge = () => {
    if (!selectedEdge.value) return

    selectedEdge.value.type = edgeForm.value.type
    selectedEdge.value.role = edgeForm.value.role
    selectedEdge.value.parentage = edgeForm.value.type === 'parent' ? edgeForm.value.parentage : ''
    renderGraph()
}

const removeSelectedEdge = () => {
    if (!selectedEdge.value || !window.confirm('Delete this relationship?')) return

    edges.value = edges.value.filter(edge => edge.id !== selectedEdge.value.id)
    selectedEdge.value = null
    renderGraph()
}

const removeSelectedNode = () => {
    if (!selectedNode.value || !window.confirm('Delete this person and their relationships?')) return

    const id = selectedNode.value.id
    nodes.value = nodes.value.filter(node => node.id !== id)
    edges.value = edges.value.filter(edge => edge.source !== id && edge.target !== id)
    selectedNode.value = null
    renderGraph()
}

const saveGraph = async () => {
    saving.value = true
    try {
        const response = await axios.post(props.save_api, { data: graph() })
        if (response.status === 204) {
            window.openDialog?.('family-tree-pitch')
            return
        }

        applyData(response.data, true)
        renderGraph()
        window.showToast?.(texts.value.toasts?.saved || 'Family graph saved')
        isEditing.value = false
    } finally {
        saving.value = false
    }
}

const resetGraph = () => {
    if (!window.confirm('Reset unsaved changes?')) return

    applyData(JSON.parse(JSON.stringify(originalGraph.value)))
    selectedNode.value = null
    selectedEdge.value = null
    editorMode.value = null
    renderGraph()
}

const clearGraph = () => {
    if (!window.confirm('Clear the family graph?')) return

    nodes.value = []
    edges.value = []
    selectedNode.value = null
    selectedEdge.value = null
    editorMode.value = null
    renderGraph()
}

const initCytoscape = async () => {
    const { default: cytoscape } = await import('cytoscape')
    const { default: dagre } = await import('cytoscape-dagre')
    const { default: panzoom } = await import('cytoscape-panzoom')

    cytoscape.use(dagre)
    cytoscape.use(panzoom)
    cy.value = cytoscape({
        container: cyContainer.value,
        style: [
            { selector: 'node', style: { label: 'data(label)', width: 72, height: 72, shape: 'ellipse', 'background-color': 'data(colour)', 'background-image': 'data(image)', 'background-fit': 'cover', 'border-width': 3, 'border-color': '#ffffff', color: '#111827', 'font-size': 12, 'text-wrap': 'wrap', 'text-max-width': 140, 'text-margin-y': 12, 'text-background-opacity': 0.9, 'text-background-color': '#ffffff', 'text-background-padding': 3 } },
            { selector: 'node.unknown', style: { label: '?', 'font-size': 28, 'text-margin-y': 0, 'background-image': 'none' } },
            { selector: 'edge', style: { width: 2, 'line-color': 'data(colour)', 'target-arrow-color': 'data(colour)', 'curve-style': 'bezier', label: 'data(role)', color: '#374151', 'font-size': 11, 'text-background-opacity': 0.9, 'text-background-color': '#ffffff', 'text-background-padding': 2 } },
            { selector: 'edge.parent', style: { 'target-arrow-shape': 'triangle' } },
            { selector: 'edge.partner', style: { 'line-style': 'dashed', 'target-arrow-shape': 'none' } },
            { selector: ':selected', style: { 'overlay-color': '#f59e0b', 'overlay-opacity': 0.2, 'overlay-padding': 8 } },
        ],
    })
    cy.value.panzoom({ minZoom: 0.1, maxZoom: 2 })
    cy.value.on('tap', 'node', event => selectNode(event.target))
    cy.value.on('tap', 'edge', event => selectEdge(event.target))
}

onMounted(async () => {
    await initCytoscape()
    const response = await axios.get(props.api)
    applyData(response.data, true)
    renderGraph()
})

onBeforeUnmount(() => {
    cy.value?.destroy()
    cy.value = null
})
</script>
