<template>
    <a
        :href="campaign.url"
        :title="campaign.name"
        class="group flex items-center gap-3 p-2 rounded-xl transition-colors"
        :class="active
            ? 'bg-primary/10 ring-1 ring-primary/30 text-base-content font-semibold'
            : 'hover:bg-base-200 text-base-content'"
    >
        <div class="size-9 rounded-lg shrink-0 overflow-hidden bg-base-200 flex items-center justify-center">
            <div
                v-if="campaign.image"
                class="size-full cover-background"
                :style="{ backgroundImage: `url(${campaign.image})` }"
            ></div>
            <i v-else class="fa-regular fa-earth-americas text-base-content/45 text-sm" aria-hidden="true"></i>
        </div>
        <span class="grow min-w-0 truncate text-sm" v-html="campaign.name"></span>
        <div class="flex items-center gap-2 shrink-0">
            <i
                v-if="campaign.is_boosted"
                class="fa-regular fa-gem text-boost text-xs"
                aria-label="Premium campaign"
            ></i>
            <i
                v-if="active"
                class="fa-solid fa-check text-primary text-xs"
                aria-hidden="true"
            ></i>
        </div>
    </a>
</template>

<script setup lang="ts">
defineProps<{
    campaign: {
        id?: number | string | null;
        name: string;
        url: string;
        image?: string | null;
        is_boosted?: boolean;
    };
    active?: boolean;
}>();
</script>
