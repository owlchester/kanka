import { Application, Assets, Sprite, Text, TextStyle, Graphics } from 'pixi.js';
import axios from 'axios';


// The application will create a renderer using WebGL, if possible,
// with a fallback to a canvas render. It will also setup the ticker
// and the root stage PIXI.Container
const app = new Application({ backgroundAlpha: 0, resizeTo: window });

// The application will create a canvas element for you that you
// can then insert into the DOM
const container = document.getElementsByClassName('family-tree-setup')[0];
container.appendChild(app.view);

// load the texture we need
const texture = await Assets.load('/images/family-trees/entity.png');

const graphics = new Graphics();

const entityNameStyle = new TextStyle({
    fontFamily: 'Arial',
    fontSize: 16,
    fontWeight: 'bold',
    lineJoin: 'round',
    breakWords: true,
    wordWrap: true,
    wordWrapWidth: 120,
});

const relationNameStyle = new TextStyle({
    fontFamily: 'Arial',
    fontSize: 14,
    wordWrap: true,
    wordWrapWidth: 120,
});


// Listen for frame updates
/*app.ticker.add(() => {
    // each frame we spin the bunny around a bit
    entityPanel.rotation += 0.01;
});*/

let entities = null;
let nodes = null;
let offsetIncrement = 20;
let childrenLineHeight = 50;
let entityWidth = 140;
let entityHeight = 60;

/**
 * Draw an entity box with their name, avatar, and click link
 * @param entity
 * @param x
 * @param y
 */
const drawEntity = (entity, x, y) => {
    //console.log('Draw entity', entity.name, '>', offsetX, 'v', offsetY);

    // This creates a texture from a background image
    const entityPanel = new Sprite(texture);
    entityPanel.x = x;
    entityPanel.y = y;
    entityPanel.width = entityWidth;
    entityPanel.height = entityHeight;

    // Add the entityPanel to the scene we are building
    //app.stage.addChild(entityPanel);


    var entityBox = new Graphics();
    entityBox.beginFill(0xffffff);
    entityBox.lineStyle(1, 0x0, .3);
    entityBox.drawRoundedRect(
        x,
        y,
        entityWidth,
        entityHeight,
        20
    );
    graphics.endFill();
    app.stage.addChild(entityBox);

    // Draw the entity's name in it
    const entityName = new Text(entity.name, entityNameStyle);
    entityName.x = x + 10;
    entityName.y = y + 10;

    app.stage.addChild(entityName);
};

/**
 * Draw the relation of a node as well as the "line" between the node's main entity and this relation
 * @param relation
 * @param sourceX
 * @param sourceY
 * @param drawX
 * @param drawY
 * @param index
 */
const drawRelation = (relation, sourceX, sourceY, drawX, drawY, index) => {
    let entity = entities[relation.entity_id];

    //console.log('Draw relation', entity.name, drawX);

    drawEntity(entity, drawX, drawY);

    // Draw the lines between the original and this relations
    drawRelationLine(relation, sourceX, sourceY, drawX, drawY);

    // No children, no problems
    if (relation.children === undefined) {
        return;
    }

    // Now the fun starts, this relationship has children and a whole tree to draw!
    if (index === 0) {
        // First relation, start on the source
        drawChildren(relation.children, sourceX, sourceY, sourceX, drawY, index);
    } else {
        // Otherwise start on the relation
        drawChildren(relation.children, sourceX, sourceY, drawX, drawY, index);
    }
};

/**
 * Loop on the children and draw each as a new node
 * @param children
 * @param sourceX
 * @param sourceY
 * @param parentX
 * @param parentY
 * @param index
 */
const drawChildren = (children, sourceX, sourceY, parentX, parentY, index) => {

    //console.log('👩 Draw children');
    // If it's the first element of relations, push to the left
    let startX = sourceX;
    let startY = sourceY + entityHeight + childrenLineHeight;
    let drawX = parentX;
    let drawY = startY;

    // Draw a line between the parents and the children
    let lineX = index === 0 ? drawX + entityWidth + 20 : parentX;
    drawParentChildrenLine(lineX, drawY - 30, index);

    let nodeOffset = 1;
    children.forEach((node) => {

        drawChildrenLine(lineX, drawY - 20, drawX, drawY);
        drawNode(node, startX, startY, drawX, drawY);

        // When preparing to draw the next child, we need to figure out how large the current child was, width wise?
        nodeOffset = childWidth(node);
        //console.log('Looping children', nodeOffset, node);
        drawX += (entityWidth + offsetIncrement) * nodeOffset;
    });

};

/**
 * Draw a lin between the node's "main" entity and the current relation entity. This is impacted by the
 * nodeY and nodeX
 * @param relation
 * @param fromX
 * @param fromY
 */
