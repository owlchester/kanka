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
            <div v-if="parent.entry" class="box box-solid">
                <div class="box-header">
                    <span class="box-title">
                        {{ parent.name }}
                    </span>
                </div>
                <div class="box-body" v-html="parent.entry">

                </div>
            </div>
            <ability v-for="ability in parent.abilities"
                :key="ability.id"
                :ability="ability"
                :permission="permission"
                :meta="meta"
                :trans="json_trans">
            </ability>
        </div>

        <ability v-if="!show_parent" v-for="ability in abilities"
                 :key="ability.id"
                 :ability="ability"
                 :permission="permission"
                 :meta="meta"
                 :trans="json_trans">
        </ability>

        <ability_form :trans="json_trans">
        </ability_form>

        <div v-if="waiting" class="box-waiting">
            <i class="fa fa-spin fa-spinner fa-4x"></i>
        </div>
    </div>
</template>


<script>
    import Event from '../event.js';

    export default {
        props: [
            'id',
            'api',
            'permission',
            'trans',
        ],

        data() {
            return {
                abilities: [],
                parents: [],
                meta: [],
                loading: true,
                show_parent: false,
                parent: null,
                waiting: false,
                modal: false,
                json_trans: [],
            }
        },

        methods: {
            getAbilities: function() {
                axios.get(this.api).then(response => {
                    this.abilities = response.data.data.abilities;
                    this.parents = response.data.data.parents;
                    this.meta = response.data.data.meta;
                    this.loading = false;
                    this.waiting = false;


                    if (this.parent) {
                        // We need to find our parent again to "reload" it properly
                        this.parent = this.parents[this.parent.id];
                        this.showParent(this.parent);
                    }
                });
            },
            //
            showParent: function (parent) {
                this.show_parent = !!parent;
            },

            /**
             * Add an ability
             */
            addAbility: function() {
                Event.$emit('add_ability', this.meta.add_url);
            },

            /**
             * Delete an ability from the dataset. This sends a delete request to the api and
             * splices the message out of the dataset.
             * @param ability
             */
            deleteAbility: function(ability) {
                this.waiting = true;
                axios.delete(ability.actions.delete)
                    .then(() => {
                        this.getAbilities();
                    })
                    .catch(() => {
                        // Ability might have been deleted by someone else
                        this.getAbilities();
                    });
            },

            translate(key) {
                return this.json_trans[key] ?? 'unknown';
            }
        },

        mounted() {
            this.getAbilities();

            Event.$on('click_parent', (parent) => {
                this.parent = parent;
                this.showParent(parent);
            });

            Event.$on('delete_ability', (ability) => {
                this.deleteAbility(ability);
            });
            this.json_trans = JSON.parse(this.trans);

        }
    }
</script>
