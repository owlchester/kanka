<template>
    <div
        class="family-tree-line family-tree-child-parent-line family-tree-line-vertical absolute"
        v-bind:style="vertical()"
        v-bind:data-row="row"
        v-bind:data-col="column" />
</template>

<script>

export default {
    props: {
        sourceX: 0,
        sourceY: 0,
        index: 0,
        column: undefined,
        row: undefined,
        node: '',
    },

    data() {
        return {
            height: 20,
        }
    },

    methods: {
        vertical() {
            let top =  this.sourceY - 35;
            let left = this.sourceX - 10;

            return 'width: 1px; height: ' + this.height + 'px;' +
                'left: ' + left + 'px; ' +
                'top: ' + top + 'px;' +
                'background-color:' + this.node.colour + ';'
            ;
        },
    },
};
</script>
