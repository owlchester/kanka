<template>
    <on-click-outside :do="handleClickOutside">
      <div class="relative mx-auto">
        <div role="button" class="inline-block select-none" @click="open = !open">
          <slot name="link"></slot>
        </div>
        <div class="absolute pin-l mt-px" v-show="open">
          <slot name="dropdown"></slot>
        </div>
      </div>
    </on-click-outside>
</template>

<script>
    import OnClickOutside from "./OnClickOutside.vue";

    export default {
        components: {
            OnClickOutside
        },

        /*
         * The component's data.
         */
        data() {
            return {
                open: false
            };
        },
        methods: {
            handleClickOutside() {
                if (this.open) {
                    this.open = false;
                }
            }
        }
    }
</script>