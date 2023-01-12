import { Application, Assets, Sprite, Text, TextStyle, Graphics } from 'pixi.js';
import axios from 'axios';


// The application will create a renderer using WebGL, if possible,
// with a fallback to a canvas render. It will also setup the ticker
// and the root stage PIXI.Container
const app = new Application({ backgroundAlpha: 0});

// The application will create a canvas element for you that you
// can then insert into the DOM
const container = document.getElementsByClassName('family-tree-setup')[0];
container.appendChild(app.view);

// load the texture we need
const texture = await Assets.load('/images/family-trees/entity.png');

const graphics = new Graphics();

const entityNameStyle = new TextStyle({
    fontFamily: 'Arial',
    fontSize: 18,
    fontStyle: 'italic',
    fontWeight: 'bold',
    fill: ['#ffffff', '#00ff99'], // gradient
    stroke: '#4a1850',
    strokeThickness: 5,
    dropShadow: true,
    dropShadowColor: '#000000',
    dropShadowBlur: 4,
    dropShadowAngle: Math.PI / 6,
    dropShadowDistance: 6,
    wordWrap: true,
    wordWrapWidth: 440,
    lineJoin: 'round',
});


// Listen for frame updates
/*app.ticker.add(() => {
    // each frame we spin the bunny around a bit
    entityPanel.rotation += 0.01;
});*/

let entities = null;
let nodes = null;
let offsetX = 0;
let offsetY = 0;
let offetIncrement = 200;
let nodeX = 0;
let nodeY = 0;
let entityWidth = 160;
let entityHeight = 80;

/**
 * Draw an entity box with their name, avatar, and click link
 * @param entity
 */
const drawEntity = (entity) => {
    //console.log('Draw entity', entity);

    // This creates a texture from a background image
    const entityPanel = new Sprite(texture);
    entityPanel.x = offsetX;
    entityPanel.y = offsetY;
    entityPanel.width = entityWidth;
    entityPanel.height = entityHeight;

    // Add the entityPanel to the scene we are building
    app.stage.addChild(entityPanel);

    // Draw the entity's name in it
    const richText = new Text(entity.name, entityNameStyle);
    richText.x = offsetX + 10;
    richText.y = offsetY + 10;

    app.stage.addChild(richText);
};

/**
 * Draw the relation of a node as well as the "line" between the node's main entity and this relation
 * @param relation
 */
const drawRelation = (relation) => {
    console.log('Draw relation', relation);

    let entity = entities[relation.entity_id];
    drawEntity(entity);

    // Draw the lines between the original and this relations
    drawRelationLine(relation);

    // Draw next node?
    if (relation.nodes !== undefined) {
        offsetY += offetIncrement;
        relation.nodes.forEach(node => {
            drawNode(node);
        });
        offsetY -= offetIncrement;
    }

};

/**
 * Draw a lin between the node's "main" entity and the current relation entity. This is impacted by the
 * nodeY and nodeX
 * @param relation
 */
const drawRelationLine = (relation) => {
    console.log('nodeY x nodeX', nodeY, nodeX);
    const path = [
        nodeX + (entityWidth / 2), nodeY,
        nodeX + (entityWidth / 2), nodeY + (entityHeight + 40),
        offsetX + (entityWidth / 2), offsetY + (entityHeight + 40),
        offsetX + (entityWidth / 2), offsetY,
        offsetX + (entityWidth / 2), offsetY  + (entityHeight + 40),
        nodeX + (entityWidth / 2), nodeY  + (entityHeight + 40),
    ];
    console.log('path', path);

    graphics.lineStyle(1);
    graphics.beginFill(0x3500FA, 1);
    graphics.drawPolygon(path);
    graphics.endFill();

    app.stage.addChild(graphics);
    // Draw relation name
    const relationName = new Text(relation.role);
    relationName.x = nodeX + (entityWidth);
    relationName.y = nodeY + (entityHeight + 10);
    app.stage.addChild(relationName);
};

const drawNode = (node) => {
    console.log('Draw node', node);

    let entity = entities[node.entity_id];
    drawEntity(entity);

    // Loop the relations to draw them on the same line
    if (node.relations) {
        node.relations.forEach(rel => {
            offsetX += offetIncrement;
            drawRelation(rel);
            nodeX = offsetX;
            nodeY = offsetY;
        });
    }
};

const drawTree = () => {
    console.log('Draw tree', entities, nodes);

    nodes.forEach(node => {
        drawNode(node);
    });
};

const renderPage = () => {
    axios.get(container.dataset.api).then((resp) => {
        entities = resp.data['entities'];
        nodes = resp.data['nodes'];
        drawTree();
    });
};

renderPage();
