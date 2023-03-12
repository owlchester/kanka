<template>
    <FamilyNode
        v-for="relation in this.getChildren()"
        :node="relation"
        :entities="entities"
        :sourceX="this.startX"
        :sourceY="this.startY"
        :drawX="getDrawX(relation, index)"
        :drawY="this.drawY"
    ></FamilyNode>
</template>

<script>

export default {
    props: {
        children: {
            type: Array
        },
        entities: undefined,
        sourceX: 0,
        sourceY: 0,
        drawX: 0,
        drawY: 0,
        startX: 0,
        startY: 0,
        lineX: 0,
        index: 0,
    },

    /*data() {
        let nextDrawX = this.drawX;
        let nodeOffset = 0;
        let x = 0;
        return {
            nextDrawX,
            nodeOffset,
            x
        };
    },*/
    methods: {
        getChildren() {
            //console.log('get children', this.children);
            return this.children;
        },
        getDrawX(node, index) {
            //console.log('getDrawX', index);

            // If this is the first relation, we want to draw it next to the parent
            if (this.nextDrawX === undefined) {
                this.nextDrawX = this.drawX;
            }
            //console.log('children', index, this.nextDrawX)
            this.x = this.nextDrawX;


            let childWidth
            this.nodeOffset = this.childWidth(node) - 1;

            this.nextDrawX += this.nodeOffset * (200 + 20);
            return this.x;
        },
        childWidth(el) {
            let size = 2;

            // If the child has relations, need to find those
            if (el.relations === undefined) {
                return size;
            }
            let largestChild = 2; // At least two because this entity + relation = 2
            el.relations.forEach(rel => {
                let tmp = this.relationWidth(rel);
                if (tmp > largestChild) {
                    largestChild = tmp;
                }
            });
            size = largestChild;

            // If the child has children of its own? Is that possible?
            //console.log('child', child, largestChild);

            //console.log('- relation width', index, width);
            return size;
        },
        relationWidth(rel) {
            let size = 1;

            // No children, only relation, end it there
            if (rel.children === undefined) {
                return size;
            }

            rel.children.forEach(child => {
                if (child.relations === undefined) {
                    size++;
                    return;
                }

                let largestChild = 0;
                child.relations.forEach(rel => {
                    let tmp = this.relationWidth(rel);
                    if (tmp > largestChild) {
                        largestChild = tmp;
                    }
                });
                size += largestChild;
            });

            return size;
        }
    },
};
</script>
