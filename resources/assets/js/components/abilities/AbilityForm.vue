<template>
    <div class="modal fade in" v-bind:style="{display: this.modalStyle()}" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content" v-html="modalContent">
            </div>
        </div>
    </div>
</template>

<script>
    import Event from '../event.js';

    export default {
        props: [
        ],

        data() {
            return {
                modal: false,
                modalContent: ''
            }
        },

        methods: {
            showModal: function(url) {
                this.modal = true;

                axios.get(url).then(response => {
                   this.modalContent = response.data;
                });
            },
            modalStyle: function() {
                return this.modal ? 'block' : 'hidden';
            }
        },

        mounted() {
            Event.$on('add_ability', (url) => {
                this.showModal(url);
            });
        }
    }
</script>
