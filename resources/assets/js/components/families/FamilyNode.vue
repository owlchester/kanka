<template>

    <ChildrenLine
        v-if="drawChildrenLine()"
        :originX="lineX"
        :originY="sourceY"
        :targetX="drawX"
        :column="column"
        :row="row"
    ></ChildrenLine>

    <FamilyEntity
        :entity="entity(node.entity_id)"
        :uuid="node.uuid"
        :drawX="drawX"
        :drawY="drawY"
        :column="column"
        :row="row"
        :isEditing="isEditing"
        :node="node"
        :isFounder="isFirst"
    ></FamilyEntity>

    <FamilyRelations v-if="hasRelations()"
        :relations="node.relations"
        :entities="entities"

        :sourceX="sourceX"
        :sourceY="sourceY"
        :drawX="drawX"
        :drawY="drawY"

        :sourceColumn="sourceColumn"
        :sourceRow="sourceRow"
        :column="column"
        :row="row"

        :isEditing="isEditing"
    >
    </FamilyRelations>
</template>

<script>

export default {
    props: {
        node: undefined,
        entities: undefined,

        sourceColumn: 0,
        sourceRow: 0,
        column: 0,
        row: 0,

        sourceX: 0,
        sourceY: 0,
        drawX: 0,
        drawY: 0,

        drawLine: false,
        lineX: 0,
        isEditing: undefined,
        isFirst: false,
        offset: undefined,
    },

    methods: {
        drawChildrenLine() {
            return this.drawLine;
        },
        entity(id) {
            //console.log(this.entities[id]);
            return this.entities[id];
        },
        hasRelations() {
            return this.node.relations && this.node.relations.length > 0;
        },
    }
};
</script>
