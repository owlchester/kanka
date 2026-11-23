<template>
    <div
        v-if="!is_dismissed"
        :data-id="notification.id"
        class="notification p-2.5 rounded-xl bg-base-200/70 hover:bg-base-200 transition-colors flex items-start gap-2.5 text-sm"
        :class="{ unread: !notification.is_read }"
    >
        <div class="flex-none pt-0.5 text-base-content/70">
            <i :class="iconClass(notification)" aria-hidden="true"></i>
        </div>
        <a
            v-if="notification.url"
            class="grow min-w-0 break-words text-link leading-snug"
            v-html="notification.text"
            :href="notification.url"
        ></a>
        <div
            v-else
            class="grow min-w-0 break-words leading-snug"
            v-html="notification.text"
        ></div>
        <button
            type="button"
            class="size-7 rounded-lg inline-flex items-center justify-center text-base-content/50 hover:text-base-content hover:bg-base-300/60 transition-colors cursor-pointer shrink-0 dismissable"
            :title="notification.dismiss_text"
            :aria-label="notification.dismiss_text"
            :disabled="is_loading"
            @click="dismiss(notification)"
        >
            <i v-if="is_loading" class="fa-solid fa-spinner fa-spin text-xs" aria-hidden="true"></i>
            <i v-else class="fa-regular fa-times text-xs" aria-hidden="true"></i>
        </button>
    </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';

const emit = defineEmits(['read']);

const props = defineProps<{
    notification: {
        id: number | string;
        url?: string | null;
        text: string;
        icon: string;
        colour?: string;
        is_read?: boolean;
        dismiss: string;
        dismiss_text?: string;
    };
}>();

const is_dismissed = ref(false);
const is_loading = ref(false);

const iconClass = (notification) => {
    let icon = 'fa-regular fa-' + notification.icon;
    if (notification.colour === 'red') {
        icon += ' text-red';
    }
    return icon;
};

const dismiss = (notification) => {
    is_loading.value = true;
    axios.post(notification.dismiss)
        .then(() => {
            is_dismissed.value = true;
            emit('read', notification);
        });
};
</script>
