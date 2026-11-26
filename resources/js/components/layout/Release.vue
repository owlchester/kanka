<template>
    <div
        v-if="!is_dismissed"
        :data-id="release.id"
        class="release p-3 rounded-xl bg-base-200/70 hover:bg-base-200 transition-colors flex items-start gap-2.5 text-sm"
    >
        <div class="grow min-w-0">
            <a
                v-html="release.title"
                class="font-semibold cursor-pointer block w-full text-link leading-snug"
                :href="release.url"
                target="_blank"
            ></a>
            <p class="mt-1 text-xs text-base-content/75 leading-relaxed" v-html="release.text"></p>
        </div>
        <button
            type="button"
            class="size-7 rounded-lg inline-flex items-center justify-center text-base-content/50 hover:text-base-content hover:bg-base-300/60 transition-colors cursor-pointer shrink-0 dismissable"
            :title="release.dismiss_text"
            :aria-label="release.dismiss_text"
            :disabled="is_loading"
            @click="dismiss(release)"
        >
            <i v-if="is_loading" class="fa-solid fa-spinner fa-spin text-xs" aria-hidden="true"></i>
            <i v-else class="fa-regular fa-times text-xs" aria-hidden="true"></i>
        </button>
    </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';

const emit = defineEmits(['read']);

defineProps<{
    release: {
        id: number | string;
        title: string;
        text: string;
        url: string;
        dismiss: string;
        dismiss_text?: string;
    };
}>();

const is_dismissed = ref(false);
const is_loading = ref(false);

const dismiss = (release) => {
    is_loading.value = true;
    axios.post(release.dismiss)
        .then(() => {
            is_dismissed.value = true;
            emit('read', release);
        });
};
</script>
