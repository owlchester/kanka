<template>
    <div>
        <header class="flex gap-6 items-center p-4 md:p-6 justify-between">
            <h4 class="text-lg font-normal">{{ trans.title }}</h4>
            <button type="button" class="text-2xl opacity-60 hover:opacity-100 hover:bg-base-200 focus:bg-base-200 cursor-pointer w-8 h-8 flex items-center justify-center rounded-lg" :title="trans.btn_close" @click="closeModal" aria-label="Close dialog">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"></path>
                </svg>
            </button>
        </header>

        <article class="max-w-2xl flex flex-col gap-4 py-4 px-4 md:px-6">
            <div v-if="errorMessage" class="alert alert-error p-4 flex gap-2 rounded-2xl">
                <i class="fa-solid fa-circle-exclamation shrink-0"></i>
                <span>{{ errorMessage }}</span>
            </div>

            <!-- Private campaign -->
            <div v-if="!isCampaignPublic" class="flex flex-col gap-4">
                <div class="alert alert-info p-4 flex gap-2 rounded-2xl">
                    <i class="fa-solid fa-lock shrink-0 mt-0.5"></i>
                    <div class="flex flex-col gap-1">
                        <span class="text-sm font-bold">{{ trans.status_private }}</span>
                        <p class="text-xs">{{ trans.helper_private }}</p>
                    </div>
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

            <!-- Unlisted or public campaign -->
            <div v-else class="flex flex-col gap-4">
                <!-- Unlisted status -->
                <div v-if="isCampaignUnlisted" class="alert alert-success p-4 flex gap-2 rounded-2xl">
                    <i class="fa-solid fa-link shrink-0 mt-0.5"></i>
                    <div class="flex flex-col gap-1">
                        <span class="text-sm font-bold">{{ trans.status_unlisted }}</span>
                        <p class="text-xs">{{ trans.helper_unlisted }}</p>
                    </div>
                </div>
                <!-- Public status -->
                <div v-else class="alert alert-success p-4 flex gap-2 rounded-2xl">
                    <i class="fa-solid fa-globe shrink-0 mt-0.5"></i>
                    <div class="flex flex-col gap-1">
                        <span class="text-sm font-bold">{{ trans.status_public }}</span>
                        <p class="text-xs">{{ trans.helper_public }}</p>
                    </div>
                </div>

                <!-- Public/unlisted link -->
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

        <footer class="p-4 md:px-6">
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
        initialVisibility: { type: String, required: true }, // 'private', 'public', 'unlisted'
        url: { type: String, required: true },
        saveEndpoint: { type: String, required: true },
        settingsUrl: { type: String, required: true },
        trans: { type: Object, required: true }
    },
    data() {
        return {
            loading: false,
            errorMessage: null,
            visibility: this.initialVisibility,
        };
    },
    computed: {
        isCampaignPublic() {
            return this.visibility === 'public' || this.visibility === 'unlisted';
        },
        isCampaignUnlisted() {
            return this.visibility === 'unlisted';
        },
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

                this.visibility = 'public';

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
