<template>
  <div class="viewport box-conversation">
    <Messages :api="api" :trans="json_trans"> </Messages>
    <Form
      :api="send"
      :target="target"
      :targets="targets"
      :disabled="disabled"
      :trans="json_trans"
    >
    </Form>
  </div>
</template>

<script>
import Messages from './Messages.vue';
import Form from './Form.vue';
/**
 * This is just a placeholder that builds the convo module.
 * All the juicy stuff is in Messages
 */
export default {
    props: {
        id: undefined,
        send: undefined,
        target: undefined,
        api: undefined,
        targets: undefined,
        trans: undefined,
        disabled: {
            type: Boolean
        }
    },

    components: {
        Form,
        Messages,
    },

    data() {
        return {
            json_trans: []
        }
    },

    mounted() {
        this.json_trans = JSON.parse(this.trans);
    }
};
</script>
