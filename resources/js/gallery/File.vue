<template>
    <div class="bg-base-100 p-2 md:p-4 rounded flex flex-col gap-2 md:gap-4 md:sticky md:top-24">
        <div
            v-if="loading"
            class="text-2xl flex items-center justify-center h-32"
        >
            <i class="fa-solid fa-spinner fa-spin" aria-label="Loading"></i>
        </div>
        <div class="flex flex-col gap-4" v-else-if="!focusing">
            <div class="flex items-center gap-2">
                <div class="flex items-center gap-1 grow">
                    <i class="fa-regular fa-clipboard" aria-hidden="true"></i>
                    <span class="font-extrabold" v-html="trans('details')"></span>
                </div>
                <div class="cursor-pointer" @click="closeFile">
                    <i class="fa-solid fa-xmark" aria-label="Close" />
                </div>
            </div>

            <div class="flex flex-col gap-1">
                <label class="font-extrabold" v-html="trans('name')"></label>
                <input
                    type="text"
                    class=""
                    maxlength="191"
                    v-model="name"
                    @change="updateName"
                    v-if="canManage"
                />
                <span v-else v-html="name"></span>
            </div>

            <div class="flex flex-col gap-1" v-if="canManage">
                <label class="font-extrabold flex gap-1 items-center">
                    <i class="fa-regular fa-users" aria-hidden="true" />
                    <span  v-html="trans('visibility')"></span>
                </label>
                <select
                    class="w-full"
                    v-model="visibility"
                    @change="updateVisibility"
                >
                    <option
                        v-for="(name, id) in visibilities"
                        :value="id"
                        v-html="name"
                    ></option>
                </select>
            </div>

            <div class="flex flex-col gap-1" v-if="!props.file.is_folder">
                <div
                    class="flex gap-2 items-center cursor-pointer"
                    @click="toggleMentions"
                >
                    <div class="grow font-bold flex gap-1 items-center">
                        <i class="fa-regular fa-cubes" aria-hidden="true" />
                        <span v-html="trans('used_in')"></span>
                    </div>
                    <i
                        class="fa-solid fa-chevron-up"
                        v-if="showMentions"
                        aria-label="Hide mentions"
                    />
                    <i
                        class="fa-solid fa-chevron-down"
                        v-else
                        aria-label="Show mentions"
                    />
                </div>

                <div class="flex flex-wrap gap-2" v-if="showMentions">
                    <a
                        v-for="mention in mentions"
                        :href="mention.url"
                        class="rounded-xl bg-base-200 px-4 py-1 flex gap-1 items-center"
                    >
                        <i
                            class="fa-regular fa-image"
                            v-if="mention.type === 'image'"
                            aria-hidden="true"
                        />
                        <i class="fa-regular fa-pen" v-else aria-hidden="true" />
                        <span class="truncate" v-html="mention.name"></span>
                    </a>
                    <span class="text-neutral-content" v-if="!hasMentions()" v-html="trans('unused')"></span>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-2" v-if="!props.file.is_folder">
                <div class="text-neutral-content" v-html="trans('size')"></div>
                <div class="text-right" v-html="file.size"></div>

                <div class="text-neutral-content" v-html="trans('uploaded_by')"></div>
                <div class="text-right" v-html="file.creator"></div>

                <div class="text-neutral-content" v-html="trans('file_type')"></div>
                <div class="text-right uppercase" v-html="file.ext"></div>

                <div class="text-neutral-content" v-html="trans('link')"></div>
                <a :href="file.link" class="flex gap-1 items-center justify-end" target="_blank">
                    <i class="fa-solid fa-external-link" aria-hidden="true" />
                    <span v-html="trans('open')"></span>
                </a>
            </div>

            <div class="flex gap-2 items-center justify-between">
                <i
                    class="fa-solid fa-spinner fa-spin text-error"
                    v-if="deleting"
                    aria-label="Deleting"
                ></i>
                <span role="button"
                    class="text-neutral-content hover:text-error-content hover:bg-error flex items-center gap-1 p-2 rounded"
                    @click="deleteFile"
                    v-else-if="canManage"
                >
                    <i class="fa-regular fa-trash-can" aria-hidden="true" />
                    <span v-if="!confirmed" v-html="trans('delete')"></span>
                    <span v-else v-html="trans('confirm')"></span>
                </span>

                <button v-if="!props.file.is_folder && canManage"
                    @click="focus"
                    class="rounded border p-2 flex gap-1 items-center"
                >
                    <i class="fa-regular fa-bullseye" aria-hidden="true" />
                    <span class="truncate" v-html="trans('focus_point')"></span>
                </button>

                <div class="grow text-right text-neutral-content" v-if="saving">
                    <i
                        class="fa-solid fa-spinner fa-spin"
                        aria-hidden="true"
                    ></i>
                    <span  v-html="trans('saving')"></span>
                </div>
            </div>
            <div
                class="text-right text-neutral-content flex gap-1 self-end items-center text-xs"
                v-if="saved"
            >
                <i class="fa-regular fa-check-double" aria-hidden="true"></i>
                <span v-html="trans('saved')"></span>
            </div>
        </div>
        <div v-else class="flex flex-col gap-4 overflow-hidden">
            <div class="alert alert-warning p-4 flex flex-col gap-2" v-if="!props.premium">
                <p v-html="trans('focus_locked')"></p>
                <a href="https://kanka.io/premium">Learn more</a>
            </div>
            <div v-else class="max-w-[8rem] flex items-center justify-center">
                <div class="relative inline-block">
                    <div
                        class="absolute cursor-pointer text-4xl text-accent "
                        :style="focusStyle()"
                        @click="resetFocus"
                    >
                        <i
                            class="fa-duotone fa-arrow-up-left-from-circle hover:text-error"
                            aria-label="Focus point"
                        />
                    </div>

                    <img
                        class="cursor-crosshair"
                        :src="props.file.original"
                        alt="img"
                        ref="focusImage"
                        @click="setFocus"
                    />
                </div>
            </div>

            <div class="flex gap-2 items-center flex-wrap justify-between">
                <button class="btn2 btn-primary btn-sm"
                    @click="saveFocus"
                        v-if="premium"
                >
                    <span v-html="trans('save')"></span>
                </button>
                <button class="btn2 btn-ghost btn-sm" @click="cancelFocus"  v-html="trans('cancel')">
                </button>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { onMounted, ref, watch } from "vue";
