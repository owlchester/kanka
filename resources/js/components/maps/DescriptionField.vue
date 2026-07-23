<template>
    <div class="flex flex-col gap-2">
        <button
            v-if="!hasContent"
            type="button"
            class="btn2 btn-default btn-sm self-start"
            @click="openDialog"
        >
            {{ i18n.add_description }}
        </button>

        <template v-else>
            <div class="flex items-center justify-between gap-2">
                <label class="text-xs font-semibold uppercase tracking-wide text-neutral-content">{{ i18n.description }}</label>
            </div>

            <div class="line-clamp-2 text-sm text-neutral-content">{{ preview }}</div>
            <button
                type="button"
                class="btn2 btn-default btn-sm self-start"
                @click="openDialog"
            >
                {{ i18n.edit_description }}
            </button>
        </template>

        <dialog
            ref="dialogRef"
            class="dialog rounded-2xl bg-base-100 text-base-content w-full md:w-fit md:min-w-2xl"
            aria-modal="true"
            @close="dialogOpen = false"
            @keydown="handleDialogKeydown"
        >
            <header class="flex gap-6 items-center p-4 md:p-6 justify-between">
                <h2>{{ i18n.description }}</h2>
                <button type="button" class="btn2 btn-default btn-sm" @click="closeDialog">
                    <i class="fa-solid fa-xmark" aria-hidden="true" />
                </button>
            </header>
            <article class="max-w-2xl p-4 md:px-6 entity-content">
                <Tiptap
                    v-if="dialogOpen"
                    ref="tiptapRef"
                    :content="editorContent"
                    v-model="dialogHtml"
                    :mentions="mentionsUrl"
                    :gallery="galleryUrl"
                    :gallery-upload="galleryUploadUrl"
                />
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
import { computed, nextTick, ref } from "vue";
import Tiptap from "../../editors/tiptap/Tiptap.vue";
import { htmlToPlainText } from "../../maps/entryText.js";

const props = defineProps({
    pin: { type: Object, required: true },
    i18n: { type: Object, required: true },
    mentionsUrl: { type: String, default: null },
    galleryUrl: { type: String, default: null },
    galleryUploadUrl: { type: String, default: null },
});

const emit = defineEmits(["change"]);

const dialogRef = ref(null);
const tiptapRef = ref(null);
const dialogOpen = ref(false);
const dialogHtml = ref("");

const plainText = computed(() => htmlToPlainText(props.pin.entry));
const hasContent = computed(() => plainText.value.length > 0);
const preview = computed(() => plainText.value.replace(/\s+/g, " "));
// The raw HTML for the Tiptap instance: prefer the server-hydrated entryForEdition
// (mentions as [type:id] bracket placeholders, resolved client-side by Tiptap's
// MentionParser) when available, falling back to the raw entry (e.g. a client-only
// draft pin, which never has entryForEdition).
const editorContent = computed(() => props.pin.entryForEdition ?? props.pin.entry ?? "");

async function openDialog() {
    // Seed dialogHtml with the same content shown to Tiptap so that saving without
    // making any edits round-trips the existing description instead of wiping it —
    // Tiptap only emits update:modelValue on user edits, not on initial mount.
    dialogHtml.value = editorContent.value;
    dialogOpen.value = true;
    dialogRef.value?.showModal();

    await nextTick();
    await tiptapRef.value?.focus();
}

function closeDialog() {
    dialogRef.value?.close();
}

function saveDialog() {
    emit("change", dialogHtml.value);
    closeDialog();
}

function handleDialogKeydown(event) {
    if ((event.ctrlKey || event.metaKey) && event.key.toLowerCase() === "s") {
        event.preventDefault();
        saveDialog();
    }
}
</script>
