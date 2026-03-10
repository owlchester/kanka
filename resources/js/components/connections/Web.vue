<template>
    <!-- Back button (top-left floating) -->


    <!-- Bottom toolbar -->
    <div v-if="ready" class="fixed bottom-4 left-1/2 -translate-x-1/2 z-700 flex items-center gap-1.5 bg-base-100/80 backdrop-blur rounded-xl shadow-lg px-2 py-1.5">
        <a v-if="ready" :href="urls.back" :title="trans('back')" class="btn2 btn-ghost" tabindex="0">
            <i class="fa-regular fa-home" aria-hidden="true"></i>
        </a>

        <!-- Zone 1: Plus FAB -->
        <div v-if="props.creator" class="relative">
            <button @click.prevent="fabDropdown = !fabDropdown" class="btn2 btn-primary" :title="trans('create')">
                <i class="fa-regular fa-plus" aria-hidden="true"></i>
            </button>
            <div
                v-if="fabDropdown"
                v-click-outside="() => fabDropdown = false"
                class="absolute bottom-full mb-2 left-0 flex flex-col gap-1 bg-base-100 shadow-lg p-2 rounded-lg z-10 min-w-max"
                role="menu"
            >
                <a href="#" @click.prevent="fabDropdown = false; openQQ()" class="flex items-center gap-2 px-3 py-1.5 rounded hover:bg-base-200 cursor-pointer whitespace-nowrap">
                    <i class="fa-regular fa-bolt w-5" aria-hidden="true"></i>
                    <span v-html="trans('create')"></span>
                </a>
                <a href="#" @click.prevent="fabDropdown = false; openCreate()" class="flex items-center gap-2 px-3 py-1.5 rounded hover:bg-base-200 cursor-pointer whitespace-nowrap">
                    <i class="fa-regular fa-link w-5" aria-hidden="true"></i>
                    <span v-html="trans('add')"></span>
                </a>
            </div>
        </div>

        <!-- Zone 2: View controls -->
        <button @click.prevent="zoomToFit()" class="btn2 btn-ghost rounded-lg" :title="trans('zoom-fit')">
            <i class="fa-regular fa-arrows-maximize" aria-hidden="true"></i>
        </button>
        <button @click.prevent="resetLayout()" class="btn2 btn-ghost" :title="trans('reset-layout')">
            <i class="fa-regular fa-grid-round" aria-hidden="true"></i>
        </button>

        <div class="w-px h-6 bg-base-content/20"></div>

        <!-- Zone 3: Export -->
        <div class="relative">
            <button @click.prevent="downloadDropdown = !downloadDropdown" class="btn2 btn-ghost" :title="trans('download')">
                <i class="fa-regular fa-download" aria-hidden="true"></i>
            </button>
            <div
                v-if="downloadDropdown"
                v-click-outside="() => downloadDropdown = false"
                class="absolute bottom-full mb-2 right-0 flex flex-col gap-1 bg-base-100 shadow-lg p-2 rounded-2xl z-10 min-w-max"
                role="menu"
            >
                <a @click.prevent="downloadPng()" class="flex items-center gap-2 px-3 py-1.5 rounded-xl hover:bg-base-200 cursor-pointer whitespace-nowrap">
                    <i class="fa-regular fa-image w-5" aria-hidden="true"></i>
                    <span v-html="trans('download-png')"></span>
                </a>
                <a @click.prevent="downloadPdf()" class="flex items-center gap-2 px-3 py-1.5 rounded-xl hover:bg-base-200 cursor-pointer whitespace-nowrap">
                    <i class="fa-regular fa-file-pdf w-5" aria-hidden="true"></i>
                    <span v-html="trans('download-pdf')"></span>
                </a>
            </div>
        </div>
    </div>

    <div v-if="!ready" class="w-full h-screen flex items-center justify-center text-4xl gap-2 absolute bg-base-100 transition-all duration-300 top-0 bottom-0 left-0 right-0 z-900">
        <i class="fa-solid fa-spinner fa-spin" aria-hidden="true"></i>
        <span v-if="loading">Loading</span>
        <span v-else-if="parsing">Parsing web</span>
        <span v-else-if="drawing">Drawing web</span>
    </div>
    <div ref="cyContainer" class="min-h-screen text-base-content cy-map bg-base-100">
    </div>

</template>
<style>
@import 'cytoscape-panzoom/cytoscape.js-panzoom.css';
.cy-panzoom {
    z-index: 800;
    left: unset;
    right: 3.7rem;
    top: 0.7rem;
}
</style>

<script setup lang="ts">

import { ref, onMounted, onBeforeUnmount} from 'vue';
import tippy, { Instance, ReferenceElement } from 'tippy.js'
import { cssVariable } from '../../utility/colours';


