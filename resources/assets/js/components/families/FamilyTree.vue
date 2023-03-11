<template>
    <div class="family-tree relative">
        <div class="text-center px-5" v-if="is_loading">
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
            is_loading: true,
        }
    },

    mounted() {
        axios.get(this.api).then((resp) => {
            this.nodes = resp.data.nodes;
            this.entities = resp.data.entities;
            this.is_loading = false;
        });
    },
};
</script>
