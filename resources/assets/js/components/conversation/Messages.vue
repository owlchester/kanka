<template>
    <div class="box-comments">
        <conversation-message
            v-for="message in messages"
            :key="message.id"
            :message="message"
            >
        </conversation-message>
    </div>
</template>

<script>
    import Event from '../event.js';

    export default {
        props: ['api'],
        data() {
            return {
                messages: [],
                sending: false
            }
        },
        methods: {
            getMessages: function() {
                axios.get(this.api).then(response => {
                    this.messages = response.data.data.messages;
                });
            }
        },
        mounted() {

            console.log('mounted convo-messages', this.api);

            this.getMessages();

            Event.$on('sending_message', () => {
                this.sending = true;
            });

            Event.$on('sent_message', () => {
                this.getMessages();
            })
        }
    }
</script>