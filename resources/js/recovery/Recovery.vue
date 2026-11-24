<template>
    <div v-if="!initiated" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 w-full">
        <div
            v-for="n in 6"
            :key="n"
            class="rounded-xl bg-base-100 border border-base-300/60 p-4 flex flex-col justify-between gap-4 h-32 animate-pulse"
        >
            <div class="flex items-center gap-3">
                <div class="w-4 h-4 rounded bg-base-200 shrink-0" />
                <div class="w-9 h-9 rounded-lg bg-base-200 shrink-0" />
                <div class="flex flex-col gap-1.5 grow">
                    <div class="h-4 bg-base-200 rounded w-3/4" />
                    <div class="h-3 bg-base-200 rounded w-1/2" />
                </div>
            </div>
            <div class="flex items-center justify-between gap-3">
                <div class="h-3 bg-base-200 rounded w-1/2" />
                <div class="h-7 bg-base-200 rounded w-20" />
            </div>
        </div>
    </div>

    <div v-else class="flex flex-col gap-4 md:gap-5">
        <div
            v-if="models.length > 0"
            class="sticky top-14 z-30 rounded-xl bg-base-100/95 backdrop-blur-xs shadow-xs border border-base-300/60 p-3 flex flex-col gap-3"
        >
            <div class="flex flex-wrap items-center gap-2">
                <div class="flex min-w-[200px] grow items-center gap-2 rounded-lg border border-base-300 bg-base-100 px-3 focus-within:outline-2 focus-within:outline-primary/30">
                    <i class="fa-regular fa-magnifying-glass pointer-events-none shrink-0 text-sm text-neutral-content" aria-hidden="true" />
                    <input
                        v-model="searchTerm"
                        type="search"
                        class="min-h-9 min-w-0 w-full flex-1 appearance-none border-0! bg-transparent! p-0! text-sm outline-none!"
                        :placeholder="trans('search')"
                        :aria-label="trans('search')"
                    />
                    <button
                        v-if="searchTerm"
                        type="button"
                        class="text-neutral-content hover:text-base-content p-1 cursor-pointer"
                        :aria-label="trans('filter_clear')"
                        @click="searchTerm = ''"
                    >
                        <i class="fa-regular fa-xmark" aria-hidden="true" />
                    </button>
                </div>

                <select
                    v-model="selectedDeleter"
                    class="select select-sm rounded-lg border border-base-300 bg-base-100 text-sm min-h-9 px-2.5"
                    :aria-label="trans('filter_deleted_by')"
                >
                    <option value="">{{ trans('filter_all_users') }}</option>
                    <option v-for="option in deletedByOptions" :key="option.value" :value="option.value">
                        {{ option.label }} ({{ option.count }})
                    </option>
                </select>

                <select
                    v-model="selectedType"
                    class="select select-sm rounded-lg border border-base-300 bg-base-100 text-sm min-h-9 px-2.5"
                    :aria-label="trans('filter_type')"
                >
                    <option value="">{{ trans('filter_all_types') }}</option>
                    <option v-for="option in typeOptions" :key="option.value" :value="option.value">
                        {{ option.label }} ({{ option.count }})
                    </option>
                </select>

                <select
                    v-model="selectedTimeframe"
                    class="select select-sm rounded-lg border border-base-300 bg-base-100 text-sm min-h-9 px-2.5"
                    :aria-label="trans('filter_timeframe')"
                >
                    <option value="">{{ trans('filter_all_dates') }}</option>
                    <option value="24h">{{ trans('filter_last_24h') }}</option>
                    <option value="7d">{{ trans('filter_last_7d') }}</option>
                    <option value="30d">{{ trans('filter_last_30d') }}</option>
                    <option value="expiring">{{ trans('filter_expiring_soon') }}</option>
                </select>

                <select
                    v-model="sortBy"
                    class="select select-sm rounded-lg border border-base-300 bg-base-100 text-sm min-h-9 px-2.5"
                    :aria-label="trans('filter_sort')"
                >
                    <option value="newest">{{ trans('newest') }}</option>
                    <option value="oldest">{{ trans('oldest') }}</option>
                    <option value="name">{{ trans('name_asc') }}</option>
                    <option value="type">{{ trans('type') }}</option>
                </select>
            </div>

            <div class="flex items-center justify-between gap-2 flex-wrap text-sm">
                <div class="flex items-center gap-2 text-neutral-content">
                    <span>{{ countSummary }}</span>
                    <button
                        v-if="hasActiveFilters"
                        type="button"
                        class="btn2 btn-ghost btn-xs"
                        @click="clearFilters"
                    >
                        <i class="fa-regular fa-xmark" aria-hidden="true" />
                        <span>{{ trans('filter_clear') }}</span>
                    </button>
                </div>

                <div class="flex items-center gap-2 flex-wrap">
                    <button
                        v-if="selectedCount === 0"
                        type="button"
                        class="btn2 btn-default btn-sm"
                        :disabled="visibleRecoverableModels.length === 0"
                        @click="selectAll"
                    >
                        <i class="fa-regular fa-list-check" aria-hidden="true" />
                        <span>{{ trans('select_all') }}</span>
                    </button>
                    <template v-else>
                        <button
                            type="button"
                            class="btn2 btn-default btn-sm"
                            :disabled="recovering"
                            @click="deselectAll"
                        >
                            <i class="fa-regular fa-xmark" aria-hidden="true" />
                            <span>{{ trans('deselect_all') }}</span>
                        </button>
                        <button
                            type="button"
                            class="btn2 btn-primary btn-sm"
                            :disabled="recovering"
                            @click="bulkRecover"
                        >
                            <i v-if="recovering" class="fa-solid fa-spinner fa-spin" aria-hidden="true" />
                            <i v-else class="fa-regular fa-rotate-left" aria-hidden="true" />
                            <span>{{ trans('restore_selected') }} ({{ selectedCount }})</span>
                        </button>
                    </template>
                </div>
            </div>
        </div>

        <div
            v-if="models.length === 0"
            class="border border-dashed border-neutral-content rounded-lg shadow-xs bg-box p-6 text-center"
        >
            <div class="mx-auto max-w-2xl lg:p-4 flex flex-col items-center gap-2">
                <i class="fa-regular fa-clock-rotate-left text-3xl text-neutral-content mb-1" aria-hidden="true" />
                <div class="font-bold text-lg">{{ trans('empty_title') }}</div>
                <p class="text-neutral-content mb-2">{{ trans('empty') }}</p>
            </div>
        </div>

        <div
            v-else-if="filteredModels.length === 0"
            class="border border-dashed border-neutral-content rounded-lg shadow-xs bg-box p-6 text-center"
        >
            <div class="mx-auto max-w-2xl lg:p-4 flex flex-col items-center gap-2">
                <i class="fa-regular fa-filter-slash text-3xl text-neutral-content mb-1" aria-hidden="true" />
                <div class="font-bold text-lg">{{ trans('no_results_title') }}</div>
                <p class="text-neutral-content mb-2">{{ trans('no_results') }}</p>
                <button type="button" class="btn2 btn-default btn-sm" @click="clearFilters">
                    <i class="fa-regular fa-xmark" aria-hidden="true" />
                    <span>{{ trans('filter_clear') }}</span>
                </button>
            </div>
        </div>

        <div v-else class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 w-full">
            <Element
                v-for="model in filteredModels"
                :key="elementKey(model)"
                :model="model"
                :i18n="i18n"
                :disabled="recovering"
                @recover="recoverElement(model)"
            />
        </div>
    </div>

    <dialog ref="premiumDialog" class="dialog rounded-2xl text-center" v-if="initiated">
        <header class="flex gap-6 items-center p-4 md:p-6 justify-between">
            <h4 class="flex items-center gap-2 text-lg font-normal">
                <i class="fa-regular fa-gem text-primary" aria-hidden="true" />
                <span>{{ trans('premium_title') }}</span>
            </h4>
            <button type="button" class="text-base-content" @click="closeModal(premiumDialog)" title="Close">
                <i class="fa-regular fa-circle-xmark" aria-hidden="true" />
                <span class="sr-only">Close</span>
            </button>
        </header>
        <article class="max-w-4xl flex flex-col gap-2 text-left p-4 md:px-6">
            <div class="flex flex-col gap-1 w-full">
                <label>{{ trans('premium') }}</label>
            </div>
        </article>
        <footer class="p-4 md:px-6">
            <menu>
                <a :href="upgradeLink" class="btn2 btn-primary">
                    <span>{{ trans('upgrade') }}</span>
                    <i class="fa-regular fa-arrow-right" aria-hidden="true" />
                </a>
            </menu>
        </footer>
    </dialog>
