<template>
    <FamilyEntity
        :entity="this.entity(this.node.entity_id)"
        :drawX="this.drawX"
        :drawY="this.drawY"
    ></FamilyEntity>

    <FamilyRelations v-if="hasRelations()"
        :relations="node.relations"
        :entities="entities"
        :sourceX="sourceX"
        :sourceY="sourceY"
        :drawX="drawX"
        :drawY="drawY"
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
        drawY: 0
    },

    methods: {
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
