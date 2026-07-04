<template>
    <div class="flex flex-col gap-2">
        <label class="text-xs font-semibold uppercase tracking-wide text-neutral-content">{{ i18n.linked_entry }}</label>
        <select ref="selectEl" class="w-full"></select>
    </div>
</template>

<script setup>
import { onBeforeUnmount, onMounted, ref } from "vue";
import TomSelect from "tom-select";

const props = defineProps({
    pin: { type: Object, required: true },
    searchUrl: { type: String, required: true },
    i18n: { type: Object, required: true },
});

const emit = defineEmits(["change"]);

const selectEl = ref(null);
let ts = null;

onMounted(() => {
    ts = new TomSelect(selectEl.value, {
        valueField: "id",
        labelField: "text",
        searchField: "text",
        preload: "focus",
        loadThrottle: 500,
        placeholder: props.i18n.linked_entry,
        load(query, callback) {
            fetch(`${props.searchUrl}?q=${encodeURIComponent(query.trim())}`, {
                headers: { "X-Requested-With": "XMLHttpRequest" },
            })
                .then((res) => (res.ok ? res.json() : []))
                .then((data) => callback(data))
                .catch(() => callback());
        },
        onChange(value) {
            ts.blur();

            if (!value) {
                emit("change", { id: null, text: null });

                return;
            }

            const option = ts.options[value];
            emit("change", { id: Number(value), text: option ? option.text : null });
        },
    });

    if (props.pin.entityId) {
        ts.addOption({ id: props.pin.entityId, text: props.pin.entityName || "" });
        ts.setValue(props.pin.entityId, true);
    }
});

onBeforeUnmount(() => {
    ts?.destroy();
});
</script>
