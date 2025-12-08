<template>
    <div v-bind:class="boxClasses(message)">
        <div class="flex items-center gap-1" v-if="!message.group">
            <div class="message-author">
                <strong class="user" v-if="isUser">{{ message.user }}</strong>
                <strong class="character" v-else-if="isCharacter">
                    <span>{{ message.character }}</span>
                </strong>
                <strong class="unknown" v-else>
                    {{ translate('user_unknown') }}
                </strong>
            </div>

            <div class="grow">
                <span class="text-xs text-neutral-content" v-if="!message.group">
                    {{ message.created_at }}
                </span>
            </div>

            <div class="message-options" v-if="message.can_delete">
                <div class="" v-click-outside="onClickOutside">
                    <a v-on:click="openDropdown()" role="button" v-if="!this.openedDropdown">
                        <i class="fa-solid fa-caret-down" aria-hidden="true" />
                    </a>
                    <div class="flex gap-1" v-else >
                        <a class="btn2 btn-xs btn-default" v-on:click="editMessage(message)">
                          {{ translate('edit') }}
                        </a>
                        <a class="btn2 btn-xs btn-error" v-on:click="deleteMessage(message)">
                          {{ translate('remove') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>


        <div class="comment-text">
            {{ message.message }}
            <span class="text-xs text-neutral-content italic float-right" v-if="message.is_updated" v-bind:title="message.updated_at">
              {{ translate('is_updated') }}
            </span>
        </div>
    </div>
</template>

<script>
    import vClickOutside from "click-outside-vue3"
    /**
     * Don't do any of the heavy lifting here, just send some events to Messages for figuring stuff out
     */
    export default {
        directives: {
            clickOutside: vClickOutside.directive
        },
        props: [
            'message',
            'trans',
        ],
        data() {
            return {
                openedDropdown: false
            }
        },
        computed: {
            isUser: function() {
                return this.message.user !== null;
            },
            isCharacter: function() {
                return this.message.character !== null;
            },
        },
      emits: [
          'delete_message',
          'edit_message',
      ],

        methods: {
            deleteMessage: function(message) {
                this.$emit('delete_message', message);
              this.onClickOutside();
            },
            editMessage: function(message) {
                this.$emit('edit_message', message);
                this.onClickOutside();
            },
            translate(key) {
                return this.trans[key] ?? 'unknown';
            },
            dropdownClass() {
                return this.openedDropdown ? 'open dropdown relative' : 'dropdown relative';
            },
            openDropdown() {
                return this.openedDropdown = true;
            },
            boxClasses: function (message) {
                let classes = 'box-comment bg-base-100 p-2 flex flex-col gap-1';
                classes += ' message-author-' + message.from_id;
                classes += ' message-real-author-' + message.created_by;

                if (message.group) {
                    classes += ' message-followup';
                } else {
                    classes += ' message-first rounded-t-lg'
                }
                return classes;
            },
            onClickOutside (event) {
                this.openedDropdown = false;
            },
        },
    }
</script>
