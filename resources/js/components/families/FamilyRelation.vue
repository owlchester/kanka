<template>
    <FamilyEntity
        :entity="entity(relation.entity_id)"
        :uuid="relation.uuid"
        :drawX="drawX"
        :drawY="drawY"

        :column="column"
        :row="row"

        :isRelation="true"
        :isEditing="isEditing"
        :node="relation"
    >
    </FamilyEntity>

    <RelationLine
        :drawX="drawX"
        :drawY="drawY"
        :sourceX="sourceX"
        :sourceY="sourceY"

        :column="column"
        :row="row"
        :sourceColumn="sourceColumn"
        :sourceRow="sourceRow"

        :relation="relationText()"
        :uuid="relation.uuid"
        :isEditing="isEditing"
    ></RelationLine>


    <FamilyChildren
        v-if="hasChildren()"
        :children="relation.children"
        :entities="entities"

        :sourceX="sourceX"
        :sourceY="sourceY"
        :drawX="nextX(index)"
        :drawY="startY()"
        :startX="sourceX"
        :startY="startY()"

        :sourceColumn="sourceColumn"
        :sourceRow="sourceRow"
        :column="nextCol(index)"
        :row="startRow()"
        :startColumn="sourceColumn"
        :startRow="startRow()"

        :index="index"
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

        sourceColumn: 0,
        sourceRow: 0,
        column: 0,
        row: 0,

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
        nextCol(index) {
            return index === 0 ? this.sourceColumn : this.column;
        },
        startRow() {
            return this.sourceRow + 1;
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
