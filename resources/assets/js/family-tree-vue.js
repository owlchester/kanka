import { createApp } from 'vue'
import mitt from 'mitt'
import drag from "v-drag"

const emitter = mitt()
const app = createApp({})
app.config.globalProperties.emitter = emitter
app.config.globalProperties.entityHeight = 60
app.config.globalProperties.entityWidth = 200
app.component('family-tree', require('./components/families/FamilyTree.vue').default)
app.component('FamilyNode', require('./components/families/FamilyNode.vue').default)
app.component('FamilyEntity', require('./components/families/FamilyEntity.vue').default)
app.component('FamilyRelations', require('./components/families/FamilyRelations.vue').default)
app.component('FamilyRelation', require('./components/families/FamilyRelation.vue').default)
app.component('FamilyChildren', require('./components/families/FamilyChildren.vue').default)
app.component('RelationLine', require('./components/families/RelationLine.vue').default)
app.component('ChildrenLine', require('./components/families/ChildrenLine.vue').default)
app.component('FamilyParentChildrenLine', require('./components/families/FamilyParentChildrenLine.vue').default)

app.use(drag, {
    // global configuration
});
app.mount('#family-tree');


window.ftTexts = {};

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
    // The minimum width based on the topmost elements. Since the first child starts below the first parent, we go
    // back 1
    let size = -1;

    /**
     * Loop on each of the child's relations, making this node wider (for each relation's size)
     * If it's just 3 relations, the node is 1+3 (relations) wide
     */
    child.relations.forEach(rel => {
        // Relation ads at least 1 width
        size++;
        if (rel.children !== undefined && rel.children.length > 0) {
            // If there are children, we start back at 0 because the node + rel already counts as two
            /*if (rel.children.length > 1) {
                min -= 2;
            } else if (rel.children.length > 0 && index === 0) {
                min -= 1;
            }*/
            /**
             * Loop each child of the relation, looking for the "widest" one
             * On each child, we need to get its total width (child + relation + children) and add it to the width
             * of the current child
             */
            rel.children.forEach((c, i) => {
                // Get each child's width, (child + relations + their children) and add it to the size.
                // Deduct one because each child starts on a new line and is pushed left
                let childWidth = window.familyTreeChildWidth(c, index);
                //console.log(c.entity_id, 'childWidth', childWidth);
                size += childWidth;
            });
        }
    });

    // The minimum width, in case a child has two relations but no children, if the amount of relations + itself
    let minWidth = child.relations.length + 1;
    // Get the largest calculated size
    return Math.max(minWidth, size);
};

/**
 * Count how wide a relation is, counting itself + all of its children
 */
window.familyTreeRelationWidth = function(relation, index) {
    // The first relation counts for 2 spaces (the source + itself), while any more relations could for just one
    let min = index === 0 ? 2 : 1;
    // If a relation has no children, then it's simple, we use the "min" size of the relation
    if (relation.children === undefined || relation.children.length === 0) {
        return min;
    }

    // Since we have a minimum size, we start at 0
    let size = 0;

    let directSize = 0;
    let hasSubBranch = false;

    // Let's find out just how wide this relation is
    relation.children.forEach((child, i) => {
        directSize++;
        // Each relation increases the size by at least one
        if (i > 0) {
            size++;
        }
        if (child.relations !== undefined && child.relations.length > 0) {
            // For each of the relation's children, calculate their width, and add that to the current size
            child.relations.forEach((c, i2) => {
                directSize++;


                if (c.children !== undefined && c.children.length > 0) {
                    hasSubBranch = true;
                }
                let tmp = window.familyTreeRelationWidth(c, i2);

                //console.log(i2, c.entity_id, 'relWidth', '(min: ', min, ')', 'tmp', tmp);

                // No idea why this works, but it does. It sometimes makes too much space
                if (i === 0 && tmp > 2) {
                    directSize += (tmp - 2);
                } /*else if (i > 0 && tmp > 1) {
                    directSize += (tmp - 1);
                }*/
                size += tmp;
                //size += tmp;
            });
        }
    });

    // If this branch has no subbranches, use the easy count as the value, otherwise it can get tricky
    if (!hasSubBranch) {
        return Math.max(directSize, min);
    }

    // Return the size of the tree, or the size of the children,
    // if none of the children have relations and their own children
    min = Math.max(directSize, min);

    let final = Math.max(min, size);
    return Math.max(min, size);
};

