import { createApp } from 'vue'
import mitt from 'mitt'

const emitter = mitt()
const app = createApp({})
app.config.globalProperties.emitter = emitter
app.component('family-tree', require('./components/families/FamilyTree.vue').default)
app.component('FamilyNode', require('./components/families/FamilyNode.vue').default)
app.component('FamilyEntity', require('./components/families/FamilyEntity.vue').default)
app.component('FamilyRelations', require('./components/families/FamilyRelations.vue').default)
app.component('FamilyRelation', require('./components/families/FamilyRelation.vue').default)
app.component('FamilyChildren', require('./components/families/FamilyChildren.vue').default)
app.component('RelationLine', require('./components/families/RelationLine.vue').default)
app.component('ChildrenLine', require('./components/families/ChildrenLine.vue').default)
app.component('FamilyParentChildrenLine', require('./components/families/FamilyParentChildrenLine.vue').default)
app.mount('#family-tree');



/**
 * Figure out the width of a child (when drawing a relation). This is used when calculating where to draw the next node
 * (the next relation)
 * @param child
 * @param index
 */
window.familyTreeChildWidth = function(child, index) {
    if (child.relations === undefined || child.relations.length === 0) {
        return 1;
    }
    // The minimum width based on the topmost elements
    let min = 1;

    /**
     * Loop on each of the child's relations, making this node wider (for each relation's size)
     * If it's just 3 relations, the node is 1+3 (relations) wide
     */
    child.relations.forEach(rel => {
        // Relation ads at least 1 width
        min++;
        if (rel.children !== undefined && rel.children.length > 0) {
            // If there are children, we start back at 0 because the node + rel already counts as two
            min -= 2;
            /**
             * Loop each child of the relation, looking for the "widest" one
             * On each child, we need to get its total width (child + relation + children) and add it to the width
             * of the current child
             */
            rel.children.forEach((c, i) => {
                // Get each child's width, (child + relations + their children) and add it to the size.
                // Deduct one because each child starts on a new line and is pushed left
                let childWidth = window.familyTreeChildWidth(c);
                //console.log(c.entity_id, 'childWidth', childWidth);
                min += childWidth;
            });
        }
    });

    // Return the largest relation
    return Math.max(1, min);
};

window.familyTreeNodeWidth = function (node, index) {
    let size = 1;
    return size;
};


/**
 * Count how wide a relation is, counting itself + all of its children
 */
window.familyTreeRelationWidth = function(relation, index) {
    if (relation.children === undefined || relation.children.length === 0) {
        return 1;
    }

    // At least 1 wide for each relation
    let min = 0;

    // Let's find out just how wide this relation is
    relation.children.forEach((child, i) => {
        // The first two children are below the parent and this entity
        if (i > 0) {
            min++;
        }
        if (child.relations !== undefined && child.relations.length > 0) {
            // If the relation has children, we need to figure out the largest child tree
            child.relations.forEach((c, i) => {
                min++;
                let tmp = window.familyTreeRelationWidth(c);
                console.log(c.entity_id, 'relWidth', tmp);
                min += tmp;
            });
        }
    });

    // Return the largest child
    return Math.max(1, min);
};

