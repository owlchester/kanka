<template>
    <div class="box-comment">
        <span class="text-right pull-right">
            <dropdown tag="a" menu-right class="message-options" v-if="message.can_delete">
                <a class="dropdown-toggle" role="button"><span class="caret"></span></a>
                <template slot="dropdown">
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
            <span class="pull-right text-muted">{{ message.created_at }}</span>
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
            }
        }
    }
</script>