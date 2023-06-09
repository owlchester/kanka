

<template>
    <div class="ability-parent cover-background rounded overflow-hidden w-48 h-20"
         v-bind:style="backgroundImage"
         v-on:click="click(ability)"
         v-bind:class="{ active: active, without: !ability.has_image }"
    >
        <div class="ability-name flex justify-center h-full w-full items-center cursor-pointer bg-white/70 hover:bg-black/10 transition-all duration-500 ">
            <div class="name text-2xl">
                {{ ability.name }}
            </div>
        </div>
    </div>
</template>

<script>
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
                this.emitter.emit('click_parent', this.active ? null : ability);
            },
        },

        mounted() {
            this.emitter.on('click_parent', (ab) => {
                this.active = ab && ab.id === this.ability.id;
            });
        }
    }
</script>
