import { Application, Assets, Sprite, Text, TextStyle, Graphics, Texture } from 'pixi.js';
import axios from 'axios';
import { Viewport } from 'pixi-viewport';

// The application will create a renderer using WebGL, if possible,
// with a fallback to a canvas render. It will also setup the ticker
// and the root stage PIXI.Container
const app = new Application({ backgroundAlpha: 0, resizeTo: window });

// The application will create a canvas element for you that you
// can then insert into the DOM
const container = document.getElementsByClassName('family-tree-setup')[0];

// load the texture we need
const texture = await Assets.load('/images/family-trees/entity.png');

const graphics = new Graphics();

let elements = [];

// create viewport
const viewport = new Viewport({
    screenWidth: window.innerWidth,
    screenHeight: window.innerHeight,
    worldWidth: 1000,
    worldHeight: 1000,

    interaction: app.renderer.plugins.interaction // the interaction module is important for wheel to work properly when renderer.view is placed or scaled
});

const entityNameStyle = new TextStyle({
    fontFamily: '"Roboto", "Source Sans Pro", "Helvetica Neue", Helvetica, Arial, sans-serif',
    fontSize: 14,
    lineJoin: 'round',
    breakWords: true,
    wordWrap: true,
    wordWrapWidth: 85,
});

const relationNameStyle = new TextStyle({
    fontFamily: 'Helvetica, Arial, sans-serif',
    fontSize: 14,
    wordWrap: true,
    wordWrapWidth: 120,
});

var newUuid = 1;       // UUID
let entities = null;
let nodes = null;
let originalNodes = null;
let offsetIncrement = 20;
let childrenLineHeight = 50;
let entityWidth = 140;
let entityHeight = 60;

let btnEdit, btnClear, btnReset, btnSave;


let isEditing = false;

/**
 * Draw an entity box with their name, avatar, and click link
 * @param entity
 * @param x
 * @param y
 */
