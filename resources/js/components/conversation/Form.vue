<template>
    <div :class="boxClass()" v-if="commentable">
        <div class="flex items-center gap-2">
            <div class="max-w-xs" v-if="targetCharacter">
                <select class="w-full" v-model="character_id">
                    <option v-for="(name, key) in targets" :value="key" :key="key">
                        {{ name }}
                    </option>
                </select>
            </div>
            <div class="field grow">
                <input
                        type="text"
                        id="message"
                        maxlength="1000"
                        autocomplete="off"
                        class="w-full"
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
            current_message: {
              type: Object,
              default: null
            },
            trans: undefined
        },
        emits: [
            'sending_message',
            'edited_message',
            'sent_message'
        ],

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
                this.character_id = message.from_id;
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
                this.$emit('sending_message');

                let url = this.api;
                let data = {
                    message: this.body.trim(),
                };
                if (this.targetCharacter) {
                    data.character_id = this.character_id;
                }
                if (this.message_id) {
                    url += '/' + this.message_id;

                    axios.put(url, data).then((res) => {
                        this.$emit('edited_message', res.data.data);
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
                this.$emit('sent_message');
            },

            translate(key) {
                return this.json_trans[key] ?? 'unknown';
            },
            boxClass() {
              let bg = 'bg-base-100';
              if (this.current_message) {
                bg = 'bg-accent';
              }
              return 'rounded p-2 ' + bg;
            }
        },

        computed: {
            targetCharacter: function() {
                return this.target === 'character';
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

        watch: {
          current_message: {
              handler(newValue, oldValue) {
                if (newValue !== oldValue && newValue) {
                  this.editMessage(newValue)
                }
              }
            }
        }
    }
</script>
