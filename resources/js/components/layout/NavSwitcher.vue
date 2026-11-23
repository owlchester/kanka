<template>
    <div class="nav-switcher flex min-w-0 items-center justify-center align-middle h-12 gap-1">
        <button v-if="!impersonation" type="button" class="campaigns btn2 btn-ghost btn-square size-9.5! min-h-9.5! inline-flex items-center justify-center text-2xl hover:text-primary-focus" :class="campaign_name ? 'max-md:hidden!' : ''" v-on:click="openCampaigns()" :aria-label="campaigns_label" :aria-expanded="is_expanded && view_campaigns">
            <GridSvg :size="6" />
        </button>
        <button v-if="impersonation" type="button" class="flex min-h-9 max-w-52 items-center gap-2 rounded-lg bg-warning px-3 text-sm font-semibold text-warning-content hover:bg-warning/90" @click="openProfile()" :aria-label="impersonation.label" :aria-expanded="is_expanded">
            <span class="truncate max-md:hidden">{{ impersonation.label }}</span>
            <span class="truncate md:hidden">{{ impersonation.shortLabel }}</span>
            <i class="fa-regular fa-angle-down shrink-0" aria-hidden="true"></i>
        </button>
        <button v-else type="button" class="profile btn2 btn-ghost btn-square size-9.5! min-h-9.5! shrink-0 flex items-center justify-center text-center uppercase" v-on:click="openProfile()" aria-label="Profile settings" :aria-expanded="is_expanded && view_profile">
            <div class="indicator relative inline-flex w-max">
                <span class="notification-badge left-auto top-auto -right-[0.2rem] -bottom-[0.2rem] translate-x-1/2 leading-2 w-fit inline-flex absolute content-center items-center z-10" v-if="show_alerts"></span>
                <div class="profile-box w-8 h-8 flex items-center justify-center rounded-lg text-center font-bold" v-if="showInitials()">
                    {{ initials }}
                </div>
                <UserSvg class="w-8 h-8 text-base-content" v-else-if="isDefaultAvatar()" />
                <div class="w-8 h-8 rounded-lg cover-background" v-bind:style="{backgroundImage: profilePictureUrl()}" v-else></div>
            </div>
        </button>
    </div>
    <Teleport to="body">
        <Transition name="nav-fade">
            <button
                v-if="is_expanded"
                type="button"
                class="fixed inset-0 z-1050 bg-black/30 backdrop-blur-[2px] cursor-default"
                aria-label="Close navigation popout"
                @click.stop="closeDrawer()"
            ></button>
        </Transition>
        <Transition name="nav-drawer">
            <div
                v-if="is_expanded"
                v-click-outside="onClickOutside"
                class="navigation-drawer w-[86%] md:w-92 z-1051 bg-base-100 text-base-content fixed inset-y-0 right-0 rounded-l-2xl md:inset-y-3 md:right-3 md:rounded-2xl [body.has-sidebar_&]:md:left-3 [body.has-sidebar_&]:md:right-auto shadow-2xl ring-1 ring-base-content/10 flex flex-col overflow-hidden"
            >
                <div v-if="impersonation" class="flex flex-col gap-4 overflow-y-auto p-5">
                    <button type="button" class="absolute right-3 top-3 flex size-9 items-center justify-center rounded-xl bg-base-100 hover:bg-base-200 transition-colors cursor-pointer" :aria-label="close_label" @click="closeDrawer()">
                        <i class="fa-regular fa-times" aria-hidden="true"></i>
                    </button>
                    <div class="pr-11 font-semibold wrap-anywhere">{{ impersonation.label }}</div>
                    <a :href="impersonation.returnUrl" class="flex min-h-11 items-center gap-3 text-link">
                        <i class="fa-regular fa-sign-out-alt" aria-hidden="true"></i>
                        {{ impersonation.returnLabel }}
                    </a>
                    <ImpersonationRoles :impersonation="impersonation" />
                </div>
                <div class="temporary p-10 text-center text-base-content/60" v-else-if="is_loading">
                    <i class="fa-solid fa-spinner fa-spin text-lg" aria-hidden="true"></i>
                </div>
                <template v-else>
                    <div class="flex items-center gap-2 p-3 border-b border-base-content/10 flex-none">
                        <div class="bg-base-200 p-1 rounded-xl flex items-center gap-1 grow min-w-0">
                            <button
                                type="button"
                                class="flex-1 min-w-0 px-3 py-1.5 rounded-lg text-sm flex items-center justify-center gap-2 transition-all cursor-pointer"
                                :class="view_campaigns ? 'bg-base-100 text-base-content shadow-xs font-medium' : 'text-base-content/65 hover:text-base-content'"
                                @click="openCampaigns()"
                                aria-label="Campaign list"
                            >
                                <i class="fa-regular fa-earth-americas text-xs shrink-0" aria-hidden="true"></i>
                                <span class="truncate">{{ campaigns_label }}</span>
                            </button>
                            <button
                                type="button"
                                class="flex-1 min-w-0 px-3 py-1.5 rounded-lg text-sm flex items-center justify-center gap-2 transition-all cursor-pointer"
                                :class="view_profile ? 'bg-base-100 text-base-content shadow-xs font-medium' : 'text-base-content/65 hover:text-base-content'"
                                @click="openProfile()"
                                aria-label="Profile pane"
                            >
                                <i class="fa-regular fa-user text-xs shrink-0" aria-hidden="true"></i>
                                <span class="truncate">{{ profile.your_profile || profile.name }}</span>
                                <span v-if="show_alerts" class="size-2 rounded-full bg-boosted shrink-0"></span>
                            </button>
                        </div>
                        <button
                            type="button"
                            class="size-9 rounded-xl inline-flex items-center justify-center text-base-content/60 hover:text-base-content hover:bg-base-200 transition-colors cursor-pointer shrink-0"
                            :aria-label="close_label"
                            @click="closeDrawer()"
                        >
                            <i class="fa-regular fa-times" aria-hidden="true"></i>
                        </button>
                    </div>

                    <div class="grow overflow-y-auto">
                        <div class="profile p-4 flex flex-col gap-5" v-if="view_profile">
                            <div class="flex items-center gap-3 p-3 rounded-xl bg-base-200/60">
                                <div class="size-10 rounded-xl bg-neutral text-neutral-content flex items-center justify-center text-sm font-bold uppercase shrink-0" v-if="showInitials()">
                                    {{ initials }}
                                </div>
                                <UserSvg class="size-10 text-base-content shrink-0" v-else-if="isDefaultAvatar()" />
                                <div class="size-10 rounded-xl cover-background shrink-0" v-bind:style="{ backgroundImage: profilePictureUrl() }" v-else></div>
                                <div class="grow min-w-0">
                                    <div class="text-sm font-semibold truncate">{{ profile.name }}</div>
                                    <div class="text-xs text-base-content/60 truncate">{{ profile.email }}</div>
                                </div>
                            </div>

                            <div class="notifications" v-if="notifications.title">
                                <div class="flex w-full pb-2 items-center text-xs justify-between">
                                    <div class="font-semibold text-base-content/60 uppercase tracking-wide">
                                        {{ notifications.title }}
                                    </div>
                                    <a v-bind:href="notifications.all.url" class="text-link">
                                        {{ notifications.all.text }}
                                    </a>
                                </div>

                                <div class="flex flex-col gap-2" v-if="notifications.messages.length > 0">
                                    <Notification
                                        v-for="notification in notifications.messages"
                                        :key="notification.id"
                                        :notification="notification"
                                        @read="readNotification">
                                    </Notification>
                                </div>
                                <div class="flex items-center gap-2.5 p-3 rounded-xl bg-base-200/40 text-xs text-base-content/60" v-else>
                                    <i class="fa-regular fa-circle-check text-sm text-base-content/45" aria-hidden="true"></i>
                                    <span>{{ notifications.none }}</span>
                                </div>
                            </div>

                            <div class="releases" v-if="releases.title && releases.releases.length > 0">
                                <div class="flex w-full pb-2 text-xs">
                                    <div class="font-semibold text-base-content/60 uppercase tracking-wide">
                                        {{ releases.title }}
                                    </div>
                                </div>

                                <div class="flex flex-col gap-2">
                                    <Release
                                        v-for="release in releases.releases"
                                        :key="release.id"
                                        :release="release"
                                        @read="readRelease">
                                    </Release>
                                </div>
                            </div>

                            <div class="subscription" v-if="!profile.is_impersonating && profile.subscription">
                                <div class="uppercase pb-2 text-xs font-semibold text-base-content/60 tracking-wide">{{ profile.subscription.title }}</div>
                                <a class="flex items-center gap-3 p-2.5 rounded-xl bg-base-200/70 hover:bg-base-200 transition-colors" v-bind:href="profile.urls.subscription">
                                    <img class="size-10 shrink-0 object-contain" v-bind:src="profile.subscription.image" v-bind:alt="profile.subscription.tier">
                                    <div class="grow min-w-0">
                                        <div class="font-semibold text-sm text-base-content truncate">
                                            {{ profile.subscription.tier }}
                                        </div>
                                        <div class="text-xs text-base-content/70 truncate" v-if="profile.subscription.tier !== 'Kobold'">
                                            {{ profile.subscription.boosters }}
                                        </div>
                                        <div class="text-xs text-link flex items-center gap-1.5 mt-0.5" v-else>
                                            <span>{{ profile.subscription.call_to_action_2 }}</span>
                                            <i class="fa-duotone fa-credit-card" aria-hidden="true" v-if="pro"></i>
                                            <i class="fa-regular fa-credit-card" aria-hidden="true" v-else></i>
                                            <i class="fa-brands fa-paypal" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                    <i class="fa-regular fa-angle-right text-xs text-base-content/45 shrink-0" aria-hidden="true"></i>
                                </a>
                            </div>
                        </div>

                        <div class="campaigns p-4" v-else>
                            <div v-if="!profile.is_impersonating" class="flex flex-col gap-5">
                                <div class="flex items-center gap-2 rounded-xl bg-base-200/80 px-3 focus-within:ring-2 focus-within:ring-primary/40" v-if="totalCampaigns > 5">
                                    <i class="fa-solid fa-magnifying-glass text-xs text-base-content/45 shrink-0" aria-hidden="true"></i>
                                    <input
                                        v-model="campaignFilter"
                                        type="search"
                                        :placeholder="campaigns_label"
                                        :aria-label="campaigns_label"
                                        class="w-full min-w-0 border-0! bg-transparent! px-0! py-2! text-sm text-base-content placeholder:text-base-content/45 shadow-none! outline-none! focus:ring-0!"
                                    />
                                </div>

                                <div class="flex flex-col gap-2">
                                    <div class="flex w-full gap-2 text-xs items-center justify-between">
                                        <div class="flex items-center gap-2 uppercase font-semibold text-base-content/60 tracking-wide">
                                            <span>{{ campaigns.texts.campaigns }}</span>
                                            <span class="px-1.5 py-0.5 rounded-full bg-base-200 text-[11px] font-medium text-base-content/70 leading-none">{{ campaigns.member.length }}</span>
                                        </div>
                                        <a v-bind:href="campaigns.urls.reorder" class="text-link inline-flex items-center gap-1" v-if="campaigns.member.length > 0">
                                            <i class="fa-regular fa-arrow-up-arrow-down" aria-hidden="true"></i>
                                            {{ campaigns.texts.reorder }}
                                        </a>
                                    </div>

                                    <div class="flex flex-col gap-1">
                                        <Campaign
                                            v-for="campaign in filteredMemberCampaigns"
                                            :key="campaign.id || campaign.url"
                                            :campaign="campaign"
                                            :active="isCurrentCampaign(campaign)"
                                        />

                                        <a
                                            v-bind:href="campaigns.urls.new"
                                            class="flex items-center gap-3 p-2 rounded-xl border border-dashed border-base-content/20 hover:border-primary/50 hover:bg-base-200/60 text-sm text-base-content/75 hover:text-base-content transition-colors"
                                        >
                                            <div class="size-9 rounded-lg bg-base-200 flex items-center justify-center shrink-0">
                                                <i class="fa-regular fa-plus text-xs" aria-hidden="true"></i>
                                            </div>
                                            <span class="truncate">{{ campaigns.texts.new }}</span>
                                        </a>
                                    </div>
                                </div>

                                <div class="flex flex-col gap-2">
                                    <p class="uppercase text-xs font-semibold text-base-content/60 tracking-wide">
                                        {{ campaigns.texts.followed }}
                                    </p>

                                    <div class="flex flex-col gap-1 following">
                                        <Campaign
                                            v-for="campaign in filteredFollowingCampaigns"
                                            :key="campaign.id || campaign.url"
                                            :campaign="campaign"
                                            :active="isCurrentCampaign(campaign)"
                                        />

                                        <a
                                            v-bind:href="campaigns.urls.follow"
                                            class="flex items-center gap-3 p-2 rounded-xl border border-dashed border-base-content/20 hover:border-primary/50 hover:bg-base-200/60 text-sm text-base-content/75 hover:text-base-content transition-colors"
                                        >
                                            <div class="size-9 rounded-lg bg-base-200 flex items-center justify-center shrink-0">
                                                <i class="fa-regular fa-compass text-xs" aria-hidden="true"></i>
                                            </div>
                                            <span class="truncate">{{ campaigns.texts.follow }}</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex-none p-3 border-t border-base-content/10" v-if="view_profile">
                        <div class="flex flex-col gap-0.5" v-if="!profile.is_impersonating">
                            <a v-bind:href="profile.urls.settings.url" class="px-3 py-2 rounded-xl hover:bg-base-200 text-sm text-base-content flex items-center gap-3 transition-colors">
                                <i class="fa-regular fa-cog w-4 text-center text-base-content/60" aria-hidden="true"></i>
                                {{ profile.urls.settings.name }}
                            </a>
                            <a v-bind:href="profile.urls.profile.url" class="px-3 py-2 rounded-xl hover:bg-base-200 text-sm text-base-content flex items-center gap-3 transition-colors">
                                <i class="fa-regular fa-user w-4 text-center text-base-content/60" aria-hidden="true"></i>
                                {{ profile.urls.profile.name }}
                            </a>
                            <a href="https://plugins.kanka.io" class="px-3 py-2 rounded-xl hover:bg-base-200 text-sm text-base-content flex items-center gap-3 transition-colors">
                                <i class="fa-regular fa-puzzle-piece w-4 text-center text-base-content/60" aria-hidden="true"></i>
                                {{ marketplace.title }}
                            </a>
                            <a href="https://docs.kanka.io/en/latest/" class="px-3 py-2 rounded-xl hover:bg-base-200 text-sm text-base-content flex items-center gap-3 transition-colors" target="_blank">
                                <i class="fa-regular fa-question-circle w-4 text-center text-base-content/60" aria-hidden="true"></i>
                                <span class="grow">{{ profile.urls.help.name }}</span>
                                <i class="fa-regular fa-arrow-up-right-from-square text-xs text-base-content/45" aria-hidden="true"></i>
                            </a>

                            <div class="border-t border-base-content/10 my-1"></div>

                            <button type="button" v-on:click="logout()" class="w-full px-3 py-2 rounded-xl hover:bg-base-200 text-sm text-base-content flex items-center gap-3 transition-colors cursor-pointer text-left">
                                <i class="fa-regular fa-sign-out w-4 text-center text-base-content/60" aria-hidden="true"></i>
                                {{ profile.urls.logout.name }}
                            </button>
                        </div>
                        <div class="flex flex-col" v-else>
                            <a v-bind:href="profile.return.url" class="px-3 py-2 rounded-xl hover:bg-base-200 text-sm text-link flex items-center gap-3 transition-colors">
                                <i class="fa-regular fa-sign-out-alt w-4 text-center" aria-hidden="true"></i>
                                {{ profile.return.name }}
                            </a>
                        </div>
                    </div>
                </template>
            </div>
        </Transition>
    </Teleport>