import {toInteger} from "lodash";

const props = defineProps<{
    file: Object;
    visibilities: Object;
    i18n: Object;
    premium: Boolean;
    canManage: Boolean;
}>();

const emit = defineEmits(["updated", "deleted", "moved", "closed"]);

const mentions = ref();
const name = ref();
const saving = ref(false);
const saved = ref(false);
const visibility = ref();
const loading = ref(true);
const deleting = ref(false);
const confirmed = ref(false);
const showMentions = ref(true);
const focusing = ref(false);
const focusImage = ref();
const focusX = ref();
const focusY = ref();

watch(
    () => props.file,
    (newVal, oldVal) => {
        if (newVal) {
            open();
        }
    },
);

onMounted(() => {
    open();
});

const trans = (key) => {
    if (props.i18n[key]) {
        return props.i18n[key];
    }
    return '_' + key + '_';
}

const open = () => {
    loading.value = true;
    saving.value = false;
    saved.value = false;
    name.value = props.file.name;
    visibility.value = props.file.visibility_id;
    focusX.value = props.file.focus_x;
    focusY.value = props.file.focus_y;
    deleting.value = false;
    confirmed.value = false;
    focusing.value = false;
    axios.get(props.file.api.show).then((res) => {
        mentions.value = res.data.data.mentions;
        loading.value = false;
    });
};

const updateName = () => {
    if (name.value === props.file.name) {
        return;
    }
    update();
};
const updateVisibility = () => {
    if (visibility.value === props.file.visibility_id) {
        return;
    }
    update();
};

const update = () => {
    if (saving.value) {
        return;
    }
    saving.value = true;
    const data = {
        name: name.value,
        visibility_id: visibility.value,
    };
    axios.post(props.file.api.update, data).then((res) => {
        props.file.name = name.value;
        props.file.visibility_id = visibility.value;
        props.file.visibility = res.data.data.visibility;
        saving.value = false;
        saved.value = true;
        emit("updated", props.file);
    });
};

const toggleMentions = () => {
    showMentions.value = !showMentions.value;
};

const hasMentions = () => {
    return mentions.value.length > 0;
};

const deleteFile = () => {
    if (deleting.value) {
        return;
    } else if (!confirmed.value) {
        confirmed.value = true;
        return;
    }

    deleting.value = true;
    axios.post(props.file.api.delete, {'_method': 'delete'}).then((res) => {
        window.showToast("Removed " + props.file.name);
        emit("deleted", props.file, res.data.used);
    });
};

const closeFile = () => {
    emit("closed");
};

const focus = () => {
    focusing.value = true;
};

const cancelFocus = () => {
    focusing.value = false;
};

const setFocus = (event) => {
    // Get the original dimensions of the image
    const originalWidth = focusImage.value.naturalWidth;
    const originalHeight = focusImage.value.naturalHeight;

    // Get the click coordinates
    const clickX =
        event.clientX - focusImage.value.getBoundingClientRect().left;
    const clickY = event.clientY - focusImage.value.getBoundingClientRect().top;

    // Calculate the coordinates with respect to the original size
    const originalX = (clickX / focusImage.value.clientWidth) * originalWidth;
    const originalY = (clickY / focusImage.value.clientHeight) * originalHeight;

    // Calculate the coordinates as a percentage, so that the focus point can be placed correctly to scale
    const percentageX = (originalX / originalWidth) * 100;
    const percentageY = (originalY / originalHeight) * 100;

    focusX.value = toInteger(originalX);
    focusY.value = toInteger(originalY);
};

const focusStyle = (event) => {
    if (!focusX.value || !focusImage.value) {
        return "display: none;";
    }

    // Get the original dimensions of the image
    const originalWidth = focusImage.value.naturalWidth;
    const originalHeight = focusImage.value.naturalHeight;

    // Calculate the coordinates as a percentage, so that the focus point can be placed correctly to scale
    const percentageX = (focusX.value / originalWidth) * 100;
    const percentageY = (focusY.value / originalHeight) * 100;

    return "left: " + percentageX + "%; top: " + percentageY + "%";
};

const resetFocus = () => {
    focusX.value = null;
    focusY.value = null;
    saveNewFocus();
}

const saveFocus = () => {
    saveNewFocus();
}

const saveNewFocus = () => {
    if (saving.value) {
        return;
    }
    saving.value = true;
    focusing.value = false;

    const data = {
        focus_x: focusX.value,
        focus_y: focusY.value,
    };
    axios.post(props.file.api.focus, data).then((res) => {
        saving.value = false;
        saved.value = true;
        props.file.focus_x = focusX.value;
        props.file.focus_y = focusY.value;
        console.log(res.data);
        props.file.thumbnail = res.data.data.thumbnail
        emit("updated", props.file);
    });
}
</script>
