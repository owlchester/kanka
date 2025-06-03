<template>
    <div v-bind:class="cssClass('vertical')" v-bind:style="verticalSource()" v-bind:data-row="row" v-bind:data-col="column"></div>
    <div v-bind:class="cssClass('horizontal')" v-bind:style="horizontal()" v-bind:data-row="row" v-bind:data-col="column"></div>
    <div class="family-tree-line family-tree-relation-line family-tree-line-vertical absolute" v-bind:style="verticalTarget()" v-bind:data-row="row" v-bind:data-col="column"></div>
    <div class="family-tree-relation text-center absolute text-sm" v-bind:style="relationBox()" v-bind:data-row="row" v-bind:data-col="column">
        <a v-if="isEditing" v-on:click="editRelation(uuid, relation)" class="cursor-pointer" v-bind:title="i18n('relation', 'edit')">
            <span class="truncate">{{ relationText() }}</span>
            <i class="fa-regular fa-pencil" aria-hidden="true">
                <span class="sr-only">{{ i18n('relation', 'edit') }}</span>
            </i>
        </a>
        <span v-else>{{ relationText() }}</span>
        <br />

        <a v-if="isEditing" v-on:click="addChild(uuid)" class="cursor-pointer" v-bind:title="i18n('entity', 'child')">
            <i class="fa-regular fa-baby" aria-hidden="true"></i>
            <i class="fa-regular fa-plus" aria-hidden="true"></i>
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
        sourceColumn: 0,
        sourceRow: 0,
        column: 0,
        row: 0,
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
        cssClass(type) {
            let css = 'family-tree-line family-tree-relation-line absolute';
            if (type === 'vertical') {
                css += ' family-tree-line-vertical';
            } else if(type === 'horizontal') {
                css += ' family-tree-line-horizontal';
            }
            return css;
        },
        verticalSource() {
            return (this.relation.colour ? '--family-tree-line: ' + this.relation.colour + ';': '') +
                'width: 1px; height: ' + this.height + 'px;' +
                'left: ' + (this.sourceX + (this.entityWidth / 2)) + 'px; ' +
                'top: ' + (this.sourceY + (this.entityHeight)) + 'px;' +
                'background-color:' + this.relation.colour + ';'
            ;
        },
        verticalTarget() {
            return (this.relation.colour ? '--family-tree-line: ' + this.relation.colour + ';': '') +
                'width: 1px; height: ' + this.height + 'px;' +
                'left: ' + (this.drawX + (this.entityWidth / 2)) + 'px; ' +
                'top: ' + (this.drawY + (this.entityHeight)) + 'px; ' +
                'background-color:' + this.relation.colour + ';'
            ;
        },
        horizontal() {
            return (this.relation.colour ? '--family-tree-line: ' + this.relation.colour + ';': '') +
                'height: 1px;' +
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
            return this.relation.role ? this.relation.role : window.ftTexts.unknown;
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
