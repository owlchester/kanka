<template>
  <div class="viewport box-conversation">
    <conversation-messages :api="api" :trans="json_trans"> </conversation-messages>
    <conversation-form
      :api="send"
      :target="target"
      :targets="targets"
      :disabled="disabled"
      :trans="json_trans"
    >
    </conversation-form>
  </div>
</template>

<script>
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
