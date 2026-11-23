<template>
    <div
        v-if="!dismissed"
        class="bg-base-100 rounded-2xl p-4 md:p-5 flex flex-col md:flex-row md:items-center justify-between gap-4 shadow-xs relative"
    >
        <div class="flex items-start gap-3 pr-8 md:pr-0">
            <div class="size-10 rounded-xl bg-primary/10 text-primary flex items-center justify-center shrink-0">
                <i class="fa-regular fa-sparkles text-lg" aria-hidden="true"></i>
            </div>
            <div class="flex flex-col gap-1">
                <h2 class="text-base font-semibold m-0">{{ texts.title }}</h2>
                <p class="text-sm text-base-content/75 m-0">{{ texts.body }}</p>
            </div>
        </div>
        <div class="flex items-center gap-2 shrink-0">
            <button
                type="button"
                class="btn2 btn-primary btn-sm cursor-pointer"
                :disabled="isDismissing"
                @click="startTour"
            >
                {{ texts.actions.start }}
            </button>
            <button
                type="button"
                class="btn2 btn-ghost btn-sm cursor-pointer"
                :class="{ loading: isDismissing }"
                :disabled="isDismissing"
                @click="dismiss"
            >
                {{ texts.actions.dismiss }}
            </button>
        </div>
        <button
            type="button"
            class="md:hidden absolute top-3 right-3 size-7 rounded-lg inline-flex items-center justify-center text-base-content/50 hover:text-base-content cursor-pointer"
            :aria-label="texts.actions.dismiss"
            :disabled="isDismissing"
            @click="dismiss"
        >
            <i class="fa-regular fa-xmark" aria-hidden="true"></i>
        </button>
    </div>

    <Teleport to="body">
        <template v-if="tourActive">
            <div
                class="fixed inset-0 z-1099"
                :class="spotlightRect ? '' : 'bg-black/55'"
                @click="dismiss"
            ></div>

            <div
                v-if="spotlightRect"
                class="fixed rounded-xl ring-2 ring-primary pointer-events-none transition-all duration-200 z-1100"
                :style="{
                    top: `${spotlightRect.top}px`,
                    left: `${spotlightRect.left}px`,
                    width: `${spotlightRect.width}px`,
                    height: `${spotlightRect.height}px`,
                    boxShadow: '0 0 0 9999px rgba(0, 0, 0, 0.55)',
                }"
            ></div>

            <div
                ref="popoverRef"
                role="dialog"
                aria-modal="true"
                :aria-label="currentStep.title"
                class="fixed z-1101 bg-base-100 text-base-content rounded-2xl shadow-2xl ring-1 ring-base-content/10 p-4 w-80 max-w-[calc(100vw-2rem)] flex flex-col gap-3"
                :style="popoverStyle"
            >
                <div class="flex items-center justify-between gap-2 text-xs text-base-content/60">
                    <span>{{ stepCounterText }}</span>
                    <button
                        type="button"
                        class="text-base-content/60 hover:text-base-content cursor-pointer"
                        @click="dismiss"
                    >
                        {{ texts.tour.skip }}
                    </button>
                </div>

                <div class="flex flex-col gap-1">
                    <h3 class="text-base font-semibold m-0">{{ currentStep.title }}</h3>
                    <p class="text-sm text-base-content/80 m-0">{{ currentStep.body }}</p>
                </div>

                <div class="flex items-center justify-between gap-2 pt-1">
                    <button
                        v-if="stepIndex > 0"
                        type="button"
                        class="btn2 btn-ghost btn-sm cursor-pointer"
                        @click="prevStep"
                    >
                        {{ texts.tour.back }}
                    </button>
                    <span v-else></span>

                    <button
                        type="button"
                        class="btn2 btn-primary btn-sm cursor-pointer"
                        @click="nextStep"
                    >
                        {{ isLastStep ? texts.tour.done : texts.tour.next }}
                    </button>
                </div>
            </div>
        </template>
    </Teleport>
</template>

<script setup>
import { autoUpdate, computePosition, flip, offset, shift } from '@floating-ui/dom';
import { computed, nextTick, onBeforeUnmount, ref } from 'vue';

const props = defineProps({
    dismissUrl: {
        type: String,
        required: true,
    },
    canQuickCreate: {
        type: Boolean,
        default: false,
    },
    texts: {
        type: Object,
        required: true,
    },
});

const STEP_KEYS = ['profile', 'campaigns', 'search_create'];
const SPOTLIGHT_PADDING = 6;

const dismissed = ref(false);
const isDismissing = ref(false);
const tourActive = ref(false);
const stepIndex = ref(0);
const isMobile = ref(false);
const spotlightRect = ref(null);
const popoverRef = ref(null);
const popoverStyle = ref({
    top: '50%',
    left: '50%',
    transform: 'translate(-50%, -50%)',
});

let stopAutoUpdate = null;