</template>

<script setup lang="ts">
import { computed, onMounted, ref } from 'vue';
import Element from './Element.vue';
import {
    buildDeletedByOptions,
    buildTypeOptions,
    elementKey,
    filterAndSortModels,
} from './recoveryFilters.js';

const props = defineProps<{
    api: string;
}>();

const initiated = ref(false);
const premium = ref(false);
const models = ref<Record<string, any>[]>([]);
const i18n = ref<Record<string, string>>({});
const premiumDialog = ref<HTMLDialogElement | null>(null);
const recoveryApi = ref('');
const recovering = ref(false);
const upgradeLink = ref<string | null>(null);

const searchTerm = ref('');
const selectedDeleter = ref('');
const selectedType = ref('');
const selectedTimeframe = ref('');
const sortBy = ref('newest');

onMounted(() => {
    window.axios
        .get(props.api)
        .then((res) => {
            initiated.value = true;
            models.value = res.data.elements ?? [];
            i18n.value = res.data.i18n ?? {};
            recoveryApi.value = res.data.api?.recovery ?? '';
            premium.value = Boolean(res.data.acl?.premium);
            upgradeLink.value = res.data.upgrade ?? null;
        })
        .catch(() => {
            initiated.value = true;
            if (typeof window.showToast === 'function') {
                window.showToast(trans('error'));
            }
        });
});

const trans = (key: string): string => {
    return i18n.value?.[key] ?? key;
};

