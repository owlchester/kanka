<template>
    <div class="box-footer" v-if="commentable">
        <div class="row">
            <div class="col-md-3" v-if="targetCharacter">
                <select class="form-control" v-model="character_id">
                    <option v-for="(name, key) in targets" :value="key">
                        {{ name }}
                    </option>
                </select>
            </div>
            <div v-bind:class="inputForm">
                <input
                        type="text"
                        id="message"
                        maxlength="1000"
                        autocomplete="off"
                        class="form-control"
                        @keydown="typing"
                        v-model="body"
                        v-bind:disabled="inputFormDisabled"
                />
            </div>
        </div>
    </div>
</template>

<script>
    import Event from '../event.js';

    /**
     * The form to send messages to a conversation.
     * Messy party: we can have a list of characters that the user can edit, or send as the current user.
     */
    export default {
        props: [
            'target',
            'api',
            'targets',
        ],

        data() {
            return {
                body: null,
                sending: false,
                character_id: null
            }
        },
        methods: {
            /**
             * We don't want a "send" button, so listen to the enter key. No multi-line support here.
             * @param e
             */
            typing(e) {
                if (e.keyCode === 13 && !e.shiftKey) {
                    e.preventDefault();
                    this.sendMessage();
                }
            },
            /**
             * Sending a message. This might be better off in Messages to keep all
             * api requests in a single place.
             */
            sendMessage() {
                if (!this.body || this.body.trim() === '') {
                    return;
                }
                if (this.targetCharacter && this.character_id === null) {
                    return;
                }
                this.sending = true;
                Event.$emit('sending_message');

                axios.post(this.api, {
                    message: this.body.trim(),
                    character_id: this.character_id
                }).then(() => {
                    this.sending = false;
                    this.body = null;
                    Event.$emit('sent_message');
                }).catch(() => {
                    this.sending = false;
                });
            },
        },

        computed: {
            targetCharacter: function() {
                console.log('targets', this.targets);
                return this.target === 'character';
            },
            inputForm: function() {
                return this.targetCharacter ? 'col-md-9' : 'col-md-12';
            },
            inputFormDisabled: function() {
                return this.sending;
            },
            commentable: function() {
                if (this.targetCharacter) {
                    return this.targets !== null;
                }
                return true;
            }
        },

        mounted() {
        }
    }
</script>
