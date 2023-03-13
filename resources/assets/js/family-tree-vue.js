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




/*window.familyTreeChildWidth = function (node, index) {
    console.log(node.entity_id, 'checking node', index, node);

    // There is nothing else in this node, finished
    if (node.children === undefined && node.relations === undefined) {
        console.log(node.entity_id, 'just one');
        return 1;
    }

    let size = 0;
    if (index === 0) {
        //size = -1;
    }
    // If a node has relations, they each represent at least one extra
    if (node.relations !== undefined && node.relations.length > 0) {
        //size = index === 0 ? -1 : 0;
        let largestRelation = 1;
        node.relations.forEach(rel => {
            let tmpSize = window.familyTreeRelationWidth(rel, index);
            //if (tmpSize > largestRelation) {
             //   largestRelation = tmpSize;
            //}
            size += tmpSize;
        });
        //size += largestRelation;
        console.log(node.entity_id, 'had relations', 'largest', largestRelation, size);
    }

    if (node.children === undefined) {
        if (index === 0) {
            console.log(node.entity_id, 'just two, but one');
            return Math.max(size, 1);
        }
        console.log(node.entity_id, 'just two');
        return Math.max(size, 1);
    }

    console.log(node.entity_id, 'Going to look at the kids', node, size);
    node.children.forEach(child => {
        if (child.relations === undefined) {
            size++;
            console.log(node.entity_id, 'no-relation child', size);
            //return size;
        } else {
            let largestChild = 1;
            child.relations.forEach(rel => {
                let tmp = window.familyTreeRelationWidth(rel, index);
                if (tmp > largestChild) {
                    largestChild = tmp;
                }
            });
            size += largestChild;
            console.log(node.entity_id, 'has children', 'largest', largestChild, size);
        }
    });
    console.log(node.entity_id, 'largest', size);

    return Math.max(size, 1);
};

window.familyTreeRelationWidth = function (relation, index) {
    let size = 1;
    console.log('checking', relation);

    // No children, only relation, end it there
    if (relation.children === undefined || relation.children.length === 0) {
        console.log('has no children', relation.children);
        return 1;
    }

    relation.children.forEach(child => {
        if (child.relations === undefined || child.relations.length === 0) {
            size++;
        } else {
            let largestChild = 1;
            child.relations.forEach(rel => {
                let tmp = window.familyTreeRelationWidth(rel, index);
                if (tmp > largestChild) {
                    largestChild = tmp;
                }
            });
            size += largestChild;
            //if (size > 0 && index === 0) {
            //    size--;
            //}
        }
    });

    return Math.max(size, 1);
};

window.familyTreeNodeWidth = function (node, index) {
    let size = 1;

    // Loop on each relation
    if (node.relations === undefined || node.relations.length === 0) {
        return 2;
    }
    node.relations.forEach(rel => {
        size += familyTreeRelationWidthV2(rel, index);
    });

    return size;
};

function familyTreeRelationWidthV2(rel, index) {

    // Look for the largest child
    if (rel.children === undefined || rel.children.length === 0) {
        return 1;
    }
    let size = 0;
    let largest = 1;
    rel.children.forEach(child => {
        let tmp = familyTreeChildWidth(child, index);
        if (tmp > largest) {
            largest = tmp;
        }
    });
    size += largest;


    return Math.max(1, size);
}

function familyTreeChildWidth(child, index) {
    if (child.relations === undefined || child.relations.length === 0) {
        return 1;
    }

    // Go figure out the child's largest relation
    let size = 0, largest = 1;
    child.relations.forEach(rel => {
        let tmp = familyTreeRelationWidthV2(rel, index);
        if (tmp > largest) {
            largest = tmp;
        }
        size += tmp;
    });

    size += largest;
    return size;
}
*/

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

    // Let's find out just how wide this child is
    let largest = 1;
    /**
     * Loop on each of the child's relations, making this node wider (for each relation's size)
     * If it's just 3 relations, the node is 1+3 (relations) wide
     */
    child.relations.forEach(rel => {
        // Each direct relation make the child a bit wider
        min++;
        if (rel.children !== undefined && rel.children.length > 0) {
            /**
             * Loop each child of the relation, looking for the "widest" one
             * On each child, we need to get its total width (child + relation + children) and add it to the width
             * of the current child
             */
            let largestChild = 1;
            rel.children.forEach((c, i) => {
                // Each child after the first makes the minimum a bit wider
                //largestChild++;
                if (i > 0) {
                    min++;
                }
                let childWidth = window.familyTreeChildWidth(c);
                // We now have the child's width, which we need to "save" for the offset
                if (childWidth > largestChild) {
                    largestChild = childWidth;
                    largest = childWidth;
                }
            });

            // If the amount of children is larger than the largest child, use that instead
            if (rel.children.length > largestChild) {
                largestChild = rel.children.length;
            }

            // Save the largest child as the minimum
            if (largestChild > largest) {
                largest = largestChild;
            }
        }
    });

    if (largest > min) {
        min = largest;
    }

    // Return the largest relation
    return Math.max(largest, min);
};

/**
 * Count how wide a relation is, counting itself + all of its children
 */
window.familyTreeRelationWidth = function(relation, index) {
    if (relation.children === undefined || relation.children.length === 0) {
        return 1;
    }

    // At least 1 wide for each relation
    let min = 1;

    // Let's find out just how wide this is
    relation.children.forEach(child => {
        min++;
        if (child.relations !== undefined && child.relations.length > 0) {
            // If the relation has children, we need to figure out the largest child tree
            let largest = 0;
            child.relations.forEach((c, i) => {
                if (i > 0) {
                    min++;
                }
                let tmp = window.familyTreeRelationWidth(c);
                if (tmp > largest) {
                    largest = tmp;
                }
            });

            if (child.relations.length > largest) {
                largest = child.relations.length;
            }

            if (largest > min) {
                min = largest;
            }
        }
    });

    // Return the largest child
    return min;
};

