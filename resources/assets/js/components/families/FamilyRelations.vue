<template>
    <FamilyRelation
        v-for="(relation, index) in relations"
        :relation="relation"
        :index="index"
        :entities="entities"
        :sourceX="drawX"
        :sourceY="sourceY"
        :drawX="nextDrawX(relation, index)"
        :drawY="drawY"
        :isEditing="this.isEditing"
    ></FamilyRelation>
</template>

<script>
import FamilyRelation from "./FamilyRelation";

export default {
    props: {
        relations: undefined,
        entities: undefined,
        sourceX: 0,
        sourceY: 0,
        drawX: 0,
        drawY: 0,
        isEditing: undefined,
    },

    components: {
        FamilyRelation

    },

    data() {
        return {
        }
    },

    methods: {

        nextDrawX(rel, index) {

            return this.calcPreviousRelations(index);

            if (this.nodeOffset === undefined) {
                this.nodeOffset = 1;
            }
            // If this is the first relation, we want to draw it next to the parent
            let tmpOffsetX = 200 + 20;
            // However, if it's not, we need to add more padding, based on the previous node width
           // console.log('nextDrawX index', index);
            if (index > 0) {
                tmpOffsetX *= this.nodeOffset;
                //console.log('increment tmpOffsetX to', tmpOffsetX);
            }

            let relWidth = this.relationWidth(rel, 0);
            //console.log('Relation width', relWidth);
            this.nodeOffset += relWidth - 1;
            //console.log('Now the nodeOffset is at', this.nodeOffset);
            //console.log('drawX', this.drawX);
            //console.log('me', index, this.drawX, this.tmpOffsetX);
            return this.drawX + tmpOffsetX;
        },

        calcPreviousRelations(index) {
            let nodeOffset = 1;
            let tmpOffsetX = 200 + 20;

            for(let i = 0; i < index; i++) {
                let rel = this.relations[i];
                let relWidth = this.relationWidth(rel, 0);
                nodeOffset += relWidth - 1;
            }

            tmpOffsetX *= nodeOffset;
            return this.drawX + tmpOffsetX;
        },

        relationWidth(rel, index) {
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
        },
    },
    mounted() {
        //console.info('FamilyRelations', this.relations);
    }
};
</script>