const drawEntity = (entity, uuid, x, y, isRelation = false) => {
    //console.log('Draw entity', entity.name, '>', offsetX, 'v', offsetY);

    // This creates a texture from a background image
    let entityPanel = new Sprite(texture);
    entityPanel.x = x;
    entityPanel.y = y;
    entityPanel.width = entityWidth;
    entityPanel.height = entityHeight;

    // Add the entityPanel to the scene we are building
    //app.stage.addChild(entityPanel);

    let entityBox = new Graphics();
    entityBox.beginFill(0xffffff);
    entityBox.lineStyle(1, 0x0, .3);
    entityBox.drawRoundedRect(
        x,
        y,
        entityWidth,
        entityHeight,
        20
    );
    entityBox.endFill();
    //app.stage.addChild(entityBox);
    viewport.addChild(entityBox);
    elements.push(entityBox);



    var circleMask = new Graphics();
    circleMask.beginFill();
    circleMask.drawCircle(x + 110, y + 30, 20);
    circleMask.endFill();
    //app.stage.addChild(circleMask);
    viewport.addChild(circleMask);
    elements.push(circleMask);

    var entityImageTexture = Texture.from(entity.thumb);

    var entityImage = new Sprite(entityImageTexture);
    entityImage.x = x + 90;
    entityImage.y = y + 10;
    entityImage.height = 40;
    entityImage.width = 40;

    //app.stage.addChild(entityImage);
    viewport.addChild(entityImage);
    elements.push(entityImage);

    entityImage.mask = circleMask;
    var name = entity.name;
    if (name.length > 14) {
        name = name.substring(0, 14);
        name = name.concat('...');
    }
    const entityName = new Text(name, entityNameStyle);
    entityName.x = x + 10;
    entityName.y = y + 10;

    viewport.addChild(entityName);
    elements.push(entityName);

    // Add an invisible box on top
    var hitBox = new Graphics();
    hitBox.beginFill(0xff0000, 1.0);
    hitBox.lineStyle(1, 0x22bbff, 1);
    hitBox.drawRoundedRect(
        x,
        y,
        entityWidth,
        entityHeight,
        20
    );
    hitBox.endFill();
    hitBox.interactive = true;
    hitBox.buttonMode = true;
    hitBox.onclick = (event) => {
        location.href = entity.url;
    };
    hitBox.alpha = 0;
    hitBox.on('pointerover', (event) => onPointerOver(entityBox));
    hitBox.on('pointerout', (event) => onPointerOut(entityBox));
    //app.stage.addChild(hitBox);
    viewport.addChild(hitBox);
    elements.push(hitBox);

    if (isEditing) {
        const closeButton = new Text('x', entityNameStyle);
        closeButton.x = x + 125;
        closeButton.y = y;
        closeButton.interactive = true;
        closeButton.buttonMode = true;
        closeButton.onclick = (event) => {
            deleteUuid(uuid);
        };
        viewport.addChild(closeButton);
        elements.push(closeButton);

        const editButton = new Text('edit', entityNameStyle);
        editButton.x = x + 35;
        editButton.y = y + 60;
        editButton.interactive = true;
        editButton.buttonMode = true;
        editButton.onclick = (event) => {
            editEntity(uuid);
        };
        viewport.addChild(editButton);
        elements.push(editButton);


        const addRelationButton = new Text('+ relation', entityNameStyle);
        addRelationButton.x = x + 140;
        addRelationButton.y = y + 20;
        addRelationButton.interactive = true;
        addRelationButton.buttonMode = true;
        addRelationButton.onclick = (event) => {
            addRelation(uuid);
        };
        viewport.addChild(addRelationButton);
        elements.push(addRelationButton);

        if (isRelation) {
            const addChildrenButton = new Text('+ children', entityNameStyle);
            addChildrenButton.x = x + 75;
            addChildrenButton.y = y + 60;
            addChildrenButton.interactive = true;
            addChildrenButton.buttonMode = true;
            addChildrenButton.onclick = (event) => {
                addChildren(uuid);
            };
            viewport.addChild(addChildrenButton);
            elements.push(addChildrenButton);
        }
    }

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
    if (!entity) {
        return;
    }

    //console.log('Draw relation', entity.name, drawX);

    drawEntity(entity, relation.uuid, drawX, drawY, true);

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

    // Draw relation name
    const relationName = new Text(relation.role, relationNameStyle);
    relationName.x = targetX - (40);
    relationName.y = targetY + (entityHeight + 0);
    relationName.interactive = true;
    relationName.buttonMode = true;
    if (isEditing) {
        relationName.onclick = (event) => {
            renameRelation(relation.uuid);
        };
    }
    viewport.addChild(relationName);
    elements.push(relationName);
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
    if (!entity) {
        return;
    }

    //console.log('⚡ Node:', entity.name, 'from', sourceX, sourceY, 'on', drawX, drawY);
    drawEntity(entity, node.uuid, drawX, drawY);

    // No relations to draw, finished with the node
    if (!node.relations) {
        return;
    }

    // Loop the relations to draw them on the same line
    drawRelations(node.relations, sourceX, sourceY, drawX, drawY);
};

const drawFamilyTree = () => {
    console.log('Draw Family Tree');

    // add the viewport to the stage
    app.stage.addChild(viewport);

    // activate plugins
    viewport
        .drag()
        .pinch()
        .wheel()
        .decelerate({
            friction: 0.50,  //Percent to decelerate after movement
        });

    graphics.clear();
    elements.forEach(text => {
        viewport.removeChild(text);
    });

    nodes.forEach(node => {
        drawNode(node, 0, 0, 0, 0);
    });

    viewport.addChild(graphics);
};

const renderPage = () => {
    if (typeof app.stage !== 'undefined'){
        console.log('deleted','container.removeChild');
        //app.stage.removeChild(1);
        //for (var i = app.stage.children.length - 1; i >= 0; i--) {	app.stage.removeChild(app.stage.children[i]);};
    }
    container.appendChild(app.view);
    //console.log(container.dataset.api, 'api');
    axios.get(container.dataset.api).then((resp) => {
        entities = resp.data.entities;
        nodes = resp.data.nodes;
        originalNodes = JSON.parse(JSON.stringify(resp.data.nodes));
        console.log('original nodes', originalNodes);
        drawFamilyTree();
    });
};
function onPointerOver(object) {
    object.tint = 0x999999;
}

function onPointerOut(object) {
    object.tint = 0xFFFFFF;
}

const deleteUuidFromNodes = (uuid) => {
    console.log('Remove uuid', uuid);
    return filter(nodes, uuid);
};

const replaceEntity = (uuid, entity) => {
    console.log('Change Entity', uuid);
    return entityEditor(nodes, uuid, entity);
};

const insertRelation = (uuid, entity, relation) => {
    console.log('Add Relation', uuid);
    return relationCreator(nodes, uuid, entity, relation);
};

