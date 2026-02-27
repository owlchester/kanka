<template>
    <header class="flex gap-6 items-center p-4 md:p-6 justify-between">
        <h4 class="text-lg font-normal">{{ trans.title }}</h4>
        <button type="button" class="text-2xl opacity-60 hover:opacity-100 hover:bg-base-200 focus:bg-base-200 cursor-pointer w-8 h-8 flex items-center justify-center rounded-lg" :title="trans.btn_close" @click="closeModal" aria-label="Close dialog">
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"></path>
            </svg>
        </button>
    </header>

    <div class="container">
        <article class="max-w-2xl flex flex-col gap-4 py-4 px-4 md:px-6">
            <div v-if="errorMessage" class="alert alert-error p-4 flex gap-2 rounded-2xl">
                <i class="fa-solid fa-circle-exclamation shrink-0"></i>
                <span>{{ errorMessage }}</span>
            </div>

            <div v-if="justMadeCampaignPublic" class="alert alert-info p-4 flex gap-2 rounded-2xl">
                <i class="fa-solid fa-circle-info shrink-0 mt-0.5"></i>
                <p class="text-sm">{{ trans.warning_entity_permissions }}</p>
            </div>

            <!-- Public campaign -->
            <template v-if="isCampaignPublic">
                <!-- Entity not readable by public -->
                <template v-if="isEntityPrivate">
                    <div class="alert alert-warning p-4 flex gap-2 rounded-2xl">
                        <i class="fa-solid fa-eye-slash shrink-0 mt-0.5"></i>
                        <div class="flex flex-col gap-1">
                            <span class="text-sm font-bold">{{ trans.status_hidden }}</span>
                            <p class="text-xs">{{ entityHiddenHelper }}</p>
                        </div>
                    </div>

                    <div class="flex flex-col gap-1 w-full">
                        <label class="font-semibold text-xs opacity-80">{{ trans.field_visibility_mode }}</label>
                        <div class="flex flex-col gap-2">
                            <label class="flex items-center gap-3 p-3 border border-base-300 rounded-xl cursor-pointer hover:bg-base-200 transition">
                                <input type="radio" name="visibility_mode" value="entity" class="radio radio-primary radio-sm" v-model="form.visibility_mode">
                                <span class="text-sm">{{ trans.option_entity_public }}</span>
                            </label>
                            <label class="flex items-center gap-3 p-3 border border-base-300 rounded-xl cursor-pointer hover:bg-base-200 transition">
                                <input type="radio" name="visibility_mode" value="global" class="radio radio-primary radio-sm" v-model="form.visibility_mode">
                                <span class="text-sm">{{ trans.option_global_public }}</span>
                            </label>
                        </div>
                    </div>
                </template>

                <!-- Entity is visible -->
                <div v-else class="alert alert-success p-4 flex gap-2 rounded-2xl">
                    <i :class="isCampaignUnlisted ? 'fa-solid fa-link' : 'fa-solid fa-globe'" class="shrink-0 mt-0.5"></i>
                    <div class="flex flex-col gap-1">
                        <span class="text-sm font-bold">{{ entityVisibleStatus }}</span>
                        <p class="text-xs">{{ entityVisibleHelper }}</p>
                    </div>
                </div>
            </template>

            <!-- Private campaign -->
            <template v-else>
                <div class="alert alert-warning p-4 flex gap-2 rounded-2xl">
                    <i class="fa-solid fa-lock shrink-0 mt-0.5"></i>
                    <div class="flex flex-col gap-1">
                        <span class="text-sm font-bold">{{ trans.status_private }}</span>
                        <p class="text-xs">{{ trans.helper_private }}</p>
                    </div>
                </div>

                <div class="alert alert-info p-4 flex gap-2 rounded-2xl">
                    <i class="fa-solid fa-circle-info shrink-0 mt-0.5"></i>
                    <p class="text-sm">{{ trans.warning_entity_permissions }}</p>
                </div>
            </template>

            <!-- Link section (always visible) -->
            <div class="flex flex-col gap-1 w-full">
                <label class="font-semibold text-xs opacity-80">{{ isEntityPublic ? trans.label_public_link : trans.label_member_link }}</label>
                <div class="flex items-center gap-2">
                    <input
                        type="text"
                        class="input input-bordered w-full text-sm font-mono bg-base-200"
                        readonly
                        :value="url"
                    />
                    <button class="btn2 btn-sm btn-outline shrink-0" :data-clipboard="url" :data-toast="clipboardToast" :title="trans.btn_copy">
                        <i class="fa-solid fa-copy"></i>
                    </button>
                </div>
                <p class="text-xs text-neutral-content" v-if="!isEntityPublic" v-html="trans.helper_member_link"></p>
            </div>
        </article>

    </div>
    <footer class="p-4 md:px-6">
        <menu class="flex justify-end gap-3">
            <button
                v-if="showSaveButton"
                type="submit"
                class="btn2 btn-primary"
                :disabled="loading"
                @click="saveChanges"
            >
                <span v-if="loading" class="loading loading-spinner loading-xs mr-2"></span>
                {{ isCampaignPublic ? trans.btn_save : trans.btn_make_public }}
            </button>
        </menu>
    </footer>
