<template>
    <div class="box-comment">
        <strong class="user" v-if="isUser">{{ message.user }}</strong>
        <strong class="character" v-if="isCharacter">{{ message.character }}</strong>
        <div class="comment-text">
            <span class="text-muted pull-right">{{ message.created_at }}</span>
            {{ message.message }}
        </div>
    </div>
</template>

<script>
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
            }
        }
    }
</script>