const insertChild = (uuid, entity) => {
    console.log('Add Child', uuid);
    return childCreator(nodes, uuid, entity);
};

const renameRelations = (uuid, role) => {
    console.log('Rename relation', uuid, nodes);
    return relationFilter(nodes, uuid, role);
};

function relationFilter(array, uuid, role) {
    //console.log('filter', array, uuid);
    const getRelationNodes = (result, object) => {
        console.log('ape');
        if (object.uuid === uuid) {
            console.log(object);
            object.entity_id = entity.id;
            object.entity_id = entity.id;

            result.push(object);
            //console.log(object);
            return result;
        }

        if (Array.isArray(object.children)) {
            const children = object.children.reduce(getRelationNodes, []);
            object.children = children;
        }
        else if (Array.isArray(object.relations)) {
            const relations = object.relations.reduce(getRelationNodes, []);
            object.relations = relations;
        }

        result.push(object);
        return result;
    };
    return array.reduce(getRelationNodes, []);
}

function entityEditor(array, uuid, entity) {
    var entity_id = null;

    entities.forEach((existingEntity, index) => {
        if (existingEntity === entity) {
            entity_id = index;
        }
    });

    if (!entity_id) {
        entities.push(entity);
        entity_id = entities.length - 1;
    }

    const getRelationNodes = (result, object) => {
        if (object.uuid === uuid) {
            object.entity_id = entity_id;
            result.push(object);
            return result;
        }

        if (Array.isArray(object.children)) {
            const children = object.children.reduce(getRelationNodes, []);
            object.children = children;
        }
        else if (Array.isArray(object.relations)) {
            const relations = object.relations.reduce(getRelationNodes, []);
            object.relations = relations;
        }

        result.push(object);
        return result;
    };
    return array.reduce(getRelationNodes, []);
}

function relationCreator(array, uuid, entity, role) {
    var entity_id = null;

    entities.forEach((existingEntity, index) => {
        if (existingEntity === entity) {
            entity_id = index;
        }
    });

    if (!entity_id) {
        entities.push(entity);
        entity_id = entities.length - 1;
    }
    const getRelationNodes = (result, object) => {
        if (object.uuid === uuid) {
            console.log(object);

            if (Array.isArray(object.relations)) {
                object.relations.push({entity_id: entity_id, role: role, uuid: stringify(newUuid)});
            } else {
                object.relations = [{entity_id: entity_id, role: role, uuid: stringify(newUuid)}];
            }
            newUuid = newUuid + 1;
            console.log(object, 'ADDED RELATIONS');
            result.push(object);
            return result;
        }
        if (Array.isArray(object.children)) {
            const children = object.children.reduce(getRelationNodes, []);
            object.children = children;
        }
        else if (Array.isArray(object.relations)) {
            const relations = object.relations.reduce(getRelationNodes, []);
            object.relations = relations;
        }
        result.push(object);
        return result;
    };
    return array.reduce(getRelationNodes, []);
}

function childCreator(array, uuid, entity) {
    var entity_id = null;

    entities.forEach((existingEntity, index) => {
        if (existingEntity === entity) {
            entity_id = index;
        }
    });

    if (!entity_id) {
        entities.push(entity);
        entity_id = entities.length - 1;
    }
    const getRelationNodes = (result, object) => {
        if (object.uuid === uuid) {
            console.log(object);

            if (Array.isArray(object.children)) {
                object.children.push({entity_id: entity_id, uuid: stringify(newUuid)});
            } else {
                object.children = [{entity_id: entity_id, uuid: stringify(newUuid)}];
            }
            newUuid = newUuid + 1;
            console.log(object, 'ADDED CHILDREN');
            result.push(object);
            return result;
        }
        if (Array.isArray(object.children)) {
            const children = object.children.reduce(getRelationNodes, []);
            object.children = children;
        }
        else if (Array.isArray(object.relations)) {
            const relations = object.relations.reduce(getRelationNodes, []);
            object.relations = relations;
        }
        result.push(object);
        return result;
    };
    return array.reduce(getRelationNodes, []);
}

function filter(array, uuid) {
    //console.log('filter', array, uuid);
    const getNodes = (result, object) => {
        // If it's the uuid we're looking for, return an empty array
        if (object.uuid === uuid) {
            return result;
        }
        if (Array.isArray(object.children)) {
            const children = object.children.reduce(getNodes, []);
            object.children = children;
        }
        else if (Array.isArray(object.relations)) {
            const relations = object.relations.reduce(getNodes, []);
            object.relations = relations;
        }
        result.push(object);
        return result;
    };
    // If the first node is the uuid, delete everything
    if (array[0].uuid === uuid) {
        return array.splice(0, 1);
    }
    return array.reduce(getNodes, []);
}

