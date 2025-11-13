<template>
    <dialog
        v-if="loaded"
        class="dialog rounded-2xl bg-base-100 text-base-content" id="onboarding-dialog" ref="onboardingDialog" aria-modal="true" aria-labelledby="modal-card-label"    @click="onBackdropClick
"
>
        <header class="flex gap-6 items-center p-4 md:p-6 justify-between">
            <h4 v-html="trans('title')" class="text-lg font-normal"></h4>
            <button type="button" class="text-base-content" @click="close()" title="Close">
                <i class="fa-regular fa-circle-xmark" aria-hidden="true"></i>
                <span class="sr-only">Close</span>
            </button>
        </header>
        <article class="max-w-4xl p-4">
            <div class="flex flex-col gap-4 lg:gap-6">
                <p class="text-neutral-content" v-html="trans('intro')"></p>

                <div class="flex flex-col gap-1">
                    <label for="name" v-html="trans('name')"></label>
                    <input
                        type="text"
                        name="name"
                        id="name"
                        ref="nameField"
                        class=""
                        v-model="name"
                        :placeholder="trans('name')"
                        data-1p-ignore="true"
                    />
                        <p class="text-xs text-neutral-content" v-html="trans('placeholder')"></p>
                    <p v-if="errorMessage" v-html="errorMessage" class="text-error"></p>
                </div>

                <div class="flex flex-col gap-2">
                    <h3 v-html="trans('type-title')">
                    </h3>
                    <p v-html="trans('type-intro')"></p>

                    <div class="flex flex-col gap-4">
                        <div :class="typeClass('worldbuilding')" @click="select('worldbuilding')" tabindex="0" @keydown="handleKeydown($event, 'worldbuilding')">
                            <i class="fa-regular fa-check-square text-xl" aria-label="Selected" v-if="selected === 'worldbuilding'"></i>
                            <i class="fa-regular fa-globe text-xl" aria-hidden="true" v-else></i>
                            <div class="flex flex-col gap-1">
                                <span class="text-lg" v-html="trans('worldbuilding')"></span>
                                <p class="text-xs text-neutral-content" v-html="trans('worldbuilding-description')"></p>
                            </div>
                        </div>
                        <div :class="typeClass('campaign')" @click="select('campaign')" tabindex="0" @keydown="handleKeydown($event, 'campaign')">
                            <i class="fa-regular fa-check-square text-xl" aria-label="Selected" v-if="selected === 'campaign'"></i>
                            <i class="fa-regular fa-dice-d20 text-xl" aria-hidden="true" v-else></i>
                            <div class="flex flex-col gap-1">
                                <span class="text-lg" v-html="trans('campaign')"></span>
                                <p class="text-xs text-neutral-content" v-html="trans('campaign-description')"></p>
                            </div>
                        </div>
                        <div :class="typeClass('story')" @click="select('story')" tabindex="0" @keydown="handleKeydown($event, 'story')">
                            <i class="fa-regular fa-check-square text-xl" aria-label="Selected" v-if="selected === 'story'"></i>
                            <i class="fa-regular fa-pen-fancy text-xl" aria-hidden="true" v-else></i>
                            <div class="flex flex-col gap-1">
                                <span class="text-lg" v-html="trans('story')"></span>
                                <p class="text-xs text-neutral-content" v-html="trans('story-description')"></p>
                            </div>
                        </div>
                    </div>

                    <p class="text-xs text-neutral-content" v-html="trans('type-helper')">
                    </p>
                </div>
            </div>

            <div class="flex justify-between w-full gap-4 items-center mt-6">
                <button class="btn2 btn-sm btn-outline" @click="skip()" v-html="trans('skip')">
                </button>

                <button
                    class="btn2 btn-primary"
                    @click="save()"
                    v-if="!saving"
                    v-html="trans('continue')">
                </button>
                <span
                    class="btn2 btn-primary btn-disabled"
                    disabled="disabled"
                    v-else>
                    <i class="fa-solid fa-spinner fa-spin" aria-label="Saving"></i>
                </span>
            </div>
        </article>
    </dialog>
</template>

<script setup lang="ts">
import {onMounted, ref, nextTick} from "vue"

const props = defineProps<{
    api: undefined,
    skip: undefined,
    i18n: undefined,
    campaign: undefined,
}>()

const onboardingDialog = ref(null)
const name = ref('')
const nameField = ref(null)
const translations = ref()
const loaded = ref(false)
const selected = ref()
const saving = ref(false)
const errorMessage = ref()

const trans = (key) => {
    return translations.value[key] ?? 'unknown'
}


const close = () => {
    window.closeDialog('onboarding-dialog')
}
const onBackdropClick = (event) => {
    // Check if the click was directly on the dialog (backdrop), not on its children
    if (event.target === onboardingDialog.value) {
        close();
    }
}


const skip = () =>  {
    axios.post(props.skip);
    close()
}

const save = () => {
    if (saving.value) {
        return;
    }
    saving.value = true;

    let data = {
        name: name.value,
        type: selected.value,
    }
    axios.post(props.api, data)
        .then(response => {
            if (response.data.redirect) {
                window.location.href = response.data.redirect;
            } else {
                close();
            }
        })
        .catch(error => {
            if (error.response.data.message) {
                errorMessage.value = error.response.data.message;
                nameField.value.focus();
                nameField.value.scrollIntoView({ behavior: 'smooth' });
            } else {
                console.error('onboarding saving error', error);
            }
            saving.value = false;
        })
}

const select = (type) => {
    selected.value = type;
}

const typeClass = (type) => {
    let css = 'flex items-center gap-4 rounded-xl border p-2 px-4 hover:border-primary hover:text-primary focus:border-primary focus:text-primary';
    if (selected.value !== type) {
        return css + ' cursor-pointer';
    }

    return css + 'border-primary text-primary';
}

const handleKeydown = (event, type) => {
    if (event.key === 'Enter' || event.key === ' ') {
        event.preventDefault(); // Prevent page scroll on space
        select(type);
    }
}


onMounted(async () => {
    translations.value = JSON.parse(props.i18n)
    name.value = props.campaign
    loaded.value = true
    await nextTick()
    onboardingDialog.value.showModal()
})
</script>
