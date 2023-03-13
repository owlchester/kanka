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




window.familyTreeNodeWidth = function (node, index) {
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
            if (tmpSize > largestRelation) {
                largestRelation = tmpSize;
            }
            //size += tmpSize;
        });
        size += largestRelation;
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

/**
 * Looping on a relation, check its children
 * @param relation
 * @param index
 * @returns {number}
 */
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
            /*if (size > 0 && index === 0) {
                size--;
            }*/
        }
    });

    return Math.max(size, 1);
};

window.familyTreeChildWidth = function (child, index) {

};
