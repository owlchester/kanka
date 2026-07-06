<template>
    <select ref="selectEl" class="w-full"></select>
</template>

<script setup>
import { onBeforeUnmount, onMounted, ref } from "vue";
import TomSelect from "tom-select";

const props = defineProps({
    pins: { type: Array, default: () => [] },
    modelValue: { type: Number, default: null },
    i18n: { type: Object, required: true },
});

const emit = defineEmits(["change"]);

const selectEl = ref(null);
let ts = null;

onMounted(() => {
    ts = new TomSelect(selectEl.value, {
        valueField: "id",
        labelField: "name",
        searchField: "name",
        placeholder: props.i18n.no_marker,
        onChange(value) {
            emit("change", value ? Number(value) : null);
        },
    });

    ts.addOptions([...props.pins].sort((a, b) => a.name.localeCompare(b.name)));

    if (props.modelValue) {
        ts.setValue(props.modelValue, true);
    }
});

onBeforeUnmount(() => {
    ts?.destroy();
});
</script>
