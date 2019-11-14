<template>
    <div class="viewport box-conversation">
        <conversation-messages
            :api="api">
        </conversation-messages>
        <conversation-form
            :api="send"
            :target="target"
            :targets="targets">
        </conversation-form>
    </div>
</template>


<script>
    /**
     * This is just a placeholder that builds the convo module.
     * All the juicy stuff is in Messages
     */
    export default {
        props: [
            'id',
            'api',
            'target',
            'targets',
            'send'
        ],

        mounted() {

        }
    }
</script>