<template>
    <div class="box-comments" ref="messagebox">
        <div class="load-more" v-if="previous && !loadingPrevious" v-on:click="getPrevious">
            {{ $t('conversations.messages.load_previous') }}
        </div>
        <div class="load more text-center" v-if="loadingPrevious">
            <i class="fa fa-spin fa-spinner"></i>
        </div>
        <conversation-message
            v-for="message in messages"
            :key="message.id"
            :message="message"
            >
        </conversation-message>

        <div v-if="sending" class="text-center">
            <i class="fa fa-spin fa-spinner"></i>
        </div>
    </div>
</template>

<script>
    import Event from '../event.js';

    export default {
        props: ['api'],
        data() {
            return {
                messages: [],
                sending: false,
                scrolledToBottom: false,
                chatBox: null,
                newsest: null,
                previous: false,
                loadingPrevious: false,
            }
        },
        methods: {
            getMessages: function() {
                axios.get(this.api, {params: {newest: this.newest}}).then(response => {
                    this.sending = false;
                    this.messages.push(...response.data.data.messages);
                    this.previous = response.data.data.previous;
                    this.scrollToBottom();
                });
            },
            scrollToBottom: function() {
                setTimeout(() => {
                    let messageBox = this.$refs.messagebox;
                    messageBox.scrollTop = messageBox.scrollHeight;
                }, 50);

                this.newest = this.messages[this.messages.length - 1].id;
            },
            getPrevious: function() {
                this.loadingPrevious = true;
                axios.get(this.api, {params: {oldest: this.messages[0].id}}).then(response => {
                    this.messages.unshift(...response.data.data.messages);
                    this.previous = response.data.data.previous;
                    this.loadingPrevious = false;
                });
            },
            deleteMessage: function(message) {
                console.log(',essage t deoetel', message);
                axios.delete(message.delete_url)
                .then(() => {
                    let index = this.messages.findIndex(msg => msg.id === message.id);
                    this.messages.splice(index, 1);
                });
                // this.messages.forEach((msg) => {
                //     if (msg.id === message.id) {
                //         msg.delete();
                //     }
                // });
            }
        },
        mounted() {

            this.getMessages();

            Event.$on('sending_message', () => {
                this.sending = true;
            });

            Event.$on('sent_message', () => {
                this.getMessages();
            });

            Event.$on('delete_message', (message) => {
                this.deleteMessage(message);
            });

        }
    }
</script>