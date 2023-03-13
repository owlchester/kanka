<template>
    <div class="family-tree-line absolute" v-bind:style="verticalSource()"></div>
    <div class="family-tree-line absolute" v-bind:style="horizontal()"></div>
    <div class="family-tree-line absolute" v-bind:style="verticalTarget()"></div>
    <div class="family-tree-relation text-center overflow-clip absolute" v-bind:style="relationBox()">
        <a v-if="isEditing" v-on:click="editRelation(uuid, relation)" class="cursor-pointer">
            {{ relationText() }}
            <i class="fa-solid fa-pencil" aria-hidden="true">
                <span class="sr-only">Edit relation</span>
            </i>
        </a>
        <span v-else>{{ relationText() }}</span>
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
                'left: ' + (this.sourceX + 100) + 'px; ' +
                'top: ' + (this.sourceY + 60) + 'px;'
            ;
        },
        verticalTarget() {
            return 'width: 1px; height: ' + this.height + 'px;' +
                'left: ' + (this.drawX + 100) + 'px; ' +
                'top: ' + (this.drawY + 60) + 'px; '
            ;
        },
        horizontal() {
            return 'height: 1px;' +
                'left: ' + (this.sourceX + 100) + 'px; ' +
                'width: ' + (this.drawX - this.sourceX) + 'px; ' +
                'top: ' + (this.drawY + 75) + 'px'
            ;
        },
        relationBox() {
            return 'height: 10px;' +
                'left: ' + (this.drawX - 120) + 'px; ' +
                'width: ' + 220 + 'px; ' +
                'top: ' + (this.drawY + 60) + 'px'
                ;
        },
        relationText() {
            return this.relation;
        },
        editRelation(uuid, relation) {
            this.emitter.emit('editRelation', {uuid: uuid, relation: relation});
        },
    },
};
</script>
