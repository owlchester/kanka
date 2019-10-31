<template>
    <div class="box-footer">
        <div class="row">
            <div class="col-md-3" v-if="targetCharacter">
                <select class="form-control" v-model="character_id">
                    <option v-for="character in targets">
                        {{ character.name }}
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

    export default {
        props: [
            'target',
            'api',
            'targets',
        ],

        data() {
            return {
                body: null,
                sending: false
            }
        },
        methods: {
            typing(e) {
                if (e.keyCode === 13 && !e.shiftKey) {
                    e.preventDefault();
                    this.sendMessage();
                }
            },
            sendMessage() {
                if (!this.body || this.body.trim() === '') {
                    return;
                }
                this.sending = true;
                Event.$emit('sending_message');

                console.log('api', this.api);

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
            buildMessage() {
                return {
                    message: this.body,

                }
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
            }
        },

        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
