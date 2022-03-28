<template>
    <div class="box-comments" ref="messagebox">
        <div class="load-more" v-if="previous && !loadingPrevious" v-on:click="getPrevious">
            {{ translate('load_previous') }}
        </div>
        <div class="load more text-center" v-if="loadingPrevious">
            <i class="fa fa-spin fa-spinner"></i>
        </div>
        <div class="load more text-center" v-if="initializing">
            <i class="fa fa-spin fa-spinner fa-4x"></i>
        </div>
        <conversation-message
            v-for="message in messages"
            :key="message.id"
            :message="message"
            :trans="trans"
            >
        </conversation-message>

        <div v-if="sending" class="text-center">
            <i class="fa fa-spin fa-spinner"></i>
        </div>
    </div>
</template>

<script>
    import Event from '../event.js';

    /**
     * The core of the convo module. This is where the magic happens.
     * Events are fired from Message (delete) and Form (sending)
     */
    export default {
        props: [
            'api',
            'trans'
        ],
        data() {
            return {
                // Our messages to be displayed
                messages: [],
                // Show a small spinner below the messages
                sending: false,
                // Not sure as of right now
                scrolledToBottom: false,
                //
                chatBox: null,
                // The highest message id
                newsest: null,
                // The lowest message id
                previous: false,
                // Show the "load previous" button above messages if there are previous entries on the server
                loadingPrevious: false,
                // Show a spinner while getting the first messages
                initializing: true,
            }
        },
        methods: {
            /**
             * Our main loop to get messages.
             * Using newest we just get what has been added since
             */
            getMessages: function() {
                axios.get(this.api, {params: {newest: this.newest}}).then(response => {
                    this.sending = false;
                    this.messages.push(...response.data.data.messages);
                    this.previous = response.data.data.previous;
                    this.initializing = false;
                    this.scrollToBottom();
                });
            },
            /**
             * When a new message comes, we want to scroll to the bottom of the messages
             */
            scrollToBottom: function() {
                setTimeout(() => {
                    let messageBox = this.$refs.messagebox;
                    messageBox.scrollTop = messageBox.scrollHeight;
                }, 50);

                if(this.messages.length > 0)
                    this.newest = this.messages[this.messages.length - 1].id;
                else
                    this.newest = undefined;
            },
            /**
             * Load previous messages that are on the server but not in memory.
             * This might need some optimizing in the future for large datasets.
             */
            getPrevious: function() {
                this.loadingPrevious = true;
                axios.get(this.api, {params: {oldest: this.messages[0].id}}).then(response => {
                    this.messages.unshift(...response.data.data.messages);
                    this.previous = response.data.data.previous;
                    this.loadingPrevious = false;
                });
            },
            /**
             * Delete a message from the dataset. This sends a delete request to the api and
             * splices the message out of the dataset.
             * @param message
             */
            deleteMessage: function(message) {
                axios.delete(message.delete_url)
                .then(() => {
                    let index = this.messages.findIndex(msg => msg.id === message.id);
                    this.messages.splice(index, 1);
                });
            },
            translate(key) {
                return this.trans[key] ?? 'unknown';
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

            Event.$on('edited_message', (message) => {
                let index = this.messages.findIndex(msg => msg.id === message.id);
                this.messages[index] = message;
            });

            Event.$on('delete_message', (message, body) => {
                this.deleteMessage(message, body);
            });

        }
    }
</script>
