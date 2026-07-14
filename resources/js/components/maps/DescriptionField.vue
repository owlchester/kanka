<template>
    <div class="flex flex-col gap-2">
        <button
            v-if="!editing && !hasContent"
            type="button"
            class="btn2 btn-default btn-sm self-start"
            @click="startEditing"
        >
            {{ i18n.add_description }}
        </button>

        <template v-else>
            <div class="flex items-center justify-between gap-2">
                <label class="text-xs font-semibold uppercase tracking-wide text-neutral-content">{{ i18n.description }}</label>
                <button
                    type="button"
                    class="btn2 btn-default btn-xs"
                    v-tippy="i18n.description_expand"
                    @click="openDialog"
                >
                    <i class="fa-regular fa-up-right-and-down-left-from-center" aria-hidden="true" />
                    <span class="sr-only">{{ i18n.description_expand }}</span>
                </button>
            </div>

            <textarea
                v-if="editing"
                v-model="text"
                rows="3"
                class="textarea w-full"
            />

            <template v-else>
                <div class="line-clamp-2 text-sm text-neutral-content">{{ preview }}</div>
                <button
                    type="button"
                    class="btn2 btn-default btn-sm self-start"
                    @click="openDialog"
                >
                    {{ i18n.edit_description }}
                </button>
            </template>
        </template>

        <dialog ref="dialogRef" class="dialog rounded-2xl bg-base-100 text-base-content md:min-w-2xl" aria-modal="true">
            <header class="flex gap-6 items-center p-4 md:p-6 justify-between">
                <h2>{{ i18n.description }}</h2>
                <button type="button" class="btn2 btn-default btn-sm" @click="closeDialog">
                    <i class="fa-solid fa-xmark" aria-hidden="true" />
                </button>
            </header>
            <article class="max-w-2xl p-4 md:px-6">
                <textarea v-model="dialogText" rows="14" class="textarea w-full" />
            </article>
            <footer class="p-4 md:px-6">
                <menu class="flex justify-end gap-3">
                    <button type="button" class="btn2 btn-default" @click="closeDialog">
                        {{ i18n.cancel }}
                    </button>
                    <button type="button" class="btn2 btn-primary" @click="saveDialog">
                        {{ i18n.save }}
                    </button>
                </menu>
            </footer>
        </dialog>
    </div>
</template>

<script setup>
import { computed, ref, watch } from "vue";
import { htmlToPlainText, htmlToPreviewText } from "../../maps/entryText.js";

const props = defineProps({
    pin: { type: Object, required: true },
    i18n: { type: Object, required: true },
});

const emit = defineEmits(["change"]);

const editing = ref(false);
const text = ref(htmlToPlainText(props.pin.entry));
const dialogText = ref("");
const dialogRef = ref(null);

const hasContent = computed(() => htmlToPlainText(props.pin.entry).trim().length > 0);
const preview = computed(() => htmlToPreviewText(props.pin.entry));

function startEditing() {
    editing.value = true;
}

function openDialog() {
    dialogText.value = text.value;
    dialogRef.value?.showModal();
}

function closeDialog() {
    dialogRef.value?.close();
}

function saveDialog() {
    text.value = dialogText.value;
    editing.value = true;
    closeDialog();
}

watch(text, (value) => {
    emit("change", value);
});
</script>
