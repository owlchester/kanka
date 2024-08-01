<template>

</template>

<script>
    /**
     * The core of the convo module. This is where the magic happens.
     * Events are fired from Message (delete) and Form (sending)
     */
    export default {
        props: [
            'api',
            'trans',
            'sending_message',
            'edited_message',
            'send_message'
        ],
        components: {
            Message,
        },
        data() {
            return {
                // Our messages to be displayed

            }
        },
        methods: {
            /**
             * Our main loop to get messages.
             * Using newest we just get what has been added since
             */

        },
        mounted() {
            this.getMessages();
        }
    }
</script>
