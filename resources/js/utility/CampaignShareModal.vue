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

            <!-- Private campaign -->
            <div v-if="!isCampaignPublic" class="flex flex-col gap-4">
                <div class="p-3 bg-base-300/30 border border-base-300 rounded-xl">
                    <div class="text-sm text-neutral-content font-bold mb-1 flex items-center">
                        <i class="fa-solid fa-lock mr-2"></i>
                        {{ trans.status_private }}
                    </div>
                    <p class="text-xs text-neutral-content">
                        {{ trans.helper_private }}
                    </p>
                </div>

                <!-- Member link -->
                <div class="flex flex-col gap-1">
                    <label class="font-normal text-sm">{{ trans.label_member_link }}</label>
                    <div class="flex items-center gap-2">
                        <input
                            type="text"
                            class="input input-bordered w-full text-sm font-mono bg-base-200"
                            readonly
                            :value="url"
                        />
                        <button
                            class="btn2 btn-sm btn-outline shrink-0"
                            :data-clipboard="url"
                            :data-toast="trans.success_copied_members"
                            :title="trans.btn_copy"
                        >
                            <i class="fa-solid fa-copy"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Public campaign -->
            <div v-else class="flex flex-col gap-4">
                <div class="p-4 bg-success/10 border border-success/20 rounded-xl">
                    <div class="text-sm text-success font-bold mb-1 flex items-center">
                        <i class="fa-solid fa-globe mr-2"></i>
                        {{ trans.status_public }}
                    </div>
                    <p class="text-xs text-neutral-content">
                        {{ trans.helper_public }}
                    </p>
                </div>

                <!-- Public link -->
                <div class="flex flex-col gap-1">
                    <label class="font-normal text-sm">{{ trans.label_public_link }}</label>
                    <div class="flex items-center gap-2">
                        <input
                            type="text"
                            class="input input-bordered w-full text-sm font-mono bg-base-200"
                            readonly
                            :value="url"
                        />
                        <button
                            class="btn2 btn-sm btn-outline shrink-0"
                            :data-clipboard="url"
                            :data-toast="trans.success_copied_public"
                            :title="trans.btn_copy"
                        >
                            <i class="fa-solid fa-copy"></i>
                        </button>
                    </div>
                </div>
            </div>
        </article>

        <footer class="p-4 md:px-6 border-t border-base-300 mt-2">
            <menu class="flex justify-end gap-3">
                <button
                    v-if="isCampaignPublic"
                    type="button"
                    class="btn2 btn-sm btn-outline"
                    @click="openVisibilityDialog"
                >
                    {{ trans.btn_change_visibility }}
                </button>
                <button
                    v-if="!isCampaignPublic"
                    type="submit"
                    class="btn2 btn-primary"
                    :disabled="loading"
                    @click="makePublic"
                >
                    <span v-if="loading" class="loading loading-spinner loading-xs mr-2"></span>
                    {{ trans.btn_make_public }}
                </button>
                <button
                    v-else
                    type="button"
                    class="btn2 btn-primary"
                    :data-clipboard="url"
                    :data-toast="trans.success_copied_public"
                    @click="closeModal"
                >
                    {{ trans.btn_copy_public_link }}
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
        url: { type: String, required: true },
        saveEndpoint: { type: String, required: true },
        settingsUrl: { type: String, required: true },
        trans: { type: Object, required: true }
    },
    data() {
        return {
            loading: false,
            errorMessage: null,
            isCampaignPublic: this.initialCampaignPublic,
        };
    },
    mounted() {
        window.triggerEvent?.();
    },
    methods: {
        async makePublic() {
            this.loading = true;
            this.errorMessage = null;

            try {
                await axios.post(this.saveEndpoint, { campaign_visibility: 'public' });

                this.isCampaignPublic = true;

                // Copy the link to clipboard and show toast
                if (navigator.clipboard) {
                    await navigator.clipboard.writeText(this.url);
                } else {
                    const el = document.createElement('textarea');
                    el.value = this.url;
                    document.body.appendChild(el);
                    el.select();
                    document.execCommand('copy');
                    document.body.removeChild(el);
                }

                window.showToast(this.trans.success_copied_public);
                this.closeModal();

            } catch (error) {
                console.error(error);
                this.errorMessage = error.response?.data?.message || this.trans.error_generic;
            } finally {
                this.loading = false;
            }
        },
        openVisibilityDialog() {
            window.openDialog('primary-dialog', this.settingsUrl);
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
