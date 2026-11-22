<template>
    <div class="nav-switcher flex min-w-0 items-center justify-center align-middle h-12 gap-1 md:gap-2">
        <button v-if="!impersonation" type="button" class="campaigns btn2 btn-ghost btn-square max-md:size-11! max-md:p-1! inline-flex items-center justify-center text-2xl hover:text-primary-focus" :class="campaign_name ? 'max-md:hidden!' : ''" v-on:click="openCampaigns()" :aria-label="campaigns_label" :aria-expanded="is_expanded && view_campaigns">
            <GridSvg :size="7" />
        </button>
        <button v-if="impersonation" type="button" class="flex min-h-9 max-w-52 items-center gap-2 rounded-lg bg-warning px-3 text-sm font-semibold text-warning-content hover:bg-warning/90" @click="openProfile()" :aria-label="impersonation.label" :aria-expanded="is_expanded">
            <span class="truncate max-md:hidden">{{ impersonation.label }}</span>
            <span class="truncate md:hidden">{{ impersonation.shortLabel }}</span>
            <i class="fa-regular fa-angle-down shrink-0" aria-hidden="true"></i>
        </button>
        <button v-else type="button" class="profile btn2 btn-ghost btn-square max-md:size-11! max-md:p-1! shrink-0 flex items-center justify-center text-center uppercase" v-on:click="openProfile()" aria-label="Profile settings" :aria-expanded="is_expanded && view_profile">
            <div class="indicator relative inline-flex w-max">
                <span class="notification-badge left-auto top-auto -right-[0.2rem] -bottom-[0.2rem] translate-x-1/2 leading-2 p-[0.3rem] w-fit inline-flex absolute content-center items-center z-10" v-if="show_alerts"></span>
                <div class="profile-box rounded-lg p-2 text-center font-bold" v-if="showInitials()">
                    {{ initials }}
                </div>
                <div class="w-9 h-9 rounded-lg cover-background" v-bind:style="{backgroundImage: profilePictureUrl()}" v-else></div>
            </div>
        </button>
    </div>
    <button
        v-if="is_expanded"
        type="button"
        class="fixed inset-0 z-10 cursor-default"
        aria-label="Close navigation popout"
        @click.stop="is_expanded = false"
    ></button>
    <div class="navigation-drawer w-[82%] md:w-95 z-20 bg-base-100 h-full fixed top-0 right-0 rounded-l-2xl shadow-lg flex flex-col" v-if="is_expanded" v-click-outside="onClickOutside">
        <div v-if="impersonation" class="flex flex-col gap-4 overflow-y-auto p-5">
            <button type="button" class="absolute right-2 top-2 flex size-11 items-center justify-center rounded-xl bg-base-100 hover:bg-base-200" :aria-label="close_label" @click="is_expanded = false">
                <i class="fa-regular fa-times" aria-hidden="true"></i>
            </button>
            <div class="pr-11 font-semibold wrap-anywhere">{{ impersonation.label }}</div>
            <a :href="impersonation.returnUrl" class="flex min-h-11 items-center gap-3 text-link">
                <i class="fa-regular fa-sign-out-alt" aria-hidden="true"></i>
                {{ impersonation.returnLabel }}
            </a>
            <ImpersonationRoles :impersonation="impersonation" />
        </div>
        <div class="temporary p-8 text-center" v-else-if="is_loading">
            <i class="fa-solid fa-spinner fa-spin" aria-hidden="true"></i>
        </div>
        <template v-else>
            <div class="header flex flex-none">
                <div :class="blockClass(view_campaigns)" v-on:click="openCampaigns()" tabindex="0" role="button" aria-label="Campaign list">
                    <div class="full flex items-center gap-4" v-if="view_campaigns">
                        <div class="flex-none">
                            <GridSvg :size="6" />
                        </div>
                        <div class="grow">
                            <div class="text-sm font-semibold">{{ campaigns.texts.campaigns }}</div>
                            <div class="text-xs text-neutral-content">{{campaigns.texts.count }}</div>
                        </div>
                    </div>
                    <div class="flex items-center justify-center h-full" :title="campaigns.texts.campaigns" v-else>
                        <GridSvg :size="6" />
                    </div>
                </div>
                <div :class="blockClass(view_profile)" v-on:click="openProfile()" tabindex="0" role="button" aria-label="Profile pane">
                    <div class="full flex items-center gap-4" v-if="view_profile">
                        <div class="flex-none profile-box rounded-lg p-2 text-center uppercase font-bold" v-if="showInitials()">
                            {{ initials }}
                        </div>
                        <div class="flex-none w-9 h-9 rounded-lg cover-background" v-bind:style="{backgroundImage: profilePictureUrl()}" v-else></div>

                        <div class="grow">
                            <div class="text-sm font-semibold">{{ profile.name }}</div>
                            <div class="text-xs text-neutral-content">{{ profile.email }}</div>
                        </div>
                    </div>
                    <div class="" v-else :title="profile.your_profile">
                        <div class="flex-none profile-box rounded-lg p-2 text-center uppercase font-bold" v-if="showInitials()">
                            {{ initials }}
                        </div>
                        <div class="flex-none w-9 h-9 rounded-lg cover-background" v-bind:style="{backgroundImage: profilePictureUrl()}" v-else></div>
                    </div>
                </div>
                <div class="flex flex-none items-center justify-center px-2" :class="view_campaigns ? 'bg-base-200' : 'bg-base-100'">
                    <button
                        type="button"
                        class="flex size-11 items-center justify-center rounded-xl"
                        :class="view_campaigns ? 'hover:bg-base-300' : 'hover:bg-base-200'"
                        :aria-label="close_label"
                        @click="is_expanded = false"
                    >
                        <i class="fa-regular fa-times" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
            <div class="grow overflow-y-auto">
                <div class="profile p-5 flex flex-col gap-5" v-if="view_profile">
                    <div class="notifications" v-if="notifications.title">
                        <div class="flex w-full py-2 items-center text-xs justify-between">
                            <div class="font-semibold text-neutral-content uppercase">
                                {{ notifications.title }}
                            </div>
                            <a v-bind:href="notifications.all.url" class="text-link">
                                {{ notifications.all.text}}
                            </a>
                        </div>

                        <div class="flex flex-col gap-2">
                            <Notification
                                v-for="notification in notifications.messages"
                                :key="notification.id"
                                :notification="notification"
                                @read="readNotification">
                            </Notification>
                        </div>
                        <div class="no-notifications help-block text-neutral-content italic" v-if="notifications.messages.length === 0">
                            {{  notifications.none }}
                        </div>
                    </div>

                    <div class="releases" v-if="releases.title && releases.releases.length > 0">
                        <div class="flex w-full py-2 text-xs">
                            <div class="font-semibold text-neutral-content uppercase">
                                {{ releases.title }}
                            </div>
                        </div>

                        <div class="flex flex-col gap-2">
                            <Release
                                v-for="release in releases.releases"
                                :release="release"
                                @read="readRelease">
                            </Release>
                        </div>
                    </div>


                    <div class="subscription" v-if="!profile.is_impersonating && profile.subscription">
                        <div class="uppercase font-bold py-2 text-xs font-semibold text-neutral-content">{{ profile.subscription.title }}</div>
                        <a class="border rounded-lg flex justify-center items-center hover:shadow-md border-base-300 text-link" v-bind:href="profile.urls.subscription">
                            <div class="flex-none p-2">
                                <img class="w-16 h-16" v-bind:src="profile.subscription.image" v-bind:alt="profile.subscription.tier">
                            </div>
                            <div class="grow p-2">
                                <div class="font-semibold text-md">
                                    {{ profile.subscription.tier}}
                                </div>
                                <div class="text-base-content" v-if="profile.subscription.tier !== 'Kobold'">
                                    {{ profile.subscription.created }}<br />
                                    {{ profile.subscription.boosters }}
                                </div>
                                <div class="text-base-content" v-else>
                                    {{ profile.subscription.call_to_action }}
                                    <div class="link flex gap-1 items-center">{{ profile.subscription.call_to_action_2 }}
                                        <i class="fa-duotone fa-credit-card" aria-hidden="true" v-if="pro"></i>
                                        <i class="fa-regular fa-credit-card" aria-hidden="true" v-else></i>
                                        <i class="fa-brands fa-paypal" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="campaigns p-5" v-else>
                    <div v-if="!profile.is_impersonating" class="campaigns flex flex-col gap-5">
                      <div class="flex flex-col gap-2">
                        <div class="flex w-full gap-2 text-xs justify-between">
                            <div class="uppercase font-semibold text-neutral-content">
                              {{campaigns.texts.campaigns }}
                            </div>
                            <a v-bind:href="campaigns.urls.reorder" class="text-link" v-if="campaigns.member.length > 0">
                                <i class="fa-regular fa-arrow-up-arrow-down" aria-hidden="true"></i>
                                {{ campaigns.texts.reorder}}
                            </a>
                        </div>

                        <div class="grid grid-cols-2 md:grid-cols-3 gap-5">
                            <Campaign v-for="campaign in campaigns.member"
                                      :campaign="campaign">
                            </Campaign>

                            <a v-bind:href="campaigns.urls.new" class="new-campaign flex items-center text-center border-dashed border rounded-lg h-24 p-2 overflow-hidden text-link">
                                <span class="text-xs text-break uppercase">
                                    <i class="fa-regular fa-plus" aria-hidden="true" style="display: none"></i>
                                    {{ campaigns.texts.new }}
                                </span>
                            </a>
                        </div>
                      </div>

                      <div class="flex flex-col gap-2">
                        <p class="uppercase text-xs font-semibold text-neutral-content" v-if="!profile.is_impersonating">
                            {{ campaigns.texts.followed }}
                        </p>

                        <div class="grid grid-cols-2 md:grid-cols-3 gap-5 following"  v-if="!profile.is_impersonating">
                            <Campaign v-for="campaign in campaigns.following"
                                      :campaign="campaign">
                            </Campaign>


                            <a v-bind:href="campaigns.urls.follow" class="new-campaign flex items-center text-center border-dashed border rounded-lg h-24 p-2 overflow-hidden text-link">
                            <span class="text-xs uppercase text-break">
                                {{ campaigns.texts.follow }}
                            </span>
                            </a>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
            <div class="flex-none p-5" v-if="view_profile">
                <div class="flex flex-col" v-if="!profile.is_impersonating">
                    <a v-bind:href="profile.urls.settings.url" class="p-2 text-link flex items-center gap-3">
                        <i class="fa-regular fa-cog text-neutral-content" aria-hidden="true"></i>
                        {{ profile.urls.settings.name }}
                    </a>
                    <a v-bind:href="profile.urls.profile.url" class="p-2 text-link flex items-center gap-3">
                        <i class="fa-regular fa-user text-neutral-content" aria-hidden="true"></i>
                        {{ profile.urls.profile.name }}
                    </a>
                    <a href="https://plugins.kanka.io"  class="p-2 text-link flex items-center gap-3">
                        <i class="fa-regular fa-puzzle-piece text-neutral-content" aria-hidden="true"></i>
                        {{ marketplace.title }}
                    </a>
                    <a href="https://docs.kanka.io/en/latest/" class="p-2 text-link flex items-center gap-3" target="_blank">
                        <i class="fa-regular fa-question-circle text-neutral-content" aria-hidden="true"></i>
                        {{ profile.urls.help.name }}
                    </a>

                    <hr class="my-2" />

                    <a href="#" v-on:click="logout()" class="p-2 text-link flex items-center gap-3">
                        <i class="fa-regular fa-sign-out " aria-hidden="true"></i>
                        {{ profile.urls.logout.name }}
                    </a>
                </div>
                <div class="flex flex-col" v-else>
                    <a v-bind:href="profile.return.url" class="p-2 text-link flex items-center gap-3">
                        <i class="fa-regular fa-sign-out-alt" aria-hidden="true"></i>
                        {{ profile.return.name }}
                    </a>
                </div>
            </div>
        </template>
    </div>
