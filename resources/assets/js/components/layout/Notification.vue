<template>
    <a :class="backgroundClass(notification)" v-bind:href="notification.url" v-if="notification.url">
        <div class="flex-none p-2">
            <i :class="iconClass(notification)" aria-hidden="true"></i>
        </div>
        <div class="flex-grow p-2">
            {{ notification.text }}
        </div>
    </a>
    <div :class="backgroundClass(notification)" v-else>
        <div class="flex-none p-2">
            <i :class="iconClass(notification)" aria-hidden="true"></i>
        </div>
        <div class="flex-grow p-2">
            {{ notification.text }}
        </div>
    </div>
</template>


<script>
export default {
    props: [
        'notification'
    ],
    methods: {
        backgroundClass: function(notification) {
            let css = 'notification flex justify-center items-center mb-2 px-2 py-2';
            if (notification.is_read) {
                return css;
            }
            return css + ' unread';
        },
        iconClass: function(notification) {
            return 'fa-solid fa-' + notification.icon;
        }
    },
}
</script>
