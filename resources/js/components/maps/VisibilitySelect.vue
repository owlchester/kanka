<template>
    <div class="flex flex-col gap-2">
        <label class="text-xs font-semibold uppercase tracking-wide opacity-75">{{ i18n.visibility }}</label>

        <select class="select select-bordered w-full" :value="pin.visibilityId" @change="onChange">
            <option v-for="option in options" :key="option.id" :value="option.id">
                {{ option.name }}
            </option>
        </select>
    </div>
</template>

<script setup>
const props = defineProps({
    pin: { type: Object, required: true },
    options: { type: Array, default: () => [] },
    i18n: { type: Object, required: true },
});

const emit = defineEmits(["change"]);

function onChange(event) {
    emit("change", Number(event.target.value));
}
</script>
