<template>
    <a :class="backgroundClass(notification)" v-bind:href="notification.url" v-if="notification.url && !is_dismissed" :data-id="notification.id">
        <div class="flex-none p-2">
            <i :class="iconClass(notification)" aria-hidden="true"></i>
        </div>
        <div class="flex-grow p-2" v-html="notification.text"></div>

        <div class="flex-none p-2 cursor-pointer dismissable" v-on:click="dismiss(notification)" v-if="!this.is_loading" :title="notification.dismiss_text">
            <i class="fa-solid fa-times" aria-hidden="true"></i>
        </div>
        <div class="flex-none p-2" v-else>
            <i class="fa-solid fa-spinner fa-spin" aria-hidden="true"></i>
        </div>
    </a>
    <div :class="backgroundClass(notification)" :data-id="notification.id" v-else-if="!is_dismissed">
        <div class="flex-none p-2">
            <i :class="iconClass(notification)" aria-hidden="true"></i>
        </div>
        <div class="flex-grow p-2" v-html="notification.text"></div>

        <div class="flex-none p-2 cursor-pointer dismissable" v-on:click="dismiss(notification)" v-if="!this.is_loading" :title="notification.dismiss_text">
            <i class="fa-solid fa-times" aria-hidden="true"></i>
        </div>
        <div class="flex-none p-2" v-else>
            <i class="fa-solid fa-spinner fa-spin" aria-hidden="true"></i>
        </div>
    </div>
</template>


<script>
export default {
    props: [
        'notification'
    ],
    data() {
        return {
            is_dismissed: false,
            is_loading: false,
        }
    },
    methods: {
        backgroundClass: function(notification) {
            let css = 'notification bg-base-200 flex justify-center items-center mb-2 px-2 py-2 rounded-md';
            if (notification.is_read) {
                return css;
            }
            return css + ' unread';
        },
        iconClass: function(notification) {
            return 'fa-solid fa-' + notification.icon;
        },
        dismiss: function(notification) {
            this.is_loading = true;
            axios.post(notification.dismiss)
                .then(() => {
                    this.is_dismissed = true;
                    this.emitter.emit('read_notification', notification);
                });
        }
    },
}
</script>
