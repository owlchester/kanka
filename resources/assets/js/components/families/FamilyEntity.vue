<template>
    <div class="family-node-entity rounded-2xl px-5 py-2 absolute inline-block" v-bind:style="position()">
        <div class="flex items-center">
            <a v-bind:href="entity.url" class="grow">
                {{ entity.name }}
            </a>
            <div class="align-end">
                <img v-bind:src="entity.thumb" class="rounded-full entity-image" />
            </div>
        </div>
    </div>
</template>

<script>

export default {
    props: {
        entity: undefined,
        drawX: 0,
        drawY: 0,
        isRelation: false,
        isEditing: undefined,
    },

    methods: {
        position() {
            return 'left: ' + this.drawX + 'px; top: ' + this.drawY + 'px';
        }
    },

    mounted() {
        //console.log('entity', this.entity);
    }
};
</script>
