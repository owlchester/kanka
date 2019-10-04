<template>
    <div class="viewport">
        <div class="map" v-bind:style="mapStyle" v-dragscroll>
            <img :src="map" />
        </div>
    </div>
</template>

<script>
    export default {
        props: ['id', 'map', 'api'],

        /*
         * The component's data.
         */
        data() {
            return {
                points: [],
                position: {
                    x: 0,
                    y: 0,
                },
                zoom: 100,
            };
        },

        /**
         * Prepare the component (Vue 2.x).
         */
        mounted() {
            this.prepareComponent();
        },

        methods: {
            /**
             * Prepare the component.
             */
            prepareComponent() {
                console.log('preparing components');
                //this.get();

                // $('#modal-create-client').on('shown.bs.modal', () => {
                //     $('#create-client-name').focus();
                // });
                //
                // $('#modal-edit-client').on('shown.bs.modal', () => {
                //     $('#edit-client-name').focus();
                // });
            },
        },

        computed: {
          mapStyle: function() {
              return {
                  backgroundImage: 'url(' + this.map + ')',
              }
          },
        },
    }
</script>