function deleteUuid(uuid) {
    if (confirm("Do you want to remove this node?") == true) {
        viewport.removeChildren();
        deleteUuidFromNodes(uuid);
        drawFamilyTree();
    }
}

function editEntity(uuid) {
    document.getElementById("add-relation").style.display = "none";
    $('#add-entity').modal('show');
    $('#send').off('click').on('click', function () {
        var entity_id = $('select[name="character_id"]').val();
        console.log(entity_id, uuid, container.dataset.entity, 'old');

        let url = container.dataset.entity.replace('/0', '/' + entity_id);
        axios.get(url).then(function (res) {
            var entity = res.data;
            console.log('result', res.data);
            viewport.removeChildren();
            replaceEntity(uuid, entity);
            drawFamilyTree();
        });
        $('.close');
        $('#add-entity').modal('hide');
    });
}

function addRelation(uuid) {
    document.getElementById("add-relation").style.display = "";
    $('#add-entity').modal('show');
    $('#send').off('click').on('click', function () {
        var entity_id = $('select[name="character_id"]').val();
        var relation = $('input[name="relation"]').val();

        //console.log(entity_id, uuid, container.dataset.entity, 'old');
        console.log(entity_id, relation, 'ADDING RELATION');

        let url = container.dataset.entity.replace('/0', '/' + entity_id);
        axios.get(url).then(function (res) {
            var entity = res.data;
            console.log('Values from the API', res.data);
            viewport.removeChildren();
            insertRelation(uuid, entity, relation);
            //replaceEntity(uuid, entity, relation);
            drawFamilyTree();
        });

        document.getElementById("add-relation").style.display = "none";
        $('.close');
        $('#add-entity').modal('hide');
    });
}

function addChildren(uuid) {
    document.getElementById("add-relation").style.display = "none";
    $('#add-entity').modal('show');
    $('#send').off('click').on('click', function () {
        var entity_id = $('select[name="character_id"]').val();
        console.log(entity_id, uuid, container.dataset.entity, 'old');

        let url = container.dataset.entity.replace('/0', '/' + entity_id);
        axios.get(url).then(function (res) {
            var entity = res.data;
            console.log('result', res.data);
            viewport.removeChildren();
            insertChild(uuid, entity);
            drawFamilyTree();
        });
        $('.close');
        $('#add-entity').modal('hide');
    });
}
function renameRelation(uuid) {
    let relation = prompt("Rename relation");
    if (relation) {
        viewport.removeChildren();
        console.log(relation)
        renameRelations(uuid, relation);
        drawFamilyTree();
    }
}

/**
 * Reset the tree as it was when originally loaded, and exit the edit mode
 */
const resetTree = () => {
    console.info('Resetting...');

    btnClear.hide();
    btnSave.hide();
    btnReset.hide();
    btnEdit.show();

    // Reset the nodes as they were on page load
    nodes = JSON.parse(JSON.stringify(originalNodes));
    console.log('original nodes', nodes);

    // Edit edit mode and redraw the tree
    isEditing = false;
    drawFamilyTree();
};

/**
 * Clear the tree to start from a blank canvas
 */
const clearTree = () => {
    console.info('Clearing...');
};

const enterEditMode = () => {
    console.info('Editing...');

    // Change which buttons are available
    btnEdit.hide();
    btnSave.prop('disabled', true).show();
    btnClear.show();
    btnReset.show();

    // Redraw the tree in edit mode
    isEditing = true;
    drawFamilyTree();
};

const initFamilyTree = () => {
    // Handle button modes
    btnEdit = $('#tree-edit');
    btnSave = $('#tree-save');
    btnClear = $('#tree-clear');
    btnReset = $('#tree-reset');

    btnEdit.on('click', function (e) {
        e.preventDefault();
        enterEditMode();
    });

    btnClear.on('click', function (e) {
        e.preventDefault();
        clearTree();
    });
    btnReset.on('click', function (e) {
        e.preventDefault();
        resetTree();
    });
    btnSave.on('click', function (e) {
        e.preventDefault();
        console.info('Saving...');
    });

    // Draw the page
    renderPage();
};

// When jQuery is ready, draw the family tree
$(document).ready(function () {
    initFamilyTree();
});
