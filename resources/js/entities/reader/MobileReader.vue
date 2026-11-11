<template>
    <button
        v-if="hasDetails"
        ref="detailsButton"
        type="button"
        class="btn2 btn-ghost min-h-11! px-1.5! gap-1! ml-auto"
        :aria-controls="dialogId"
        :aria-expanded="isOpen"
        aria-haspopup="dialog"
        @click="openDetails"
    >{{ labels.details }}</button>

    <div v-if="sections.length > 1" class="basis-full min-w-0 pt-1">
        <label class="sr-only" :for="jumpId">{{ labels.jump }}</label>
        <select :id="jumpId" class="w-full min-h-11 text-base" :aria-label="labels.jump" @change="jump">
            <option value="">{{ labels.onPage }}</option>
            <option v-for="section in sections" :key="section.id" :value="section.id">
                {{ section.nested ? '↳ ' : '' }}{{ section.label }}
            </option>
        </select>
    </div>

    <Teleport to="body">
        <dialog
            ref="dialog"
            :id="dialogId"
            class="dialog entity-details-sheet bg-base-100 text-base-content rounded-t-2xl md:rounded-2xl shadow-sm mx-auto w-full max-w-2xl [inset:auto_0_0]! mb-0! pb-[env(safe-area-inset-bottom)] print:hidden!
                [&_.element-toggle]:min-h-11 [&_.sidebar-section-title>a]:inline-flex [&_.sidebar-section-title>a]:size-11 [&_.sidebar-section-title>a]:items-center [&_.sidebar-section-title>a]:justify-center"
            aria-modal="true"
            :aria-labelledby="`${dialogId}-title`"
            @cancel.prevent="closeDetails()"
            @close="onNativeClose"
            @click.capture="handoffDialog"
            @click="dismissBackdrop"
        >
            <header class="flex items-center justify-between gap-4 p-4 md:p-6">
                <h2 :id="`${dialogId}-title`" class="text-lg font-normal">{{ labels.details }}</h2>
                <button type="button" class="text-2xl opacity-60 hover:opacity-100 hover:bg-base-200 focus:bg-base-200 cursor-pointer size-11 flex items-center justify-center rounded-lg" :aria-label="labels.close" @click="closeDetails()">
                    <i class="fa-regular fa-xmark" aria-hidden="true"></i>
                </button>
            </header>
            <article ref="sheetBody" class="py-4 px-4 md:px-6"></article>
        </dialog>
    </Teleport>
</template>

<script setup>
import { nextTick, onBeforeUnmount, onMounted, ref } from 'vue';
import { collectSections, readHash, scrollToSection } from './navigation';

const props = defineProps({
    root: { type: Object, required: true },
    labels: { type: Object, required: true },
    entityId: { type: String, required: true },
});

const dialogId = `entity-details-sheet-${props.entityId}`;
const jumpId = `entity-reader-jump-${props.entityId}`;
const detailsId = `entity-details-${props.entityId}`;
const story = props.root.querySelector('.entity-main-block');
const content = props.root.querySelector('[data-reader-details-content]');
const fallback = props.root.querySelector('[data-reader-details-link]');
const metadata = props.root.querySelector('.entity-header-secondary');
const more = props.root.querySelector('.entity-mobile-more');
const navigation = props.root.querySelector('.entity-mobile-navigation');
const mobile = window.matchMedia('(width < 64rem)');
const marker = document.createComment('Entity details location');
const dialog = ref(null);
const sheetBody = ref(null);
const detailsButton = ref(null);
const hasDetails = ref(false);
const isOpen = ref(false);
const sections = ref([]);
let observer;
let resizeObserver;
let frame;
let pendingHash = readHash(window.location.hash);
let metadataWasOpen;
let printing = false;
const tooltipParents = new Map();

const restoreContent = () => {
    tooltipParents.forEach((appendTo, instance) => {
        if (!instance.state.isDestroyed) {
            instance.hide();
            instance.setProps({ appendTo });
        }
    });
    tooltipParents.clear();
    if (content && marker.parentNode) {
        marker.after(content);
    }
};

const closeDetails = (restoreFocus = true) => {
    if (!isOpen.value) {
        return;
    }
    isOpen.value = false;
    dialog.value.close();
    restoreContent();
    if (restoreFocus && mobile.matches) {
        detailsButton.value?.focus({ preventScroll: true });
    }
};

const onNativeClose = () => {
    if (!dialog.value.open) {
        closeDetails();
    }
};

const openDetails = () => {
    if (!hasDetails.value || !mobile.matches || isOpen.value) {
        return;
    }
    if (more) {
        more.open = false;
    }
    sheetBody.value.append(content);
    content.querySelectorAll('*').forEach((node) => {
        if (node._tippy) {
            tooltipParents.set(node._tippy, node._tippy.props.appendTo);
            node._tippy.setProps({ appendTo: dialog.value });
        }
    });
    isOpen.value = true;
    dialog.value.showModal();
    sheetBody.value.scrollTop = 0;
};

