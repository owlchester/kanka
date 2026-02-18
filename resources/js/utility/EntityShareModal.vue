<template>
    <div class="dialog rounded-2xl text-center bg-base-100 text-base-content overflow-hidden">
        <header class="flex gap-6 items-center p-4 md:p-6 justify-between border-b border-base-300">
            <h4 class="text-lg font-normal">{{ trans.title }}</h4>
            <button type="button" class="text-base-content opacity-50 hover:opacity-100" :title="trans.btn_close" @click="closeModal">
                <i class="fa-regular fa-circle-xmark" aria-hidden="true"></i>
                <span class="sr-only">{{ trans.btn_close }}</span>
            </button>
        </header>

        <article class="max-w-4xl flex flex-col gap-4 text-left p-4 md:px-6">
            <div v-if="errorMessage" class="alert alert-error text-sm rounded-xl">
                <i class="fa-solid fa-circle-exclamation"></i>
                <span>{{ errorMessage }}</span>
            </div>

            <!-- Public campaign -->
            <div v-if="isCampaignPublic">
                <!-- Entity not readable by public -->
                <div v-if="isEntityPrivate" class="flex flex-col gap-4">
                    <div class="p-3 bg-warning/10 border border-warning/20 rounded-xl">
                        <div class="text-sm text-warning font-bold mb-1 flex items-center">
                            <i class="fa-solid fa-eye-slash mr-2"></i>
                            {{ trans.status_hidden }}
                        </div>
                        <p class="text-xs text-neutral-content leading-relaxed">
                            {{ trans.helper_hidden }}
                        </p>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="font-normal">{{ trans.field_visibility_mode }}</label>
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
                </div>

                <!-- Entity is public -->
                <div v-else class="p-4 bg-success/10 border border-success/20 rounded-xl">
                    <div class="text-sm text-success font-bold mb-1 flex items-center">
                        <i class="fa-solid fa-globe mr-2"></i>
                        {{ trans.status_public }}
                    </div>
                    <p class="text-xs text-neutral-content">
                        {{ trans.helper_public }}
                    </p>
                </div>
            </div>

            <!-- Private campaign -->
            <div v-else class="flex flex-col gap-4">
                <div class="p-3 bg-base-300/30 border border-base-300 rounded-xl">
                    <div class="text-sm text-neutral-content font-bold mb-1 flex items-center">
                        <i class="fa-solid fa-lock mr-2"></i>
                        {{ trans.status_private }}
                    </div>
                    <p class="text-xs text-neutral-content">
                        {{ trans.helper_private }}
                    </p>
                </div>

                <div class="p-3 bg-info/10 border border-info/20 rounded-xl text-xs text-neutral-content leading-relaxed">
                    <i class="fa-solid fa-circle-info mr-1 text-info"></i>
                    {{ trans.warning_entity_permissions }}
                </div>
            </div>

            <!-- Link section (always visible) -->
            <div class="flex flex-col gap-1 mt-2">
                <label class="font-normal">{{ isEntityPublic ? trans.label_public_link : trans.label_member_link }}</label>
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
            </div>
        </article>

        <footer class="p-4 md:px-6 border-t border-base-300 mt-2">
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
    </div>
</template>

<script>
import axios from 'axios';

export default {
    props: {
        initialCampaignPublic: { type: Boolean, required: true },
        initialEntityPrivate: { type: Boolean, required: true },
        url: { type: String, required: true },
        saveEndpoint: { type: String, required: true },
        trans: { type: Object, required: true }
    },
    data() {
        return {
            loading: false,
            errorMessage: null,
            isCampaignPublic: this.initialCampaignPublic,
            isEntityPrivate: this.initialEntityPrivate,
            form: {
                visibility_mode: 'entity',
            }
        };
    },
    mounted() {
        window.triggerEvent();
    },
    computed: {
        isEntityPublic() {
            return this.isCampaignPublic && !this.isEntityPrivate;
        },
        clipboardToast() {
            return this.isEntityPublic
                ? this.trans.success_copied_public
                : this.trans.success_copied_members;
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
                    this.isCampaignPublic = true;
                    this.isEntityPrivate = true;
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