const deletedByOptions = computed(() => buildDeletedByOptions(models.value));
const typeOptions = computed(() => buildTypeOptions(models.value));

const filteredModels = computed(() =>
    filterAndSortModels(models.value, {
        search: searchTerm.value,
        deletedBy: selectedDeleter.value,
        type: selectedType.value,
        timeframe: selectedTimeframe.value,
        sort: sortBy.value,
    }),
);

const hasActiveFilters = computed(
    () =>
        searchTerm.value.trim() !== '' ||
        selectedDeleter.value !== '' ||
        selectedType.value !== '' ||
        selectedTimeframe.value !== '',
);

const countSummary = computed(() => {
    if (hasActiveFilters.value) {
        return trans('showing_count')
            .replace(':shown', String(filteredModels.value.length))
            .replace(':total', String(models.value.length));
    }
    return String(models.value.length);
});

const visibleRecoverableModels = computed(() =>
    filteredModels.value.filter((model) => !model.url),
);

const selectedCount = computed(
    () => models.value.filter((model) => model.is_selected && !model.url).length,
);

const clearFilters = () => {
    searchTerm.value = '';
    selectedDeleter.value = '';
    selectedType.value = '';
    selectedTimeframe.value = '';
};

const selectAll = () => {
    visibleRecoverableModels.value.forEach((model) => {
        model.is_selected = true;
    });
};

const deselectAll = () => {
    models.value.forEach((model) => {
        model.is_selected = false;
    });
};

const applyRecoveredUrls = (
    targets: Record<string, any>[],
    entitiesMap: Record<string, string>,
    postsMap: Record<string, string>,
) => {
    const keys = new Set(targets.map((item) => elementKey(item)));
    models.value.forEach((item) => {
        if (!keys.has(elementKey(item))) {
            return;
        }
        item.is_selected = false;
        item.is_recovering = false;
        if (item.type === 'post' && postsMap[item.id]) {
            item.url = postsMap[item.id];
        } else if (item.type !== 'post' && entitiesMap[item.id]) {
            item.url = entitiesMap[item.id];
        }
    });
};

const recoverElement = (model: Record<string, any>) => {
    if (!premium.value) {
        if (premiumDialog.value) {
            openDialog(premiumDialog.value);
        }
        return;
    }

    if (recovering.value) {
        return;
    }

    const target = models.value.find((f) => elementKey(f) === elementKey(model));
    if (!target) {
        return;
    }

    target.is_recovering = true;
    recovering.value = true;

    const data =
        target.type === 'post'
            ? { posts: [target.id], entities: [] }
            : { entities: [target.id], posts: [] };

    window.axios
        .post(recoveryApi.value, data)
        .then((res) => {
            recovering.value = false;
            applyRecoveredUrls([target], res.data.entities ?? {}, res.data.posts ?? {});
            if (typeof window.showToast === 'function' && res.data.toast) {
                window.showToast(res.data.toast);
            }
        })
        .catch(() => {
            recovering.value = false;
            target.is_recovering = false;
            if (typeof window.showToast === 'function') {
                window.showToast(trans('error'));
            }
        });
};

const bulkRecover = () => {
    if (!premium.value) {
        if (premiumDialog.value) {
            openDialog(premiumDialog.value);
        }
        return;
    }

    if (recovering.value) {
        return;
    }

    const targets = models.value.filter((f) => f.is_selected && !f.url);
    const ids = targets.filter((f) => f.type === 'entity').map((f) => f.id);
    const postIds = targets.filter((f) => f.type === 'post').map((f) => f.id);

    if (ids.length === 0 && postIds.length === 0) {
        return;
    }

    recovering.value = true;
    targets.forEach((f) => {
        f.is_recovering = true;
    });

    window.axios
        .post(recoveryApi.value, { entities: ids, posts: postIds })
        .then((res) => {
            recovering.value = false;
            applyRecoveredUrls(targets, res.data.entities ?? {}, res.data.posts ?? {});
            if (typeof window.showToast === 'function' && res.data.toast) {
                window.showToast(res.data.toast);
            }
        })
        .catch(() => {
            recovering.value = false;
            targets.forEach((f) => {
                f.is_recovering = false;
            });
            if (typeof window.showToast === 'function') {
                window.showToast(trans('error'));
            }
        });
};

const openDialog = (dialog: HTMLDialogElement) => {
    dialog.showModal();
    dialog.addEventListener('click', clickOutside);
};

const clickOutside = (event: MouseEvent) => {
    const target = event.target as HTMLElement | null;
    if (!target || target.tagName !== 'DIALOG') {
        return;
    }
    const rect = target.getBoundingClientRect();
    const isInDialog =
        rect.top <= event.clientY &&
        event.clientY <= rect.top + rect.height &&
        rect.left <= event.clientX &&
        event.clientX <= rect.left + rect.width;
    if (!isInDialog) {
        closeModal(target as HTMLDialogElement);
    }
};

const closeModal = (modal: HTMLDialogElement | null) => {
    if (!modal) {
        return;
    }
    modal.removeEventListener('click', clickOutside);
    modal.close();
};
</script>
