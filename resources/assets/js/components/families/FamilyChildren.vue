<template>

    <FamilyParentChildrenLine
        :sourceX="getLineX(index)"
        :sourceY="drawY"
        :index="index">
    </FamilyParentChildrenLine>

    <FamilyNode
        v-for="(child, i) in children"
        :node="child"
        :entities="entities"

        :sourceX="this.startX"
        :sourceY="this.startY"
        :drawX="getDrawX(i)"
        :drawY="this.drawY"

        :sourceColumn="startColumn"
        :sourceRow="startRow"
        :column="getColumn(i)"
        :row="row"

        :drawLine="true"
        :lineX="getLineX(index)"
        :isEditing="this.isEditing"
        :offset="getNodeSize(i)"
    >
    </FamilyNode>
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

        sourceColumn: 0,
        sourceRow: 0,
        row: 0,
        column: 0,
        startColumn: 0,
        startRow: 0,

        lineX: 0,
        index: 0,
        isEditing: false,
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
        getLineX(index) {
            if (index === 0) {
                return this.sourceX + this.entityWidth + 20;
            }
            return this.drawX;
        },
        getColumn(index) {
            let x = this.column;
            let offset = this.getNodeSize(index);
            return x + offset;
        },
        getDrawX(index) {
            return this.getRealDrawX(index);
        },
        getRealDrawX(index) {
            let x = this.drawX;
            let offset = this.getNodeSize(index);
            x += offset * (this.entityWidth + 20);
            return x;
        },
        getNodeSize(index) {
            let offset = 0;
            // Get size of previous children
            for (let i = 0; i < index; i++) {
                let node = this.children[i];
                offset += window.familyTreeChildWidth(node, i);
            }
            return offset;
        },
    },
};
</script>