</template>

<script setup lang="ts">
import Campaign from './Campaign.vue';
import Notification from './Notification.vue';
import Release from './Release.vue';
import GridSvg from "../icons/GridSvg.vue";
import UserSvg from "../icons/UserSvg.vue";
import ImpersonationRoles from './ImpersonationRoles.vue';
import { computed, onBeforeUnmount, onMounted, ref, watch } from "vue";
import { useNavigationAlerts } from '../../composables/useNavigationAlerts';
import type { Impersonation } from './impersonation';


const props = defineProps<{
    /* The user ID */
    user_id: String,
    /* Route to the API to get info for the navbar */
    api: String,
    /* Route to the API to get new notifications */
    fetch: String,
    /* User's initials for when they have no picture */
    initials: String,
    /* User's profile picture link */
    avatar: String,
    /* The campaign ID */
    campaign_id: undefined,
    /* Bool to define if there are unread notifications */
    has_alerts: Boolean,
    campaign_name: string,
    campaigns_label: string,
    close_label: string,
    impersonation?: Impersonation,
}>();

// Check for updates in the localstorage every minute for new alerts
const alert_delta = ref( 60 * 1000)
// Determine if waiting for data to load (show spinning wheel)
const is_loading = ref( false)
// Determine if the pop-out menu is out
const is_expanded = ref( false)
// Determine if the api data has been loaded
const has_data = ref( false)
// Determine if the campaign list is being shown
const view_campaigns = ref( false)
// Determine if the profile box is being shown
const view_profile = ref( false)
const campaignFilter = ref('')
const profile = ref( {})
const campaigns = ref( {})
const notifications = ref( {})
const marketplace = ref( {})
const releases = ref( {})
const { hasUnread: show_alerts } = useNavigationAlerts()
let alertTimer: ReturnType<typeof setTimeout>;
// Determine if data from the api has been loaded
const is_loaded = ref( false)
const pro = ref( false)

