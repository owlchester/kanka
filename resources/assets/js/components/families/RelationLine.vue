<template>
    <div class="family-tree-line absolute" v-bind:style="verticalSource()"></div>
    <div class="family-tree-line absolute" v-bind:style="horizontal()"></div>
    <div class="family-tree-line absolute" v-bind:style="verticalTarget()"></div>
    <div class="family-tree-relation text-center overflow-clip absolute" v-bind:style="relationBox()">
        <a v-if="isEditing" v-on:click="editRelation(uuid, relation)" class="cursor-pointer" v-bind:title="i18n('relation', 'edit')">
            {{ relationText() }}
            <i class="fa-solid fa-pencil" aria-hidden="true">
                <span class="sr-only">{{ i18n('relation', 'edit') }}</span>
            </i>
        </a>
        <span v-else>{{ relationText() }}</span>
        <br />

        <a v-if="isEditing" v-on:click="addChild(uuid)" class="cursor-pointer" v-bind:title="i18n('entity', 'child')">
            <i class="fa-solid fa-baby" aria-hidden="true"></i>
            <i class="fa-solid fa-plus" aria-hidden="true"></i>
            <span class="sr-only">{{ i18n('entity', 'child') }}</span>
        </a>
    </div>
</template>

<script>

export default {
    props: {
        relation: '',
        uuid: undefined,
        sourceX: 0,
        sourceY: 0,
        drawX: 0,
        drawY: 0,
        isEditing: false,

        /*node: undefined,
        isRelation: false,*/
    },

    data() {
        return {
            height: 15,
        }
    },

    methods: {
        verticalSource() {
            return 'width: 1px; height: ' + this.height + 'px;' +
                'left: ' + (this.sourceX + (this.entityWidth / 2)) + 'px; ' +
                'top: ' + (this.sourceY + (this.entityHeight)) + 'px;'
            ;
        },
        verticalTarget() {
            return 'width: 1px; height: ' + this.height + 'px;' +
                'left: ' + (this.drawX + (this.entityWidth / 2)) + 'px; ' +
                'top: ' + (this.drawY + (this.entityHeight)) + 'px; '
            ;
        },
        horizontal() {
            return 'height: 1px;' +
                'left: ' + (this.sourceX + (this.entityWidth / 2)) + 'px; ' +
                'width: ' + (this.drawX - this.sourceX) + 'px; ' +
                'top: ' + (this.drawY + this.entityHeight + 15) + 'px'
            ;
        },
        relationBox() {
            return 'height: 10px;' +
                'left: ' + (this.drawX - (this.entityWidth / 2 + 20)) + 'px; ' +
                'width: ' + (this.entityWidth + 20) + 'px; ' +
                'top: ' + (this.drawY + 57) + 'px'
                ;
        },
        relationText() {
            return this.relation ? this.relation : window.ftTexts.unknown;
        },
        editRelation(uuid, relation) {
            this.emitter.emit('editRelation', {uuid: uuid, relation: relation});
        },
        addChild(uuid) {
            this.emitter.emit('addChild', uuid);
        },
        i18n(group, action) {
            return window.ftTexts.modals[group][action].title
        },
    },
};
</script>
