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
    export default {
        props: [
            'id',
            'api',
            'target',
            'targets',
            'send'
        ],

        mounted() {
            // console.log('mounted conversation', this.api);
        }
    }
</script>