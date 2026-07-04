<template>
    <aside v-if="pin" class="fixed top-0 right-0 h-screen w-80 bg-base-100 shadow-lg z-[1100] p-4 flex flex-col gap-2">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-semibold">{{ pin.name }}</h2>
            <button class="btn2 btn-default btn-sm" @click="$emit('close')">
                <i class="fa-solid fa-xmark" aria-hidden="true" />
            </button>
        </div>
    </aside>
</template>

<script setup>
defineProps({
    pin: { type: Object, default: null },
})

defineEmits(['close'])
</script>