const props = defineProps<{
    api: String,
    premium: Boolean,
    creator: Boolean,
}>()

const ready = ref(false)
const loading = ref(false)
const parsing = ref(false)
const drawing = ref(false)
const elements = ref([])
const cy = ref(null)
const currentEntity = ref(null)
const relation = ref(null)
const cyContainer = ref()
const entityTooltips = ref(Array)
let nodeTippy: Instance | null = null
const downloadDropdown = ref(false)
const fabDropdown = ref(false)
const i18n = ref(null)
const urls = ref(null)

onMounted(async () => {
    await initCytoscape()
    await loadData()
    await addToCy()
    ready.value = true

    // Attach listener for *capturing* submit events
    document.addEventListener('submit', handleDialogFormSubmit, true)

    window.initTooltips();

    if (!props.premium) {
        window.openDialog('web-premium')
    }
})

onBeforeUnmount(() => {
    if (cy.value) {
        cy.value.destroy();
        cy.value = null;
    }

    document.removeEventListener('submit', handleDialogFormSubmit, true)
})

const parseData = (data) => {
    parsing.value = true

    Object.values(data.entities).forEach((entity: any) => {
        addEntity(entity)
    });
    data.nodes.forEach((node: any) => {
        addNode(node)
    })
    i18n.value = data.i18n
    urls.value = data.urls

    parsing.value = false
}

const addEntity = (entity) => {
    // Already loaded entity
    if (elements.value.find(e => e.data.id == entity.id)) {
        return;
    }

    const element = {
        group: 'nodes',
        data: {
            id: entity.id,
            name: entity.name,
            image: entity.image,
            link: entity.link,
            tooltip: entity.tooltip,
        }
    };
    elements.value.push(element);

    if (ready.value && cy.value) {
        cy.value.add(element);
    }
}

const addNode = (node) => {
    let element = {
        group: 'edges',
        data: {
            id: node.id,
            source: node.source,
            target: node.target,
            name: node.text,
            colour: node.colour,
            attitude: node.attitude,
            shape: node.shape,
            url: node.url,
        }
    };
    // if the relation does not have a colour, use the default
    if (!element.data.colour) {
        element.data.colour = '#777777';
    }
    if (!element.data.attitude) {
        element.data.attitude = 0;
    }
    element.data.attitude = getWidthFromAttitude(element.data.attitude);
    elements.value.push(element);
}


const getWidthFromAttitude = (attitude: any) => {
    return (((attitude + 100) / 100) * 2) + 2;
}

const initCytoscape = async () => {

    const { default: cytoscape } = await import('cytoscape')
    const { default: coseBilkent } = await import('cytoscape-cose-bilkent')
    const { default: panzoom } = await import('cytoscape-panzoom')


    // Libraries
    cytoscape.use( coseBilkent )
    cytoscape.use( panzoom )

    const container = cyContainer.value
    const parent = container.parentNode as HTMLElement
    const containerStyles = window.getComputedStyle(container)
    const parentStyles = window.getComputedStyle(parent)

    cy.value = cytoscape({
        container: cyContainer.value,
        style: cytoscape.stylesheet()
            .selector('node')
            .css({
                'label': 'data(name)',
                'background-image': 'data(image)',
                'height': 80,
                'width': 80,
                'background-fit': 'cover',
                'border-color': parentStyles.color,
                'border-width': 3,
                'color': containerStyles.color,
                'text-wrap': 'wrap',
                'text-margin-y': '-8px',
                'text-background-opacity': 1,
                'text-background-color': containerStyles.backgroundColor,
                'text-border-color': containerStyles.backgroundColor,
                'text-border-width': 3,
                'text-border-opacity': 1
            })
            .selector('edge')
            .css({
                'line-color': 'data(colour)',
                'curve-style': 'bezier',
                'control-point-step-size': 40,
                'target-arrow-shape': 'data(shape)',
                'target-arrow-color': 'data(colour)',
                'width': 'data(attitude)',
                'text-background-opacity': 1,
                'color': containerStyles.color,
                'text-background-color': containerStyles.backgroundColor,
                'text-border-color': containerStyles.backgroundColor,
                'text-border-width': 3,
                'text-border-opacity': 1
            }),
    });

    // enable pan/zoom buttons
    const minZoom = 0.1
    const maxZoom = 1.2
    cy.value.panzoom({
        maxZoom: maxZoom,
        minZoom: minZoom,
    });
    cy.value.minZoom(minZoom);
    cy.value.maxZoom(maxZoom);
}