const dismissBackdrop = (event) => {
    if (event.target !== dialog.value) {
        return;
    }
    const rect = dialog.value.getBoundingClientRect();
    if (event.clientX < rect.left || event.clientX > rect.right || event.clientY < rect.top || event.clientY > rect.bottom) {
        closeDetails();
    }
};

const handoffDialog = (event) => {
    // Existing editors use non-modal dialogs outside the browser's top layer.
    // Release the modal before their original click handlers run.
    if (event.target.closest('[data-toggle="dialog"], [data-toggle="dialog-ajax"], [data-toggle="dialog-tt"], .live-edit')) {
        closeDetails(false);
    }
};

const visitHash = () => {
    const id = pendingHash;
    if (!id) {
        return;
    }
    if (id === detailsId) {
        openDetails();
        pendingHash = null;
        return;
    }
    const target = document.getElementById(id);
    if (target && story?.contains(target)) {
        scrollToSection(target);
        pendingHash = null;
    }
};

const refreshSections = () => {
    sections.value = collectSections(story, props.labels.story);
    nextTick(visitHash);
};

const scheduleRefresh = () => {
    cancelAnimationFrame(frame);
    frame = requestAnimationFrame(refreshSections);
};

const onHashChange = () => {
    closeDetails(false);
    pendingHash = readHash(window.location.hash);
    visitHash();
};

const jump = (event) => {
    const id = event.target.value;
    const target = document.getElementById(id);
    if (target && story?.contains(target)) {
        history.pushState(history.state, '', `#${encodeURIComponent(id)}`);
        scrollToSection(target);
    }
    event.target.value = '';
};

const onOutsideClick = (event) => {
    if (more?.open && (!more.contains(event.target) || event.target.closest('a'))) {
        more.open = false;
    }
};

const onKeydown = (event) => {
    if (event.key === 'Escape' && more?.open) {
        more.open = false;
        more.querySelector('summary').focus();
    }
};

const updateViewport = () => {
    if (printing) {
        return;
    }
    if (!mobile.matches) {
        closeDetails(false);
    }
    if (metadata) {
        metadata.open = !mobile.matches;
    }
};

const updateStickyOffset = () => {
    const height = document.getElementById('header')?.getBoundingClientRect().height ?? 0;
    navigation.style.setProperty('--entity-reader-top', `${height}px`);
    navigation.style.setProperty('--entity-reader-height', `${navigation.getBoundingClientRect().height}px`);
};

const beforePrint = () => {
    printing = true;
    closeDetails(false);
    metadataWasOpen = metadata?.open;
    if (metadata) {
        metadata.open = true;
    }
};

const afterPrint = () => {
    printing = false;
    if (metadata && metadataWasOpen !== undefined) {
        metadata.open = mobile.matches ? metadataWasOpen : true;
    }
};

onMounted(() => {
    hasDetails.value = Boolean(content?.children.length && typeof dialog.value.showModal === 'function');
    if (hasDetails.value) {
        content.before(marker);
        content.dataset.readerEnhanced = 'true';
    }
    if (fallback && (hasDetails.value || !content?.children.length)) {
        fallback.hidden = true;
    }
    updateViewport();
    updateStickyOffset();
    refreshSections();
    if (story) {
        observer = new MutationObserver(scheduleRefresh);
        observer.observe(story, { childList: true, subtree: true, characterData: true });
    }
    const header = document.getElementById('header');
    resizeObserver = new ResizeObserver(updateStickyOffset);
    resizeObserver.observe(navigation);
    if (header) {
        resizeObserver.observe(header);
    }
    mobile.addEventListener('change', updateViewport);
    document.addEventListener('kanka.default', scheduleRefresh);
    document.addEventListener('click', onOutsideClick, true);
    document.addEventListener('keydown', onKeydown);
    window.addEventListener('hashchange', onHashChange);
    window.addEventListener('beforeprint', beforePrint);
    window.addEventListener('afterprint', afterPrint);
});

onBeforeUnmount(() => {
    closeDetails(false);
    restoreContent();
    marker.remove();
    if (content) {
        delete content.dataset.readerEnhanced;
    }
    if (fallback) {
        fallback.hidden = false;
    }
    if (metadata) {
        metadata.open = true;
    }
    observer?.disconnect();
    resizeObserver?.disconnect();
    cancelAnimationFrame(frame);
    mobile.removeEventListener('change', updateViewport);
    document.removeEventListener('kanka.default', scheduleRefresh);
    document.removeEventListener('click', onOutsideClick, true);
    document.removeEventListener('keydown', onKeydown);
    window.removeEventListener('hashchange', onHashChange);
    window.removeEventListener('beforeprint', beforePrint);
    window.removeEventListener('afterprint', afterPrint);
});
</script>
