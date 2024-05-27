<template>
    <div class="viewport box-abilities relative flex flex-col gap-5">
        <div v-if="loading" class="load more text-center text-2xl">
            <i class="fa-solid fa-spin fa-spinner" aria-hidden="true"></i>
        </div>

        <div class="flex gap-5 flex-wrap">
            <parent v-for="group in groups"
                :key="group.id"
                :group="group"
                :permission="permission"
                :meta="meta">
            </parent>
        </div>
    </div>
</template>


<script>
    import Parent from "./Parent.vue";

    export default {
        props: [
            'id',
            'api',
            'permission',
        ],
        components: {
            Parent
        },

        data() {
            return {
                groups: [],
                meta: [],
                loading: true,
                waiting: false,
            }
        },

        methods: {
            getAbilities: function() {
                fetch(this.api)
                    .then(response => response.json())
                    .then(response => {
                        this.groups = response.data.groups;
                        this.meta = response.data.meta;
                        this.loading = false;
                        this.waiting = false;
                        });
            },
        },

        mounted() {
            this.getAbilities();
        },

        updated() {
            // Add the ajax tooltip listener when the dom is updated (for example when displaying
            // children abilities)
            window.ajaxTooltip();
        }
    }
</script>
<script setup>
</script>
