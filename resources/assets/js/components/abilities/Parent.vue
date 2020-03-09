

<template>
    <div class="col-md-4 text-center">
        <div class="ability-parent"
             v-bind:style="{ backgroundImage: 'url(' + ability.image + ')' }"
             v-on:click="click(ability)"
             v-bind:class="{ active: active }"
        >
            <div class="ability-name">
                {{ ability.name }}
            </div>
        </div>
    </div>
</template>

<script>
    import Event from '../event.js';

    export default {
        props: [
            'ability'
        ],

        data() {
            return {
                active: false,
            };
        },

        methods: {
            click: function(ability) {
                Event.$emit('click_parent', this.active ? null : ability);
            },
        },

        mounted() {
            Event.$on('click_parent', (ab) => {
                this.active = ab && ab.id === this.ability.id;
            });
        }
    }
</script>