</template>

<script>
import axios from 'axios';

export default {
    props: {
        initialCampaignVisibility: { type: String, required: true }, // 'private', 'public', 'unlisted'
        initialEntityPrivate: { type: Boolean, required: true },
        url: { type: String, required: true },
        saveEndpoint: { type: String, required: true },
        trans: { type: Object, required: true }
    },
    data() {
        return {
            loading: false,
            errorMessage: null,
            justMadeCampaignPublic: false,
            campaignVisibility: this.initialCampaignVisibility,
            isEntityPrivate: this.initialEntityPrivate,
            form: {
                visibility_mode: 'entity',
            }
        };
    },
    mounted() {
        window.triggerEvent?.();
    },
    computed: {
        isCampaignPublic() {
            return this.campaignVisibility === 'public' || this.campaignVisibility === 'unlisted';
        },
        isEntityPublic() {
            return this.isCampaignPublic && !this.isEntityPrivate;
        },
        clipboardToast() {
            return this.isEntityPublic
                ? this.trans.success_copied_public
                : this.trans.success_copied_members;
        },
        isCampaignUnlisted() {
            return this.campaignVisibility === 'unlisted';
        },
        entityVisibleStatus() {
            return this.isCampaignUnlisted ? this.trans.status_unlisted : this.trans.status_public;
        },
        entityVisibleHelper() {
            return this.isCampaignUnlisted ? this.trans.helper_unlisted : this.trans.helper_public;
        },
        entityHiddenHelper() {
            return this.isCampaignUnlisted ? this.trans.helper_hidden_unlisted : this.trans.helper_hidden;
        },
        showSaveButton() {
            // Public campaign with private entity: always show (radio defaults to 'entity')
            if (this.isCampaignPublic) {
                return this.isEntityPrivate;
            }
            // Private campaign: always show "Make campaign public" action
            return true;
        },
    },
    methods: {
        async saveChanges() {
            this.loading = true;
            this.errorMessage = null;

            try {
                let payload = {};

                if (this.isCampaignPublic) {
                    payload.visibility_mode = this.form.visibility_mode;
                } else {
                    payload.campaign_visibility = 'public';
                }

                const response = await axios.post(this.saveEndpoint, payload);

                if (this.isCampaignPublic) {
                    this.isEntityPrivate = false;
                } else {
                    this.campaignVisibility = 'public';
                    this.isEntityPrivate = true;
                    this.justMadeCampaignPublic = true;
                }

                window.showToast(this.trans.success_updated);

                this.$emit('updated', response.data);

            } catch (error) {
                console.error(error);
                this.errorMessage = error.response?.data?.message || this.trans.error_generic;
            } finally {
                this.loading = false;
            }
        },
        closeModal() {
            const dialog = this.$el.closest('dialog');
            if (dialog) {
                dialog.close();
            }
        },
    }
}
</script>