</template>

<script setup lang="ts">
import Campaign from './Campaign.vue';
import Notification from './Notification.vue';
import Release from './Release.vue';
import GridSvg from "../icons/GridSvg.vue";
import ImpersonationRoles from './ImpersonationRoles.vue';
import {onBeforeUnmount, onMounted, ref} from "vue";
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
    /* The campaign ID (not used?) */
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
const blockClass = (active) => {
    if (active) {
        return 'block p-4 grow min-w-0 items-center focus:box-shadow';
    }
    return 'block p-4  items-center bg-base-200 cursor-pointer flex-none focus:box-shadow';
}
const logout = () => {
    //console.info('loging out');
    document.getElementById('logout-form').submit();
}
const onClickOutside = (event) => {
    //console.log('Clicked outside. Event: ', event)
    is_expanded.value = false;
}
const readRelease = (release) => {
    let index = releases.value.releases.findIndex(msg => msg.id === release.id);
    releases.value.releases.slice(index, 1);
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
    //console.log('test', this.notifications.messages.length, this.releases.releases.length);
    if (notifications.value.messages.length === 0 && releases.value.releases.length === 0) {
        show_alerts.value = false;
    }
}
const updateAlerts = () => {
    //console.log('updateAlerts');
    // Only do an ajax call if we haven't done one in a while  by looking at the local storage
    let last = localStorage.getItem('last_notification-' + props.user_id);
    let now = new Date().getTime();
    let delay = now - (60 * 5000); // Wait 5 minutes between each request on the db

    if (!last || last < delay) {
        fetchAlerts();
    } else {
        //console.log('updating alerts', this.user_id);
        // If we have up to date info, show it to the user
        show_alerts.value = localStorage.getItem('notification-has-alerts-' + props.user_id) === 'true';
        queueFetch();

        // If the user hasn't opened the menu, don't bother with more details
        if (!is_loaded.value) {
            //console.log('hasnt loaded yet');
            return;
        }
        /*let releases = localStorage.getItem('notification-releases-' + this.user_id);
        if (releases && releases.length != this.releases.releases.length) {
            console.log('new releases', releases);
            this.releases.releases = releases;
            console.log('now', this.releases.releases);
        }
        let notifications = localStorage.getItem('notification-notifications-' + this.user_id);;
        if (notifications && notifications.length != this.notifications.messages.length) {
            console.log('new notifications', notifications);
            this.notifications.messages = notifications;
        }*/
    }
}
const fetchAlerts = () => {
    //console.log('fetchAlerts');
    let now = new Date().getTime();
    localStorage.setItem('last_notification-' + props.user_id, now);

    //console.log('fetch', this.fetch);
    axios.get(props.fetch)
        .then(response => {
        //console.log('responses', response);
        /*localStorage.setItem('notification-notifications-' + this.user_id, response.data.notifications);
        localStorage.setItem('notification-releases-' + this.user_id, response.data.releases);*/
        localStorage.setItem('notification-has-alerts-' + props.user_id, response.data.has_alerts);
        updateAlerts();
    });
}
const queueFetch = () => {
    //console.log('queue fetch');
    alertTimer = setTimeout(function () { updateAlerts() }, alert_delta.value);
}
const showInitials = () => {
    return props.avatar.startsWith('/images/');
}
const profilePictureUrl = () => {
    return 'url(' + props.avatar + ')'
}
onMounted(() => {
  show_alerts.value = props.has_alerts;
  if (!props.impersonation) queueFetch();
  document.addEventListener('keydown', handleEscape);
  window.addEventListener('navigation:worlds', openCampaigns);
  window.addEventListener('navigation:refresh', invalidateNavigation);
})
const handleEscape = (event: KeyboardEvent) => {
    if (event.key === 'Escape') is_expanded.value = false;
}
onBeforeUnmount(() => {
    clearTimeout(alertTimer);
    document.removeEventListener('keydown', handleEscape);
    window.removeEventListener('navigation:worlds', openCampaigns);
    window.removeEventListener('navigation:refresh', invalidateNavigation);
})
</script>
