<template>
    <div class="flex w-full gap-1 mb-5 justify-end" v-if="!isLoading">
        <button class="btn btn-sm btn-warning" v-if="!isEditing" v-on:click="startEditing()">
            <i class="fa-solid fa-edit" aria-hidden="true"></i>
            Edit
        </button>
        <button class="btn btn-sm btn-default" v-if="isEditing" v-on:click="reset()">
            <i class="fa-solid fa-redo" aria-hidden="true"></i>
            Reset
        </button>
        <button class="btn btn-sm btn-default" v-if="isEditing" v-on:click="clear()">
            <i class="fa-solid fa-eraser" aria-hidden="true"></i>
            Clear
        </button>
        <button class="btn btn-sm btn-primary" v-if="isEditing" v-on:click="save()">
            <i class="fa-solid fa-save" aria-hidden="true"></i>
            Save
        </button>
    </div>
    <div class="family-tree relative">
        <div class="text-center px-5" v-if="isLoading">
            <i class="fa-solid fa-spinner fa-spin fa-2x" aria-hidden="true"></i>
            <span class="sr-only">Loading...</span>
        </div>
        <div v-else>
            <FamilyNode v-for="node in nodes"
                        :node="node"
                        :entities="entities"
                        :sourceX="0"
                        :sourceY="0"
                        :drawX="0"
                        :drawY="0"
                        :isEditing="isEditing"
            >
            </FamilyNode>
        </div>
    </div>
</template>

<script>
import FamilyNode from './FamilyNode.vue';

export default {
    props: {
        api: undefined,
        save: undefined,
        entity: undefined,
    },
    components: {
        FamilyNode,
    },

    data() {
        return {
            nodes: [],
            entities: [],
            isEditing: false,
            isLoading: true,
        }
    },

    methods: {
        startEditing() {
            this.isEditing = true;
        },
        reset() {
            this.isEditing = false;
        },
        save() {
            alert('save');
        },
        clear() {
            alert('clear');
        },
    },

    mounted() {
        axios.get(this.api).then((resp) => {
            this.nodes = resp.data.nodes;
            this.entities = resp.data.entities;
            this.isLoading = false;
        });
    },
};
</script>
