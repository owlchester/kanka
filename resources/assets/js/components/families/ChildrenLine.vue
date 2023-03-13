<template>
    <div class="family-tree-line family-tree-child-line family-tree-line-vertical absolute" v-bind:style="vertical()"></div>
    <div class="family-tree-line family-tree-child-line family-tree-line-horizontal absolute" v-bind:style="horizontal()" v-bind:data-ori-x="originX" v-bind:data-tar-x="targetX"></div>
</template>

<script>

export default {
    props: {
        index: 0,
        originX: 0,
        originY: 0,
        targetX: 0,
    },

    data() {
        return {
            height: '15',
            left: 100,
        }
    },

    methods: {
        vertical() {
            return 'width: 1px; height: ' + this.height + 'px;' +
                'left: ' + (this.targetX + this.left) + 'px; ' +
                'top: ' + (this.originY - 15) + 'px;'
            ;
        },
        horizontal() {
            // Calc width based on target to source
            let width = 110;
            let left = this.targetX - 10;

            // Source if further along, we need to "go back" a bit
            if (this.originX > this.targetX) {
                left = this.originX - 120;
            }

            // If we're further than 1 away
            let diff = this.targetX - this.originX;
            if (diff >= 220) {
                //width = 300;
                width = diff + 110;
                left = this.originX - 10; // place it at the beginning
            }

            return 'height: 1px;' +
                'width: ' + (width) + 'px;' +
                'left: ' + left + 'px; ' +
                'top: ' + (this.originY - 15) + 'px; '
            ;
        },
        /*horizontal() {
            return 'height: 1px;' +
                'left: ' + (this.drawX + 100) + 'px; ' +
                'width: ' + 220 + 'px; ' +
                'top: ' + (this.sourceY + 100) + 'px'
            ;
        },*/
    },
};
</script>
