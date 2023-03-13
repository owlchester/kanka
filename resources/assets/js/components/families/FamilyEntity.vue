<template>
    <div class="family-node-entity rounded-2xl px-5 py-2 absolute inline-block" v-bind:style="position()">
        <div class="flex items-center gap-1">
            <div class="grow justify-center">
                <a v-bind:href="entity.url" class="block">
                    {{ entity.name }}
                </a>
                <div class="flex gap-1" v-if="isEditing">
                    <a v-on:click="editEntity(uuid)" class="cursor-pointer">
                        <i class="fa-solid fa-pencil" aria-hidden="true"></i>
                        <span class="sr-only">Edit</span>
                    </a>
                    <a v-if="!isRelation" v-on:click="addRelation(uuid)" class="grow cursor-pointer">
                        <i class="fa-solid fa-user-plus" aria-hidden="true"></i>
                        <span class="sr-only">Add Relation</span>
                    </a>
                    <a v-else class="grow cursor-pointer" v-on:click="addChild(uuid)">
                        <i class="fa-solid fa-baby" aria-hidden="true"></i>
                        <span class="sr-only">Add child</span>
                    </a>
                    <a v-on:click="deleteEntity(uuid)" class="align-end cursor-pointer">
                        <i class="fa-solid fa-trash" aria-hidden="true"></i>
                        <span class="sr-only">Delete</span>
                    </a>
                </div>
            </div>
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
        uuid: undefined,
        drawX: 0,
        drawY: 0,
        isRelation: false,
        isEditing: undefined,
    },

    methods: {
        position() {
            return 'left: ' + this.drawX + 'px; top: ' + this.drawY + 'px';
        },
        editEntity(uuid) {
            this.emitter.emit('editEntity', uuid);
        },
        deleteEntity(uuid) {
            this.emitter.emit('deleteEntity', uuid);
        },
        addRelation(uuid) {
            this.emitter.emit('addRelation', uuid);
        },
        addChild(uuid) {
            this.emitter.emit('addChild', uuid);
        },
    },

    mounted() {
        //console.log('entity', this.entity);
    }
};
</script>
