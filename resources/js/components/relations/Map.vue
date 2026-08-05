<template>
    <div class="flex flex-col gap-2">
        <div class="flex flex-wrap gap-1.5">
            <button
                v-for="(label, value) in labels"
                :key="value"
                type="button"
                @click="selectOption(value)"
                class="px-3 py-1.5 rounded-full text-sm border transition-all cursor-pointer"
                :class="currentOption === value
                    ? 'bg-primary text-primary-content border-primary font-semibold'
                    : 'bg-base-200 border-base-300 text-base-content hover:border-primary'"
            >{{ label }}</button>
        </div>

        <div
            ref="box"
            class="relative rounded-lg p-4 shadow-xs bg-box w-full transition-all duration-150 box-entity-relations box-entity-relations-explorer"
            :class="embedded ? 'h-80' : 'min-h-80'"
        >
            <div v-show="loading" class="absolute inset-0 flex items-center justify-center text-xg bg-box z-10">
                <i class="fa-solid fa-spinner fa-spin" aria-hidden="true"></i>
            </div>
            <div v-show="empty" class="absolute inset-0 flex items-center justify-center text-base-content z-10">
                <span>{{ emptyLabel }}</span>
            </div>
            <div
                ref="container"
                class="cy text-base-content bg-box h-full w-full"
                :class="embedded ? 'cy-post' : 'cy-map'"
            ></div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, onMounted, onBeforeUnmount } from 'vue'

const props = defineProps<{
    url: string
    option: string
    labels: Record<string, string>
    pageUrl: string
    embedded: boolean
    emptyLabel: string
}>()

const DEFAULT_COLOUR = '#777777'

const currentOption = ref(props.option ?? '')
const loading = ref(true)
const empty = ref(false)
const container = ref<HTMLElement | null>(null)
const box = ref<HTMLElement | null>(null)

let cy: any = null
let requestId = 0
let entity: any = null
let relation: any = null

onMounted(() => {
    resizeMap()
    window.addEventListener('resize', resizeMap)
    if (document.fonts?.ready) {
        document.fonts.ready.then(resizeMap)
    }
    initCytoscape()
})

onBeforeUnmount(() => {
    window.removeEventListener('resize', resizeMap)
    if (cy) {
        cy.destroy()
        cy = null
    }
})

const mapUrl = (option: string) => {
    const url = new URL(props.url, window.location.origin)
    if (option) {
        url.searchParams.set('option', option)
    } else {
        url.searchParams.delete('option')
    }

    return url.toString()
}

const selectOption = (value: string) => {
    if (currentOption.value === value) {
        return
    }
    currentOption.value = value

    if (props.pageUrl) {
        const url = new URL(props.pageUrl, window.location.origin)
        if (value) {
            url.searchParams.set('option', value)
        } else {
            url.searchParams.delete('option')
        }
        window.history.replaceState({}, '', url.toString())
    }

    loadMap()
}

// Fill the remaining viewport height below the page header on large screens.
const resizeMap = () => {
    if (props.embedded || !box.value) {
        return
    }
    const top = box.value.getBoundingClientRect().top
    const height = window.innerHeight - top
    box.value.style.height = Math.max(height, 220) + 'px'
}

const initCytoscape = async () => {
    const el = container.value
    if (!el) return

    // Dynamically import cytoscape plugins
    const { default: cytoscape } = await import('cytoscape')
    const { default: coseBilkent } = await import('cytoscape-cose-bilkent')
    const { default: panzoom } = await import('cytoscape-panzoom')
    const { default: dblclick } = await import('cytoscape-dblclick')

    // Libraries
    cytoscape.use(dblclick)
    cytoscape.use(coseBilkent)
    cytoscape.use(panzoom)

    const containerStyles = window.getComputedStyle(el)
    const parentStyles = window.getComputedStyle(el.parentNode as HTMLElement)

    cy = cytoscape({
        container: el,
        wheelSensitivity: 0.5,
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
                'text-border-opacity': 1,
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
                'text-border-opacity': 1,
            }),
    })

    // enable pan/zoom buttons
    cy.panzoom({
        maxZoom: 2,
        minZoom: 0.3,
    })
    cy.minZoom(0.3)
    cy.maxZoom(2)

    // enable double-click event
    cy.dblclick()

    // Delegated handlers, bound once per graph instance
    cy.on('tap', 'node', function (evt) {
        const link = evt.target.data().link
        if (link) {
            window.location = link
        }
    })

    cy.on('tap', 'edge', function (e) {
        const editUrl = e.target.data().edit_url
        if (!editUrl) {
            return
        }

        window.openDialog('primary-dialog', editUrl)
    })

    await loadMap()
}

const loadMap = async () => {
    const id = ++requestId
    loading.value = true
    empty.value = false

    let data
    try {
        const response = await fetch(mapUrl(currentOption.value))
        data = await response.json()
    } catch (error) {
        if (id === requestId) {
            loading.value = false
            console.error(error)
        }

        return
    }

    // Ignore stale responses from an earlier selection
    if (id !== requestId) {
        return
    }

    await renderRelations(data)

    if (id === requestId) {
        empty.value = cy.elements(':visible').length === 0
        loading.value = false
    }
}

const renderRelations = async (data: any) => {
    const elements: any[] = []

    Object.values(data.entities).forEach((entry: any) => {
        elements.push({
            group: 'nodes',
            data: {
                id: entry.id,
                name: entry.name,
                image: entry.image,
                link: entry.link,
            },
        })
    })

    data.relations.forEach((relationData: any) => {
        const element = {
            group: 'edges',
            data: {
                source: relationData.source,
                target: relationData.target,
                name: relationData.text,
                colour: relationData.colour || DEFAULT_COLOUR,
                attitude: relationData.attitude ? getWidthFromAttitude(relationData.attitude) : getWidthFromAttitude(0),
                shape: relationData.shape,
                edit_url: relationData.edit_url,
            },
        }
        elements.push(element)
    })

    cy.elements().remove()
    cy.add(elements)
    cy.nodes().forEach(function (node) {
        if (node.connectedEdges().length == 0) {
            node.hide()
        }
    })

    // organize and display the elements
    runLayout()

    // add user input events to the elements
    addHoverListeners()

    // wait until images load to display graph
    await displayOnLoad()
}

const addHoverListeners = () => {
    // highlight on hover
    cy.nodes().on('mouseover', function (e) {
        entity = cy.getElementById(e.target.id())
        entity.addClass('node-hover')
    })

    // stop highlight on hover
    cy.nodes().on('mouseout', function () {
        entity.removeClass('node-hover')
    })

    // highlight edges on hover to show relation
    cy.edges().on('mouseover', function (e) {
        relation = cy.getElementById(e.target.id())
        relation.style('label', relation._private.data.name)
        relation.style('overlay-opacity', 0.1)
    })

    // stop highlight on hover
    cy.edges().on('mouseout', function () {
        relation.style('label', '')
        relation.style('overlay-opacity', 0)
    })
}

const runLayout = () => {
    cy.elements().layout({
        name: 'cose-bilkent',
        idealEdgeLength: 130,
        nodeDimensionsIncludeLabels: true,
    }).run()
}

function getWidthFromAttitude(attitude: number) {
    return (((attitude + 100) / 100) * 2) + 2
}

const displayOnLoad = async () => {
    while (cy.nodes(':backgrounding').length > 0) {
        await sleep(300)
    }
}

const sleep = (ms: number) => new Promise((resolve) => setTimeout(resolve, ms))
</script>
