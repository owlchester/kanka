<template>
    <FamilyEntity
        :entity="this.entity(relation.entity_id)"
        :uuid="relation.uuid"
        :drawX="this.drawX"
        :drawY="this.drawY"
        :isRelation="true"
        :isEditing="this.isEditing"
        :node="relation"
    >
    </FamilyEntity>

    <RelationLine
        :drawX="this.drawX"
        :drawY="this.drawY"
        :sourceX="this.sourceX"
        :sourceY="this.sourceY"
        :relation="this.relationText()"
        :uuid="relation.uuid"
        :isEditing="this.isEditing"
    ></RelationLine>


    <FamilyChildren
        v-if="hasChildren()"
        :children="relation.children"
        :entities="entities"
        :sourceX="sourceX"
        :sourceY="sourceY"
        :drawX="this.nextX(index)"
        :drawY="this.startY()"
        :index="index"
        :startX="sourceX"
        :startY="this.startY()"
        :lineX="this.lineX()"
        :isEditing="this.isEditing"
    >
    </FamilyChildren>
</template>

<script>

export default {
    props: {
        relation: undefined,
        entities: undefined,
        sourceX: 0,
        sourceY: 0,
        drawX: 0,
        drawY: 0,
        index: 0,
        isEditing: false,
    },
    methods: {
        entity(id) {
            return this.entities[id];
        },
        hasChildren() {
            //console.log('check children', this.relation, this.relation.children && this.relation.children.length > 0);
            return this.relation.children && this.relation.children.length > 0;
        },
        nextX(index) {
            //console.log('next X', index === 0 ? this.sourceX : this.drawX);
            return index === 0 ? this.sourceX : this.drawX;
        },
        startY() {
            return this.sourceY + this.entityHeight + 50;
        },
        lineX() {
            return this.index === 0 ? this.drawX + this.entityWidth + 20 : this.sourceX;
        },
        relationText() {
            return this.relation.role;
        },
    },
    mounted() {
        //console.log('FamilyRelation', this.relation);
        //console.error('FamilyRelation', this.relation.children);
    }
};
</script>