const totalCampaigns = computed(() => {
    const memberCount = campaigns.value?.member?.length || 0;
    const followingCount = campaigns.value?.following?.length || 0;
    return memberCount + followingCount;
});

const filterCampaignList = (list) => {
    if (!Array.isArray(list)) {
        return [];
    }
    const q = campaignFilter.value.trim().toLowerCase();
    if (!q) {
        return list;
    }
    return list.filter((c) => (c.name || '').toLowerCase().includes(q));
};

const filteredMemberCampaigns = computed(() => filterCampaignList(campaigns.value?.member));
const filteredFollowingCampaigns = computed(() => filterCampaignList(campaigns.value?.following));

const isCurrentCampaign = (campaign) => {
    return Boolean(props.campaign_id && campaign?.id && String(campaign.id) === String(props.campaign_id));
};

const closeDrawer = () => {
    is_expanded.value = false;
    campaignFilter.value = '';
};

const openCampaigns = () => {
    document.body.classList.remove('sidebar-open');
    view_campaigns.value = true;
    view_profile.value = false;
    loadData();
}
const openProfile = () => {
    document.body.classList.remove('sidebar-open');
    view_profile.value = true;
    view_campaigns.value = false;
    loadData();
}
const invalidateNavigation = () => {
    has_data.value = false;
}
const loadData = () => {
    is_expanded.value = true;
    if (props.impersonation || has_data.value) {
        return;
    }
    is_loading.value = true;
    axios.get(props.api)
        .then(response => {
        profile.value = response.data.profile;
        campaigns.value = response.data.campaigns;
        notifications.value = response.data.notifications;
        marketplace.value = response.data.marketplace;
        releases.value = response.data.releases;
        show_alerts.value = response.data.has_unread;
        has_data.value = true;
        is_loading.value = false;
        is_loaded.value = true;
        pro.value = response.data.fontawesome_pro;
    });
}
const logout = () => {
    document.getElementById('logout-form').submit();
}
const onClickOutside = (event) => {
    if (event?.target?.closest?.('[data-sidebar-action]')) {
        return;
    }
    closeDrawer();
}
const readRelease = (release) => {
    let index = releases.value.releases.findIndex(msg => msg.id === release.id);
    if (index !== -1) {
        releases.value.releases.splice(index, 1);
    }
    updateUnread();
}
const readNotification = (notification) => {
    let index = notifications.value.messages.findIndex(msg => msg.id == notification.id);
    if (index !== -1) {
        notifications.value.messages.splice(index, 1);
    }
    updateUnread();
}
// Figure out if the unread notification is removed
const updateUnread = () => {
    if (notifications.value.messages.length === 0 && releases.value.releases.length === 0) {
        show_alerts.value = false;
    }
}
const updateAlerts = () => {
    // Only do an ajax call if we haven't done one in a while  by looking at the local storage
    let last = localStorage.getItem('last_notification-' + props.user_id);
    let now = new Date().getTime();
    let delay = now - (60 * 5000); // Wait 5 minutes between each request on the db

    if (!last || last < delay) {
        fetchAlerts();
    } else {
        // If we have up to date info, show it to the user
        show_alerts.value = localStorage.getItem('notification-has-alerts-' + props.user_id) === 'true';
        queueFetch();

        // If the user hasn't opened the menu, don't bother with more details
        if (!is_loaded.value) {
            return;
        }
    }
}
const fetchAlerts = () => {
    let now = new Date().getTime();
    localStorage.setItem('last_notification-' + props.user_id, now);

    axios.get(props.fetch)
        .then(response => {
        localStorage.setItem('notification-has-alerts-' + props.user_id, response.data.has_alerts);
        updateAlerts();
    });
}
const queueFetch = () => {
    alertTimer = setTimeout(function () { updateAlerts() }, alert_delta.value);
}
const showInitials = () => {
    return props.avatar?.startsWith('/images/') && !isDefaultAvatar();
}
const isDefaultAvatar = () => {
    return !props.avatar || props.avatar.includes('/images/defaults/user.svg');
}
const profilePictureUrl = () => {
    return 'url(' + props.avatar + ')'
}

watch(show_alerts, (hasAlerts) => {
  window.dispatchEvent(new CustomEvent('navigation:alerts', { detail: { hasAlerts } }));
});

onMounted(() => {
  show_alerts.value = props.has_alerts;
  if (!props.impersonation) queueFetch();
  document.addEventListener('keydown', handleEscape);
  window.addEventListener('navigation:worlds', openCampaigns);
  window.addEventListener('navigation:profile', openProfile);
  window.addEventListener('navigation:refresh', invalidateNavigation);
})
const handleEscape = (event: KeyboardEvent) => {
    if (event.key === 'Escape') closeDrawer();
}
onBeforeUnmount(() => {
    clearTimeout(alertTimer);
    document.removeEventListener('keydown', handleEscape);
    window.removeEventListener('navigation:worlds', openCampaigns);
    window.removeEventListener('navigation:profile', openProfile);
    window.removeEventListener('navigation:refresh', invalidateNavigation);
})
</script>
