<template>
    <div class="family-tree-line family-tree-child-parent-line family-tree-line-vertical absolute" v-bind:style="vertical()"></div>
</template>

<script>

export default {
    props: {
        sourceX: 0,
        sourceY: 0,
        index: 0,
    },

    data() {
        return {
            height: 30,
        }
    },

    methods: {
        vertical() {
            let top =  this.sourceY - 45;
            let left = this.sourceX - 10;

            return 'width: 1px; height: ' + this.height + 'px;' +
                'left: ' + left + 'px; ' +
                'top: ' + top + 'px;'
            ;
        },
    },
};
</script>
