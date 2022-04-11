<template>
    <div class="box-footer" v-if="commentable">
        <div class="row">
            <div class="col-md-3" v-if="targetCharacter">
                <select class="form-control" v-model="character_id">
                    <option v-for="(name, key) in targets" :value="key" :key="key">
                        {{ name }}
                    </option>
                </select>
            </div>
            <div :class="inputForm">
                <input
                        type="text"
                        id="message"
                        maxlength="1000"
                        autocomplete="off"
                        class="form-control"
                        @keydown="typing"
                        v-model="body"
                        :placeholder=" disabled ? translate('is_closed') : ''"
                        :disabled="(inputFormDisabled || disabled)"
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
        props: {
            target: undefined,
            api: undefined,
            targets: undefined,
            disabled: {
                type: Boolean
            },
            trans: undefined
        },

        data() {
            return {
                body: null,
                sending: false,
                character_id: null,
                message_id: null,
                edit_message: null
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
            editMessage(message) {
                this.message_id = message.id;
                this.edit_message = message;
                this.body = message.message;
                document.getElementById("message").focus();
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

                var url = this.api;
                var data = {
                    message: this.body.trim(),
                };
                if (this.targetCharacter) {
                    data.character_id = this.character_id;
                }
                if (this.message_id) {
                    url += '/' + this.message_id;

                    axios.put(url, data).then((res) => {
                        Event.$emit('edited_message', res.data.data);
                        this.messageHandler();
                    }).catch(() => {
                        this.sending = false;
                    });
                } else {
                    axios.post(url, data).then(() => {
                        this.messageHandler();
                    }).catch(() => {
                        this.sending = false;
                    });
                }
            },
            messageHandler() {
                this.sending = false;
                this.body = null;
                this.message_id = null;
                Event.$emit('sent_message');
            },

            translate(key) {
                return this.json_trans[key] ?? 'unknown';
            }
        },

        computed: {
            targetCharacter: function() {
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
            Event.$on('edit_message', (message, body) => {
                this.editMessage(message, body);
            });
        }
    }
</script>
