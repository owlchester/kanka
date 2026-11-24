<template>
    <div
        v-if="!model.url"
        :class="cardClass"
        @click="toggleSelection"
    >
        <div class="flex items-start gap-3 min-w-0">
            <div class="w-9 h-9 rounded-lg bg-base-200 flex items-center justify-center shrink-0 text-neutral-content">
                <i :class="model.icon || 'fa-regular fa-cube'" aria-hidden="true" />
            </div>
            <div class="min-w-0 grow flex flex-col gap-0.5">
                <div class="font-semibold text-base-content truncate" :title="model.name">
                    {{ model.name }}
                </div>
                <div class="text-xs text-neutral-content truncate">
                    <span>{{ model.type_name }}</span>
                    <span v-if="model.parent_name">
                        · {{ parentEntityLabel }}
                    </span>
                </div>
            </div>
            <input
                type="checkbox"
                v-model="model.is_selected"
                :aria-label="model.name"
                class="mt-1 shrink-0 cursor-pointer"
                @click.stop
            />
        </div>

        <div class="flex items-end justify-between gap-3 pt-1">
            <div class="min-w-0 flex flex-col gap-1 text-xs">
                <span class="text-neutral-content truncate w-fit max-w-full" v-tippy="model.deleted_at_formatted">
                    {{ deletedAtLabel }}
                </span>
                <span
                    v-if="model.expires_label"
                    :class="[expiryClass, 'w-fit cursor-help']"
                    v-tippy="model.expires_tooltip"
                >
                    {{ model.expires_label }}
                </span>
            </div>
            <button
                type="button"
                :class="buttonClass"
                :disabled="disabled || model.is_recovering"
                @click.stop="restoreElement"
            >
                <i v-if="model.is_recovering" class="fa-solid fa-spinner fa-spin" aria-hidden="true" />
                <i v-else class="fa-regular fa-rotate-left" aria-hidden="true" />
                <span>{{ trans('recover') }}</span>
            </button>
        </div>
    </div>

    <div
        v-else
        class="rounded-xl bg-base-100 border border-success/40 p-4 flex flex-col justify-between gap-3"
    >
        <div class="flex items-start gap-3 min-w-0">
            <div class="w-9 h-9 rounded-lg bg-success text-success-content flex items-center justify-center shrink-0">
                <i class="fa-solid fa-circle-check" aria-hidden="true" />
            </div>
            <div class="min-w-0 grow flex flex-col gap-0.5">
                <a
                    :href="model.url"
                    class="font-semibold text-link hover:underline truncate"
                    :title="model.name"
                >
                    {{ model.name }}
                </a>
                <div class="text-xs text-neutral-content truncate">
                    <span>{{ model.type_name }}</span>
                    <span v-if="model.parent_name">
                        · {{ parentEntityLabel }}
                    </span>
                </div>
            </div>
            <span class="rounded-full bg-success text-success-content px-2 py-0.5 text-xs font-medium shrink-0">
                {{ trans('recovered_badge') }}
            </span>
        </div>

        <div class="flex justify-end">
            <a :href="model.url" class="btn2 btn-ghost btn-xs">
                <span>{{ trans('view_recovered') }}</span>
                <i class="fa-regular fa-arrow-right" aria-hidden="true" />
            </a>
        </div>
    </div>
</template>

<script setup lang="ts">
import { computed } from 'vue';

const emit = defineEmits(['recover']);

const props = defineProps<{
    model: Record<string, any>;
    i18n: Record<string, string>;
    disabled?: boolean;
}>();

const trans = (key: string): string => {
    return props.i18n?.[key] ?? key;
};

const deletedAtLabel = computed(() => {
    return trans('deleted_at')
        .replace('placeholder', props.model.date ?? '')
        .replace('placeholder', props.model.deleted_name ?? '');
});

const parentEntityLabel = computed(() => {
    if (!props.model.parent_name) {
        return '';
    }
    return trans('parent_entity').replace(':name', props.model.parent_name);
});

const cardClass = computed(() => {
    const base = 'rounded-xl p-4 flex flex-col justify-between gap-3 transition cursor-pointer border';
    if (props.model.is_selected) {
        return `${base} border-primary ring-2 ring-primary/20 bg-primary/5`;
    }
    return `${base} bg-base-100 border-base-300/60 hover:border-base-300 hover:shadow-sm`;
});

const expiryClass = computed(() => {
    if (typeof props.model.days_left === 'number' && props.model.days_left <= 1) {
        return 'bg-error text-error-content px-2 py-0.5 rounded-full font-medium';
    }
    if (typeof props.model.days_left === 'number' && props.model.days_left <= 7) {
        return 'bg-warning text-warning-content px-2 py-0.5 rounded-full font-medium';
    }
    return 'text-neutral-content';
});

const buttonClass = computed(() => {
    let css = 'btn2 btn-default btn-sm shrink-0';
    if (props.model.is_recovering) {
        css += ' btn-disabled';
    }
    return css;
});

const toggleSelection = () => {
    if (!props.model.url) {
        props.model.is_selected = !props.model.is_selected;
    }
};

const restoreElement = () => {
    emit('recover', props.model);
};
</script>
