let cy;
let entity, relation;
let elementList = [];
const DEFAULT_COLOUR = '#777777';

const cySelector = document.getElementById('cy');

const initCytoscape = async () => {
    if(!cySelector) {
        return;
    }

    // Dynamically import cytoscape plugins
    const { default: cytoscape } = await import('cytoscape');

    const { default: coseBilkent } = await import('cytoscape-cose-bilkent');
    const { default: panzoom } = await import('cytoscape-panzoom');
    const { default: dblclick } = await import('cytoscape-dblclick');


    // Libraries
    cytoscape.use( dblclick );
    cytoscape.use( coseBilkent );
    cytoscape.use( panzoom );

    cy = cytoscape({
        container: cySelector,
        wheelSensitivity: 0.5,
        style: cytoscape.stylesheet()
            .selector('node')
            .css({
                'label': 'data(name)',
                'background-image': 'data(image)',
                'height': 80,
                'width': 80,
                'background-fit': 'cover',
                'border-color': window.getComputedStyle(cySelector.parentNode).color,
                'border-width': 3,
                'color': window.getComputedStyle(cySelector).color,
                'text-wrap': 'wrap',
                'text-margin-y': '-8px',
                'text-background-opacity': 1,
                'text-background-color': window.getComputedStyle(cySelector).backgroundColor,
                'text-border-color': window.getComputedStyle(cySelector).backgroundColor,
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
                'color': window.getComputedStyle(cySelector).color,
                'text-background-color': window.getComputedStyle(cySelector).backgroundColor,
                'text-border-color': window.getComputedStyle(cySelector).backgroundColor,
                'text-border-width': 3,
                'text-border-opacity': 1
            }),
    });

    // enable pan/zoom buttons
    cy.panzoom({
        maxZoom: 2,
        minZoom: 0.3,
    });
    cy.minZoom(0.3);
    cy.maxZoom(2);

    // enable double-click event
    cy.dblclick();

    loadMap();
};

const loadMap = () => {
    fetch(cySelector.dataset.url)
        .then((response) => response.json())
        .then((res) => {
            parseMap(res);
        });
};

const parseMap = (res) => {
    //console.log('result from map api', res);

    for(entity in res.entities) {
        let element = {
            group: 'nodes',
            data: {
                id: res.entities[entity].id,
                name: res.entities[entity].name,
                image: res.entities[entity].image,
                link: res.entities[entity].link,
                //tooltip: json.entities[entity].tooltip,
            }
        };
        elementList.push(element);
    }

    for (relation in res.relations) {
        let element = {
            group: 'edges',
            data: {
                source: res.relations[relation].source,
                target: res.relations[relation].target,
                name: res.relations[relation].text,
                colour: res.relations[relation].colour,
                attitude: res.relations[relation].attitude,
                shape: res.relations[relation].shape,
                edit_url: res.relations[relation].edit_url,
            }
        };
        // if the relation does not have a colour, use the default
        if (!element.data.colour) {
            element.data.colour = DEFAULT_COLOUR;
        }
        if (!element.data.attitude) {
            element.data.attitude = 0;
        }
        element.data.attitude = getWidthFromAttitude(element.data.attitude);
        elementList.push(element);
    }
    renderRelations();
};

const renderRelations = () => {
    // add all of the elements (nodes and edges) to the graph. Remove orphans to keep the graph clean.
    cy.add(elementList);
    cy.nodes().forEach(function(node) {
        if (node.connectedEdges().length == 0) {
            addEntityToOrphans(node);
        }
    });

    // organize and display the elements
    runLayout();

    // add user input events to the elements
    addListeners();

    // wait until images load to display graph
    displayOnLoad();
};

function addEntityToOrphans(node) {
    // hide the node, we dont want to show orphans unless asked
    node.hide();
}

function runLayout() {
    // use an automatic layout. fcose is decently fast and looks nice
    let layout = cy.elements().layout({
        name: 'cose-bilkent',
        idealEdgeLength: 130,
        nodeDimensionsIncludeLabels: true,
    });
    layout.run();
}

function addListeners() {
    // open on simple click
    cy.on('tap', 'node', function (evt) {
        let data = evt.target.data();
        if (data.link) {
            window.location = data.link;
        }
    });


    // highlight on hover
    cy.nodes().on('mouseover', function(e) {
        entity = cy.getElementById(e.target.id());
        entity.addClass('node-hover');
    });

    // stop highlight on hover
    cy.nodes().on('mouseout', function() {
        entity.removeClass('node-hover');
    });

    // Double-click on an edge to edit it
    cy.on('tap', 'edge', function (e) {
        let editUrl = e.target.data().edit_url;
        if (!editUrl) {
            return;
        }

        window.openDialog('primary-dialog', editUrl);
    });

    // highlight edges on hover to show relation
    cy.edges().on('mouseover', function(e) {
        relation = cy.getElementById(e.target.id());
        relation.style('label', relation._private.data.name);
        relation.style('overlay-opacity', 0.1);
    });

    // stop highlight on hover
    cy.edges().on('mouseout', function() {
        relation.style('label', '');
        relation.style('overlay-opacity', 0);
    });
}


/*function getAttitudeFromWidth(width) {
    return (((width - 2) / 2) * 100) - 100;
}*/

function getWidthFromAttitude(attitude) {
    return (((attitude + 100) / 100) * 2) + 2;
}

async function displayOnLoad() {
    let loading = true;
    while (loading) {
        if (cy.nodes(':backgrounding').length == 0) {
            loading = false;
        } else {
            await sleep(300);
        }
    }
    document.getElementById("spinner").classList.add('hidden');
    cySelector.classList.remove('hidden');
}

initCytoscape();
