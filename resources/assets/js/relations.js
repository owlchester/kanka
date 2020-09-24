import cytoscape from 'cytoscape';
import coseBilkent from 'cytoscape-cose-bilkent';
import panzoom from 'cytoscape-panzoom';
import dblclick from 'cytoscape-dblclick';

$(document).ready(function () {
    initCytoscape();
});

var cy, cySelector;
var entity, relation;
var elementList = [];
const DEFAULT_COLOUR = '#777777';
var addingRelation = false;

function initCytoscape() {

    // Libraries
    cytoscape.use( dblclick );
    cytoscape.use( coseBilkent );
    cytoscape.use( panzoom );
    // Selector
    cySelector = $('#cy');

    cy = cytoscape({
        container: document.getElementById('cy'), // container to render in
        wheelSensitivity: 0.5,
        style: cytoscape.stylesheet()
            .selector('node')
            .css({
                'label': 'data(name)',
                'background-image': 'data(image)',
                'height': 80,
                'width': 80,
                'background-fit': 'cover',
                'border-color': $('#cy').parent().css('color'),
                'border-width': 3,
                'color': $('#cy').css('color'),
                'text-wrap': 'wrap',
                'text-margin-y': '-8px',
                'text-background-opacity': 1,
                'text-background-color': $('#cy').css('background-color'),
                'text-border-color': $('#cy').css('background-color'),
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
                'color': $('#cy').css('color'),
                'text-background-color': $('#cy').css('background-color'),
                'text-border-color': $('#cy').css('background-color'),
                'text-border-width': 3,
                'text-border-opacity': 1
            }),
    });

    // enable pan/zoom buttons
    cy.panzoom({
        maxZoom: 2,
        minZoom: 0.3,
    });

    // enable double-click event
    cy.dblclick();

    loadMap();
}

function loadMap() {
    $.ajax({
        url: cySelector.data('url'),
        type: 'GET',
        dataType: 'json',
        success: parseMap
    });
}

function parseMap(json) {
    //console.log('result from map api', json);

    for(entity in json.entities) {
        let element = {
            group: 'nodes',
            data: {
                id: json.entities[entity].id,
                name: json.entities[entity].name,
                image: json.entities[entity].image,
                link: json.entities[entity].link,
                //tooltip: json.entities[entity].tooltip,
            }
        };
        elementList.push(element);
    }

    for (relation in json.relations) {
        let element = {
            group: 'edges',
            data: {
                source: json.relations[relation].source,
                target: json.relations[relation].target,
                name: json.relations[relation].text,
                colour: json.relations[relation].colour,
                attitude: json.relations[relation].attitude,
                shape: json.relations[relation].shape,
                edit_url: json.relations[relation].edit_url,
            }
        };
        // if the relation does not have a colour, use the default
        if (!element.data.coluor) {
            element.data.coluor = DEFAULT_COLOUR;
        }
        if (!element.data.attitude) {
            element.data.attitude = 0;
        }
        element.data.attitude = getWidthFromAttitude(element.data.attitude);
        elementList.push(element);
    }
    //console.log('elements', elementList);

    renderRelations();
}

function renderRelations() {
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
}

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
    // open on double click
    cy.nodes().on('click', function(e) {
        entity = cy.getElementById(e.target.id());
        let data = e.target.data();
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
    cy.nodes().on('mouseout', function(e) {
        entity.removeClass('node-hover');
    });

    // Double click on an edge to edit it
    cy.edges().on('click', function(e) {
        //console.log('e', e.target.data());
        let editUrl = e.target.data().edit_url;
        if (!editUrl) {
            return;
        }

        $.ajax({
            url: editUrl,
        }).done(function (data) {
            $('#entity-modal .modal-content').html(data);
            $('#entity-modal').modal();
        });
    });

    // highlight edges on hover to show relation
    cy.edges().on('mouseover', function(e) {
        relation = cy.getElementById(e.target.id());
        relation.style('label', relation._private.data.name);
        relation.style('overlay-opacity', 0.1);
    });

    // stop highlight on hover
    cy.edges().on('mouseout', function(e) {
        relation.style('label', '');
        relation.style('overlay-opacity', 0);
    });
}


function getAttitudeFromWidth(width) {
    return (((width - 2) / 2) * 100) - 100;
}

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
    $("#spinner").hide();
    cySelector.show();
}

