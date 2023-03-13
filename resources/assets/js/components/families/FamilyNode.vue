<template>

    <ChildrenLine
        v-if="drawChildrenLine()"
        :originX="lineX"
        :originY="sourceY"
        :targetX="drawX"
    ></ChildrenLine>

    <FamilyEntity
        :entity="this.entity(this.node.entity_id)"
        :drawX="this.drawX"
        :drawY="this.drawY"
        :isEditing="this.isEditing"
    ></FamilyEntity>

    <FamilyRelations v-if="hasRelations()"
        :relations="node.relations"
        :entities="entities"
        :sourceX="sourceX"
        :sourceY="sourceY"
        :drawX="drawX"
        :drawY="drawY"
        :isEditing="this.isEditing"
    >
    </FamilyRelations>
</template>

<script>

export default {
    props: {
        node: undefined,
        entities: undefined,
        sourceX: 0,
        sourceY: 0,
        drawX: 0,
        drawY: 0,
        drawLine: false,
        lineX: 0,
        isEditing: undefined,
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
