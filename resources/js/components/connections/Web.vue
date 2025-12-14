<template>
    <div class="toolbar fixed w-full p-2 flex items-center justify-between gap-2 z-700" v-if="ready">
        <div class="flex gap-4 items-center">
            <a :href="urls.back" :title="trans('back')" class="flex items-center gap-1 text-link rounded bg-base-100 p-1" tabindex="0">
                <i class="fa-regular fa-left-to-bracket" aria-hidden="true"></i>
                <span v-html="trans('back')"></span>
            </a>

            <div v-if="props.creator" class="relative">
                <a v-if="props.creator" href="#" @click="openQQ()"  class="quick-creator-button btn2 btn-primary btn-sm" tabindex="0">
                    <i class="flex-none fa-regular fa-plus" aria-hidden="true"></i>
                    <span class="grow hidden sm:inline-block" v-html="trans('create')"></span>
                    <span class="flex-none keyboard-shortcut" id="qq-kb-shortcut" data-toggle="tooltip" :data-title="trans('qq-keyboard-shortcut')" data-html="true" data-placement="bottom" >N</span>
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
const i18n = ref(null)
const urls = ref(null)

onMounted(async () => {
    await initCytoscape()
    await loadData()
    await addToCy()
    ready.value = true

    // Attach listener for *capturing* submit events
    document.addEventListener('submit', handleDialogFormSubmit, true)


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

        // Handle success (see next section)
        handleRelationUpdate(response.data)

        // Close the dialog (use whatever your project exposes)
        if (window.closeDialog) {
            window.closeDialog('primary-dialog')
        }
    } catch (error) {
        // You can show errors inside the dialog instead of redirect
        console.error(error)
    }
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

const openQQ = () => {
    window.openDialog("primary-dialog", urls.value.creator)
}

const trans = (key: string) => {
    return i18n.value[key] || key
}
</script>