const drawRelationLine = (relation, originX, originY, targetX, targetY) => {
    //console.log('Draw', relation.role, fromX, fromY);
    let offsetX = (entityWidth / 2);
    const path = [
        // Origin top left
        originX + offsetX, originY + entityHeight,
        // Origin bottom left
        originX + offsetX, originY + (entityHeight + 20),
        // Current bottom right
        targetX + offsetX, targetY + (entityHeight + 20),
        // Current top right
        targetX + offsetX, targetY + entityHeight,
        // Current bottom right
        targetX + offsetX, targetY + (entityHeight + 20),
        // Origin bottom left
        originX + offsetX, originY  + (entityHeight + 20),
    ];
    //console.log('path', path);

    graphics.lineStyle(1);
    graphics.beginFill(0x3500FA, 1);
    graphics.drawPolygon(path);
    graphics.endFill();

    app.stage.addChild(graphics);
    // Draw relation name
    const relationName = new Text(relation.role, relationNameStyle);
    relationName.x = targetX - (40);
    relationName.y = targetY + (entityHeight + 0);
    app.stage.addChild(relationName);
};

const drawChildrenLine = (originX, originY, targetX, targetY) => {
    //console.log('✏️ Draw children from', originX, originY, targetX, targetY);
    //console.info('Draw children line', startX, startY, toX);

    //let offset = (-1 + index) * ((entityWidth + offsetIncrement) * size);
    //let aboveX = startX + (entityWidth / 2) + offset + offsetIncrement;

    let offsetX = (entityWidth / 2);
    let path = [
        // origin
        originX, originY,

        // target top
        targetX + offsetX, targetY - 20,

        // target bottom
        targetX + offsetX, targetY,

        // target top
        targetX + offsetX, targetY - 20,
    ];
    graphics.lineStyle(1);
    graphics.beginFill(0x3500FA, 1);
    graphics.drawPolygon(path);
    graphics.endFill();

    app.stage.addChild(graphics);
};

const drawParentChildrenLine = (drawX, drawY, index) => {

    let path = [
        // top
        drawX, drawY,
        // bottom
        drawX, drawY + 10,
    ];

    // We're not on the first element so everything is pushed around a bit
    if (index > 0) {
        path = [

            // top
            drawX, drawY,

            // bottom
            drawX, drawY + 10,

            // bottom offset
            drawX + entityWidth / 2, drawY + 10,

            // bottom
            drawX, drawY + 10,
        ];
    }
    graphics.lineStyle(1);
    graphics.beginFill(0x3500FA, 1);
    graphics.drawPolygon(path);
    graphics.endFill();

    app.stage.addChild(graphics);
};

/**
 *
 * @param relations
 * @param sourceX
 * @param sourceY
 * @param drawX
 * @param drawY
 */
const drawRelations = (relations, sourceX, sourceY, drawX, drawY) => {
    let nodeOffset = 1;
    //console.info('Draw Relations', relations);
    relations.forEach((rel, index) => {
        // If this is the first relation, we want to draw it next to the parent
        let tmpOffsetX = entityWidth + offsetIncrement;
        // However, if it's not, we need to add more padding, based on the previous node width
        if (index > 0) {
            tmpOffsetX *= nodeOffset - 1;
        }

        drawRelation(rel, drawX, sourceY, drawX + tmpOffsetX, drawY, index);

        nodeOffset += relationWidth(rel, 0);
    });
};

const childWidth = (child, index) => {
    let size = 1;

    // If the child has relations, need to find those
    if (child.relations !== undefined) {
        let largestChild = 2; // At least two because this entity + relation = 2
        child.relations.forEach(rel => {
            let tmp = relationWidth(rel);
            if (tmp > largestChild) {
                largestChild = tmp;
            }
        });
        size = largestChild;
    }

    // If the child has children of its own? Is that possible?
    //console.log('child', child, largestChild);


    //console.log('- relation width', index, width);
    return size;
};

const relationWidth = (relation, index) => {
    let size = 1;

    // No children, only relation, end it there
    if (relation.children === undefined) {
        return size;
    }

    relation.children.forEach(child => {
        if (child.relations === undefined) {
            size++;
            return;
        }

        let largestChild = 0;
        child.relations.forEach(rel => {
            let tmp = relationWidth(rel);
            if (tmp > largestChild) {
                largestChild = tmp;
            }
        });
        size += largestChild;
    });

    return size;
};

const drawNode = (node, sourceX, sourceY, drawX, drawY) => {
    // Draw the main entity of the node
    let entity = entities[node.entity_id];

    //console.log('⚡ Node:', entity.name, 'from', sourceX, sourceY, 'on', drawX, drawY);
    drawEntity(entity, drawX, drawY);

    // No relations to draw, finished with the node
    if (!node.relations) {
        return;
    }

    // Loop the relations to draw them on the same line
    drawRelations(node.relations, sourceX, sourceY, drawX, drawY);
};

const renderPage = () => {
    axios.get(container.dataset.api).then((resp) => {
        entities = resp.data.entities;
        nodes = resp.data.nodes;

        /*console.info('Draw tree');
        console.log(entities);
        console.log(nodes);*/

        nodes.forEach(node => {
            drawNode(node, 0, 0, 0, 0);
        });
    });
};

renderPage();
