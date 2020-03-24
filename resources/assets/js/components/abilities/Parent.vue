

<template>
    <div class="col-xs-4 col-sm-3 col-lg-2 text-center">
        <div class="ability-parent"
             v-bind:style="backgroundImage"
             v-on:click="click(ability)"
             v-bind:class="{ active: active, without: !ability.has_image }"
        >
            <div class="ability-name">
                <div class="name">
                    {{ ability.name }}
                </div>
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

        computed: {
            backgroundImage: function() {
                if (this.ability.has_image) {
                    return {
                        backgroundImage: 'url(' + this.ability.image + ')'
                    }
                }
                return {}
            }
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
