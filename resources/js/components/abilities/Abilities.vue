<template>
    <div class="viewport box-abilities relative flex flex-col gap-5">
        <div v-if="loading" class="load more text-center">
            <i class="fa-solid fa-spin fa-spinner" aria-hidden="true"></i>
        </div>

        <div class="flex gap-5 flex-wrap">
            <parent v-for="group in groups"
                :key="group.id"
                :group="group"
                 :permission="permission"
                 :meta="meta"
                 :trans="trans">
            </parent>
        </div>
    </div>
</template>


<script>
    import Ability from "./Ability.vue";
    import Parent from "./Parent.vue";
    import AbilityForm from "./AbilityForm.vue";

    export default {
        props: [
            'id',
            'api',
            'permission',
            'trans',
        ],
        components: {
            Ability,
            AbilityForm,
            Parent
        },

        data() {
            return {
                groups: [],
                meta: [],
                loading: true,
                waiting: false,
                modal: false,
                json_trans: [],
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

            /**
             * Add an ability
             */
            addAbility: function() {
                this.emitter.emit('add_ability', this.meta.add_url);
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
            //
            // this.emitter.on('click_parent', (parent) => {
            //     this.parent = parent;
            //     this.showParent(parent);
            // });

            this.emitter.on('delete_ability', (ability) => {
                this.deleteAbility(ability);
            });
            this.json_trans = JSON.parse(this.trans);
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