const loadData = async () => {
    loading.value = true
    const res = await axios.get(props.api)
    loading.value = false;

    const data = res.data;
    parseData(data);

}
const addToCy = async () => {
    if (!cy.value) return

    drawing.value = true;
    drawing.value = true;

    // add all of the elements (nodes and edges) to the graph. Remove orphans to keep the graph clean.
    cy.value.add(elements.value);
    cy.value.nodes().forEach(function(node) {
        if (node.connectedEdges().length == 0) {
            addEntityToOrphans(node);
        }
    });

    // organize and display the elements
    runLayout();

    // add user input events to the elements
    addListeners();

    // wait until images load to display graph
    await finishDrawing();
}

const addEntityToOrphans = (node: any) => {
    node.hide();
}

const runLayout = () => {
    // use an automatic layout. fcose is decently fast and looks nice
    const layout = cy.value.elements().layout({
        name: 'cose-bilkent',
        idealEdgeLength: 130,
        nodeDimensionsIncludeLabels: true,
    });
    layout.run();
}

const addListeners = () => {
    cy.value.on('tap', 'node', function (evt) {
        const node = evt.target
        showNodeTooltip(node)
    });

    cy.value.nodes().on('mouseover', function(e) {
        currentEntity.value = cy.value.getElementById(e.target.id());
        currentEntity.value.addClass('node-hover');
    });

    cy.value.nodes().on('mouseout', function() {
        if (!currentEntity.value) return;
        currentEntity.value.removeClass('node-hover');
        currentEntity.value = null;
    });

    // Double-click on an edge to edit it
    cy.value.on('tap', 'edge', function (e) {
        let editUrl = e.target.data().url;
        if (!editUrl) {
            return;
        }

        window.openDialog('primary-dialog', editUrl);
    });

    cy.value.edges().on('mouseover', function(e) {
        relation.value = cy.value.getElementById(e.target.id());
        relation.value.style('label', relation.value._private.data.name);
        relation.value.style('overlay-opacity', 0.1);
    });

    cy.value.edges().on('mouseout', function() {
        if (!relation.value) return;
        relation.value.style('label', '');
        relation.value.style('overlay-opacity', 0);
        relation.value = null;
    });
}

const finishDrawing = async () => {
    let backgrounding = true;
    while (backgrounding) {
        if (cy.value.nodes(':backgrounding').length == 0) {
            backgrounding = false;
        } else {
            await sleep(200);
        }
    }

    drawing.value = false;
}

const showNodeTooltip = (node: any) => {
    const cyInstance = cy.value;
    if (!cyInstance) return;

    const container = cyInstance.container();
    if (!container) return;

    // Position of the node in rendered pixel coordinates
    const pos = node.renderedPosition();
    const rect = container.getBoundingClientRect();

    // Function returning the virtual rect for this tooltip
    const getReferenceClientRect = () => {
        const x = rect.left + pos.x;
        const y = rect.top + pos.y;

        return {
            x,
            y,
            left: x,
            top: y,
            right: x,
            bottom: y,
            width: 0,
            height: 0,
        } as DOMRect;
    };

    // Kill any previous tooltip
    if (nodeTippy) {
        nodeTippy.destroy();
        nodeTippy = null;
    }

    nodeTippy = tippy(document.body, {
        trigger: 'manual',
        // This is the key bit for virtual positioning in Tippy v6+
        getReferenceClientRect,

        theme: 'entity-tooltip',
        placement: 'bottom',
        hideOnClick: true,
        allowHTML: true,
        interactive: true,
        content: 'Loading...',
        appendTo: () => document.body, // keep it simple & safe
        onShow(instance) {
            const id = String(node.id());
            if (id in entityTooltips.value) {
                instance.setContent(entityTooltips.value[id]);
                return;
            }
            axios.get(node.data().tooltip)
                .then((res) => {
                    const html = res.data;
                    instance.setContent(html);
                    entityTooltips.value[id] = html;
                })
                .catch((error) => {
                        instance.setContent(`Failed loading tooltip. ${error}`);
                    }
                );
        },
    });

    nodeTippy.show();
};

const handleDialogFormSubmit = async (event: SubmitEvent) => {
    const form = event.target as HTMLFormElement | null
    if (!form) return

    event.preventDefault()

    try {
        const method = (form.method || 'POST').toUpperCase()
        const url = form.action
        const formData = new FormData(form)

        const response = await axios({
            url,
            method,
            data: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
            },
        })

        if (response.data.created) {
            handleRelationCreate(response.data)
        } else {
            handleRelationUpdate(response.data)
        }

        if (window.closeDialog) {
            window.closeDialog('primary-dialog')
        }
    } catch (error) {
        if (error.response && error.response.status === 422 && error.response.data?.errors) {
            showDialogErrors(form, error.response.data.errors)
        } else {
            console.error(error)
        }
    }
}

