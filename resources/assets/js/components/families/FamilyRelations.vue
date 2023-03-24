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

        :sourceColumn="column"
        :sourceRow="sourceRow"
        :column="nextColumn(relation, index)"
        :row="row"

        :isEditing="this.isEditing"
    ></FamilyRelation>
</template>

<script>
import FamilyRelation from "./FamilyRelation";

export default {
    props: {
        relations: undefined,
        entities: undefined,
        isEditing: undefined,

        sourceX: 0,
        sourceY: 0,
        drawX: 0,
        drawY: 0,

        sourceColumn: 0,
        sourceRow: 0,
        column: 0,
        row: 0,

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
        },
        calcPreviousRelations(index) {
            let nodeOffset = 0;
            if (index === 0) {
                nodeOffset = 1;
            }
            let tmpOffsetX = this.entityWidth + 20;

            for(let i = 0; i < index; i++) {
                let relWidth = window.familyTreeRelationWidth(this.relations[i], i);
                nodeOffset += relWidth;
            }

            tmpOffsetX *= nodeOffset;
            return this.drawX + tmpOffsetX;
        },
        nextColumn(rel, index) {
            return this.calcPreviousRelationsCol(index);
        },
        calcPreviousRelationsCol(index) {
            let nodeOffset = 0;
            if (index === 0) {
                nodeOffset = 1;
            }
            for(let i = 0; i < index; i++) {
                let relWidth = window.familyTreeRelationWidth(this.relations[i], i);
                nodeOffset += relWidth;
            }

            return this.column + nodeOffset;
        },

    },
    mounted() {
        //console.info('FamilyRelations', this.relations);
    }
};
</script>
