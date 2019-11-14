<template>
    <div class="box-comment">
        <span class="text-right pull-right">
            <dropdown tag="a" menu-right class="message-options" v-if="message.can_delete">
                <a class="dropdown-toggle" role="button"><span class="caret"></span></a>
                <template slot="dropdown">
                  <li><a role="button" v-on:click="editMessage(message)">{{ $t('crud.edit') }}</a></li>
                  <li><a role="button" v-on:click="deleteMessage(message)">{{ $t('crud.remove') }}</a></li>
                </template>
            </dropdown><br />
        </span>

        <strong class="user" v-if="isUser">{{ message.user }}</strong>
        <strong class="character" v-else-if="isCharacter">
            <span>{{ message.character }}</span>
        </strong>
        <strong class="unknown" v-else>
            {{ $t('crud.users.unknown') }}
        </strong>
        <div class="comment-text">
            {{ message.message }}
            <span class="pull-right text-muted">
                <em v-if="message.is_updated" v-bind:title="message.updated_at">{{ $t('conversations.messages.is_updated') }},</em> {{ message.created_at }}
            </span>
        </div>
    </div>
</template>

<script>
    import Event from '../event.js';

    /**
     * Don't do any of the heavy lifting here, just send some events to Messages for figuring stuff out
     */
    export default {
        props: [
            'message'
        ],

        computed: {
            isUser: function() {
                return this.message.user !== null;
            },
            isCharacter: function() {
                return this.message.character !== null;
            },
        },

        methods: {
            deleteMessage: function(message) {
                Event.$emit('delete_message', message);
            },
            editMessage: function(message) {
                Event.$emit('edit_message', message);
            }
        },
    }
</script>