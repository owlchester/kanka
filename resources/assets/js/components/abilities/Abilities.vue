<template>
    <div class="viewport box-abilities">
        <div v-if="loading" class="load more text-center">
            <i class="fa fa-spin fa-spinner"></i>
        </div>

        <div class="row">
            <parent v-for="parent in parents"
                :key="parent.id"
                :ability="parent">
            </parent>
        </div>

        <div v-if="show_parent">
            <ability v-for="ability in parent.abilities"
                :key="ability.id"
                :ability="ability"
                :permission="permission">
            </ability>
        </div>

        <ability v-for="ability in abilities"
                 :key="ability.id"
                 :ability="ability"
                 :permission="permission">
        </ability>
    </div>
</template>


<script>
    import Event from '../event.js';

    export default {
        props: [
            'id',
            'api',
            'permission',
        ],

        data() {
            return {
                abilities: [],
                parents: [],
                loading: true,
                show_parent: false,
                parent: null,
            }
        },

        methods: {
            getAbilities: function() {
                axios.get(this.api).then(response => {
                    this.abilities = response.data.data.abilities;
                    this.parents = response.data.data.parents;
                    this.loading = false;
                });
            },
            showParent: function (parent) {
                this.show_parent = !!parent;
            }
        },

        mounted() {
            this.getAbilities();

            Event.$on('click_parent', (parent) => {
                this.parent = parent;
                this.showParent(parent);
            });
        }
    }
</script>
