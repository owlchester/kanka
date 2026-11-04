<template>
  <div class="viewport box-conversation p-2 flex flex-col gap-2">
    <div class="flex flex-col gap-2 box-comments overflow-auto" ref="messageBox">
      <div class="load-more cursor-pointer text-center hover:text-primary" v-if="previous && !loadingPrevious" v-on:click="getPrevious">
        {{ translate('load_previous') }}
      </div>
      <div class="load-more text-center text-2xl" v-if="loadingPrevious || initializing">
        <i class="fa-solid fa-spin fa-spinner" aria-label="Loading"></i>
      </div>
      <div v-if="error" class="text-error-content text-center" role="alert">{{ error }}</div>
      <Message
          v-for="message in messages"
          :key="message.id"
          :message="message"
          :trans="json_trans"
          @delete_message="deletedMessage"
          @edit_message="editMessage"

      >
      </Message>

      <div v-if="sending" class="text-center">
        <i class="fa-solid fa-spin fa-spinner"></i>
      </div>
    </div>

    <Form
        :api="send"
        :target="target"
        :targets="targets"
        :disabled="disabled"
        :trans="json_trans"
        :current_message="currentMessage"
        @sending_message="sendingMessage"
        @edited_message="editedMessage"
        @sent_message="sentMessage"
        @request_failed="showError"
        @cancel_edit="currentMessage = null"
    >
    </Form>
  </div>
</template>

<script setup lang="ts">
import Message from './Message.vue';
import Form from './Form.vue';
import {nextTick, onMounted, ref} from "vue";
/**
 * This is just a placeholder that builds the convo module.
 * All the juicy stuff is in Messages
 */

const props = defineProps<{
  id: undefined,
  send: undefined,
  target: undefined,
  api: undefined,
  targets: undefined,
  trans: undefined,
  disabled: false
}>()

const json_trans = ref()

const messages = ref([])
// Show a small spinner below the messages
const sending = ref(false)
// The highest message id
const newest = ref(null)
// The lowest message id
const previous = ref(false)
// Show the "load previous" button above messages if there are previous entries on the server
const loadingPrevious = ref(false)
// Show a spinner while getting the first messages
const initializing = ref(true)

const messageBox = ref(null)
const currentMessage = ref(null)
const error = ref('')


const getMessages = () => {
  error.value = '';
  axios.get(props.api, {params: {newest: newest.value}}).then(response => {
    sending.value = false;
    messages.value.push(...response.data.data.messages);
    previous.value = response.data.data.previous;
    initializing.value = false;
    scrollToBottom();
  }).catch(() => {
    sending.value = false;
    initializing.value = false;
    error.value = translate('request_failed');
  });
}
/**
 * When a new message comes, we want to scroll to the bottom of the messages
 */
const scrollToBottom = () => {
  setTimeout(() => {
    messageBox.value.scrollTop = messageBox.value.scrollHeight;
  }, 50);

  if(messages.value.length > 0)
    newest.value = messages.value[messages.value.length - 1].id;
  else
    newest.value = undefined;
}
/**
 * Load previous messages that are on the server but not in memory.
 * This might need some optimizing in the future for large datasets.
 */
const getPrevious = () => {
  if (loadingPrevious.value || messages.value.length === 0) return;
  loadingPrevious.value = true;
  const oldHeight = messageBox.value.scrollHeight;
  axios.get(props.api, {params: {oldest: messages.value[0].id}}).then(response => {
    messages.value.unshift(...response.data.data.messages);
    previous.value = response.data.data.previous;
    nextTick(() => {
      messageBox.value.scrollTop += messageBox.value.scrollHeight - oldHeight;
    });
  }).catch(() => {
    error.value = translate('request_failed');
  }).finally(() => {
    loadingPrevious.value = false;
  });
}
/**
 * Delete a message from the dataset. This sends a delete request to the api and
 * splices the message out of the dataset.
 * @param message
 */
const deleteMessage = (message) => {
  error.value = '';
  axios.delete(message.delete_url)
      .then(() => {
        const index = messages.value.findIndex(msg => msg.id === message.id);
        if (index !== -1) messages.value.splice(index, 1);
      }).catch(() => { error.value = translate('request_failed'); });
}
const translate = (key) => {
  return json_trans.value[key] ?? 'unknown'
}

const sendingMessage = (message) => {
  sending.value = true
}
const editMessage = (message) => {
  currentMessage.value = message
}
const editedMessage = (message) => {
  const index = messages.value.findIndex(msg => msg.id === message.id)
  messages.value[index] = message
}
const sentMessage = (message) => {
  currentMessage.value = null
  getMessages()
}
const deletedMessage = (message) => {
    deleteMessage(message)
}
const showError = () => { error.value = translate('request_failed'); }


onMounted(() => {
  json_trans.value = JSON.parse(props.trans)
  getMessages()
})
</script>