const showDialogErrors = (form: HTMLFormElement, errors: Record<string, string[]>) => {
    const article = form.closest('article')
    if (!article) return

    // Remove any previous error alert
    article.querySelector('.alert.alert-error.js-web-errors')?.remove()

    const messages = Object.values(errors).flat()
    const alert = document.createElement('div')
    alert.className = 'alert alert-error border-0 rounded-lg p-4 flex shadow-xs gap-2 items-center js-web-errors'
    const list = document.createElement('ul')
    messages.forEach((msg) => {
        const li = document.createElement('li')
        li.textContent = msg
        list.appendChild(li)
    })
    alert.appendChild(list)
    article.prepend(alert)
}

const handleRelationUpdate = async (data) => {
    if (!cy.value || !data || !data.id) return


    // however you address edges; for example by some id
    const edge = cy.value.edges().filter(`[id = "${data.id}"]`)

    if (!edge || edge.length === 0) {
        console.warn('Updated unknown edge', data.id);
        return
    }

    if (data.deleted) {
        edge.remove();
    }

    // Reuse your existing logic for width
    const width = getWidthFromAttitude(data.attitude ?? 0)

    // Cytoscape edges are immutable (source/target), so if the target changes, we need to re-create the edge
    if (edge.data().target != data.target.id) {
        // Maybe import the new entity
        addEntity(data.target);
        await finishDrawing();

        const newEdge = {
            group: 'edges',
            data: {
                ...edge.data(),
                name: data.text,
                target: data.target.id,
                colour: data.colour || '#777777',
                attitude: width,
            }
        };
        edge.remove();
        cy.value.add(newEdge);
    } else {
        edge.data({
            ...edge.data(),
            name: data.text,
            colour: data.colour || '#777777',
            attitude: width,
        })
    }
}

const handleRelationCreate = async (data) => {
    if (!cy.value || !data) return

    // Add both source and target entities (they may already exist)
    addEntity(data.target);
    if (data.source) {
        const sourceNode = cy.value.getElementById(data.source);
        if (sourceNode.length === 0) {
            // Source entity not in graph yet, reload to get it
            await reloadData();
            return;
        }
    }
    await finishDrawing();

    const width = getWidthFromAttitude(data.attitude ?? 0)
    const edge = {
        group: 'edges',
        data: {
            id: data.id,
            source: data.source,
            target: data.target.id,
            name: data.text,
            colour: data.colour || '#777777',
            attitude: width,
            shape: data.shape || 'triangle',
            url: data.url,
        }
    };
    cy.value.add(edge);

    // Show the target node if it was hidden as an orphan
    const targetNode = cy.value.getElementById(data.target.id);
    if (targetNode.length > 0 && targetNode.hidden()) {
        targetNode.show();
    }

    runLayout();
}

const reloadData = async () => {
    elements.value = [];
    await loadData();
    cy.value.elements().remove();
    cy.value.add(elements.value);
    cy.value.nodes().forEach(function(node) {
        if (node.connectedEdges().length == 0) {
            addEntityToOrphans(node);
        }
    });
    runLayout();
    addListeners();
    await finishDrawing();
}

const openCreate = () => {
    window.openDialog("primary-dialog", urls.value.create)
}

const openQQ = () => {
    window.openDialog("primary-dialog", urls.value.creator)
}

const zoomToFit = () => {
    if (!cy.value) return
    cy.value.fit(undefined, 30)
}

const resetLayout = () => {
    if (!cy.value) return
    runLayout()
}

const trans = (key: string) => {
    return i18n.value[key] || key
}

const downloadPng = () => {
    downloadDropdown.value = false
    if (!cy.value) {
        return
    }
    const options = {
        full: true,
        bg: cssVariable('--b1'),
    };
    const base64 = cy.value.png(options);

    const link = document.createElement('a');
    link.href = base64;
    link.download = `${trans('campaign')}-web-${Date.now()}.png`;
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

const downloadPdf = async () => {
    downloadDropdown.value = false
    if (!cy.value) {
        return
    }

    const { jsPDF } = await import('jspdf')

    const base64 = cy.value.png({
        full: true,
        bg: cssVariable('--b1'),
    });

    const img = new Image();
    img.src = base64;
    await new Promise((resolve) => { img.onload = resolve; });

    const landscape = img.width > img.height;
    const doc = new jsPDF({
        orientation: landscape ? 'landscape' : 'portrait',
        unit: 'px',
        format: [img.width, img.height],
    });

    doc.addImage(base64, 'PNG', 0, 0, img.width, img.height);
    doc.save(`${trans('campaign')}-web-${Date.now()}.pdf`);
}

</script>