const isLastStep = computed(() => stepIndex.value === STEP_KEYS.length - 1);

const stepCounterText = computed(() =>
    props.texts.tour.step_of
        .replace(':current', String(stepIndex.value + 1))
        .replace(':total', String(STEP_KEYS.length)),
);

const currentStep = computed(() => {
    const key = STEP_KEYS[stepIndex.value];
    const step = props.texts.steps[key];

    if (key === 'search_create') {
        const title = props.canQuickCreate ? step.title : step.title_search_only;
        const body = isMobile.value
            ? (props.canQuickCreate ? step.body_mobile : step.body_mobile_search_only)
            : (props.canQuickCreate ? step.body_desktop : step.body_desktop_search_only);

        return { key, title, body };
    }

    return {
        key,
        title: step.title,
        body: isMobile.value ? step.body_mobile : step.body_desktop,
    };
});

function pickVisible(selectors) {
    for (const selector of selectors) {
        const el = document.querySelector(selector);
        if (!el) {
            continue;
        }
        const rect = el.getBoundingClientRect();
        if (rect.width > 0 && rect.height > 0) {
            return el;
        }
    }

    return null;
}

function resolveTarget(key) {
    isMobile.value = window.innerWidth < 768;

    if (isMobile.value) {
        if (key === 'profile' || key === 'campaigns') {
            return pickVisible(['.mobile-navigation [data-tour="profile"]']);
        }
        return pickVisible(['.mobile-navigation [data-tour="search"]']);
    }

    if (key === 'profile') {
        return pickVisible([
            '.main-sidebar [data-sidebar-action="profile"]',
            '.desktop-floating-nav [data-sidebar-action="profile"]',
        ]);
    }

    if (key === 'campaigns') {
        return pickVisible([
            '.main-sidebar [data-sidebar-action="worlds"]',
            '.desktop-floating-nav [data-sidebar-action="worlds"]',
        ]);
    }

    return pickVisible([
        '.main-sidebar [data-tour="search-create"]',
        '.desktop-floating-nav [data-tour="search-create"]',
    ]);
}

function cleanupPositioning() {
    if (stopAutoUpdate) {
        stopAutoUpdate();
        stopAutoUpdate = null;
    }
}

async function updatePosition() {
    cleanupPositioning();
    await nextTick();

    const key = STEP_KEYS[stepIndex.value];
    const target = resolveTarget(key);
    const popover = popoverRef.value;

    if (!target || !popover) {
        spotlightRect.value = null;
        popoverStyle.value = {
            top: '50%',
            left: '50%',
            transform: 'translate(-50%, -50%)',
        };
        return;
    }

    const sync = async () => {
        const rect = target.getBoundingClientRect();
        spotlightRect.value = {
            top: Math.max(4, rect.top - SPOTLIGHT_PADDING),
            left: Math.max(4, rect.left - SPOTLIGHT_PADDING),
            width: rect.width + SPOTLIGHT_PADDING * 2,
            height: rect.height + SPOTLIGHT_PADDING * 2,
        };

        const { x, y } = await computePosition(target, popover, {
            strategy: 'fixed',
            placement: isMobile.value ? 'top' : 'right',
            middleware: [
                offset(14),
                flip({ fallbackPlacements: ['bottom', 'top', 'left', 'right'] }),
                shift({ padding: 16 }),
            ],
        });

        popoverStyle.value = {
            top: `${Math.round(y)}px`,
            left: `${Math.round(x)}px`,
            transform: 'none',
        };
    };

    stopAutoUpdate = autoUpdate(target, popover, sync);
}

function handleKeydown(event) {
    if (!tourActive.value) {
        return;
    }

    if (event.key === 'Escape') {
        event.preventDefault();
        dismiss();
    } else if (event.key === 'ArrowRight') {
        event.preventDefault();
        nextStep();
    } else if (event.key === 'ArrowLeft' && stepIndex.value > 0) {
        event.preventDefault();
        prevStep();
    }
}

function startTour() {
    stepIndex.value = 0;
    tourActive.value = true;
    window.addEventListener('keydown', handleKeydown);
    updatePosition();
}

function nextStep() {
    if (isLastStep.value) {
        dismiss();
        return;
    }
    stepIndex.value += 1;
    updatePosition();
}

function prevStep() {
    if (stepIndex.value <= 0) {
        return;
    }
    stepIndex.value -= 1;
    updatePosition();
}

function stopTour() {
    tourActive.value = false;
    cleanupPositioning();
    window.removeEventListener('keydown', handleKeydown);
}

function dismiss() {
    if (isDismissing.value) {
        return;
    }
    isDismissing.value = true;
    stopTour();
    dismissed.value = true;

    window.axios.post(props.dismissUrl).catch(() => {
        isDismissing.value = false;
    });
}

onBeforeUnmount(() => {
    stopTour();
});
</script>
