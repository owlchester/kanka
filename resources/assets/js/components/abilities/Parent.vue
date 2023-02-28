

<template>
    <div class="col-xs-4 col-sm-3 col-lg-3 text-center">
        <div class="ability-parent cover-background rounded overflow-hidden mb-4"
             v-bind:style="backgroundImage"
             v-on:click="click(ability)"
             v-bind:class="{ active: active, without: !ability.has_image }"
        >
            <div class="ability-name flex justify-center h-full w-full items-center cursor-pointer bg-white/70 hover:bg-black/10">
                <div class="name m-auto p-3 text-2xl">
                    {{ ability.name }}
                </div>
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
