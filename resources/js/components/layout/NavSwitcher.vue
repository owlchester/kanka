<template>
    <div class="nav-switcher flex items-center justify-center align-middle h-12 gap-2">
        <div class="campaigns inline cursor-pointer text-center text-2xl hover:text-primary-focus" v-on:click="openCampaigns()" aria-label="Switch campaigns" tabindex="0" role="button">
            <GridSvg :size="7" />
            <span class="sr-only">Campaigns</span>
        </div>
        <div class="profile flex items-center cursor-pointer text-center uppercase" v-on:click="openProfile()" aria-label="Profile settings" tabindex="0" role="button">
            <div class="indicator relative inline-flex w-max">
                <span class="notification-badge left-auto top-auto w-fit inline-flex absolute content-center items-center z-10" v-if="show_alerts"></span>
                <div class="profile-box rounded-lg p-2 text-center font-bold" v-if="showInitials()">
                    {{ initials }}
                </div>
                <div class="w-9 h-9 rounded-lg cover-background" v-bind:style="{backgroundImage: profilePictureUrl()}" v-else></div>
            </div>
        </div>
    </div>
    <div class="navigation-drawer bg-base-100 h-full overflow-y-auto fixed top-0 right-0 rounded-l-2xl shadow-lg" v-if="is_expanded" v-click-outside="onClickOutside">
        <div class="temporary p-8 text-center" v-if="is_loading">
            <i class="fa-solid fa-spinner fa-spin" aria-hidden="true"></i>
        </div>
        <div class="" v-else>
            <div class="header flex">
                <div :class="blockClass(view_campaigns)" v-on:click="openCampaigns()" tabindex="0" role="button" aria-label="Campaign list">
                    <div class="full flex items-center gap-4" v-if="view_campaigns">
                        <div class="flex-none">
                            <GridSvg :size="6" />
                        </div>
                        <div class="flex-grow">
                            <div class="font-bold">{{ campaigns.texts.campaigns }}</div>
                            <div>{{campaigns.texts.count }}</div>
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

                        <div class="flex-grow">
                            <div class="font-bold">{{ profile.name }}</div>
                            <div>{{ profile.created }}</div>
                        </div>
                    </div>
                    <div class="" v-else :title="profile.your_profile">
                        <div class="flex-none profile-box rounded-lg p-2 text-center uppercase font-bold" v-if="showInitials()">
                            {{ initials }}
                        </div>
                        <div class="flex-none w-9 h-9 rounded-lg cover-background" v-bind:style="{backgroundImage: profilePictureUrl()}" v-else></div>
                    </div>
                </div>
            </div>
            <div class="profile p-5 flex flex-col gap-5" v-if="view_profile">
                <div class="notifications" v-if="notifications.title">
                    <div class="flex w-full py-2">
                        <div class="flex-grow uppercase font-bold">
                            {{ notifications.title }}
                        </div>
                        <div class="flex-grow text-right">
                            <a v-bind:href="notifications.all.url">
                                {{ notifications.all.text}}
                            </a>
                        </div>
                    </div>

                    <div class="flex flex-col gap-2">
                        <Notification
                            v-for="notification in notifications.messages"
                            :notification="notification"
                            @read="readNotification">
                        </Notification>
                    </div>
                    <div class="no-notifications help-block text-neutral-content italic" v-if="notifications.messages.length === 0">
                        {{  notifications.none }}
                    </div>
                </div>

                <div class="releases" v-if="releases.title && releases.releases.length > 0">
                    <div class="flex w-full py-2">
                        <div class="flex-grow uppercase font-bold">
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

                <div class="marketplace" v-if="!profile.is_impersonating && marketplace.title">

                    <div class="flex w-full py-2">
                        <div class="flex-grow uppercase font-bold">
                            {{ marketplace.title }}
                        </div>
                        <div class="flex-grow text-right">
                            <a v-bind:href="marketplace.explore.url" target="_blank">
                                {{ marketplace.explore.text}}
                            </a>
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-2">
                        <a v-bind:href="marketplace.themes.url" class="border py-2 items-center justify-center rounded-md hover:shadow-md flex flex-col gap-1" target="_blank">
                            <div class="icon bg-base-200 rounded-full w-14 h-14 text-3xl aspect-square flex justify-center items-center">
                                <i class="fa-duotone fa-palette" aria-hidden="true"></i>
                            </div>
                            <div>{{ marketplace.themes.title }}</div>
                            <div class="text-muted text-xs">{{ marketplace.themes.number }}</div>
                        </a>
                        <a v-bind:href="marketplace.sheets.url" class="border py-2 items-center justify-center rounded-md hover:shadow-md flex flex-col gap-1" target="_blank">
                            <div class="icon bg-base-200 rounded-full w-14 h-14 text-3xl aspect-square flex justify-center items-center">
                            <i class="fa-duotone fa-table-cells" aria-hidden="true"></i>
                            </div>
                            <div>{{ marketplace.sheets.title }}</div>
                            <div class="text-muted text-xs">{{ marketplace.sheets.number }}</div>
                        </a>
                        <a v-bind:href="marketplace.content.url" class="border py-2 items-center justify-center rounded-md hover:shadow-md flex flex-col gap-1" target="_blank">
                            <div class="icon bg-base-200 rounded-full w-14 h-14 text-3xl aspect-square flex justify-center items-center">
                                <i class="fa-duotone fa-dice-d20" aria-hidden="true"></i>
                            </div>
                            <div>{{ marketplace.content.title }}</div>
                            <div class="text-muted text-xs">{{ marketplace.content.number }}</div>
                        </a>
                    </div>
                </div>

                <div class="subscription" v-if="!profile.is_impersonating && profile.subscription">
                    <div class="uppercase font-bold py-2">{{ profile.subscription.title }}</div>
                    <a class="border rounded-lg flex justify-center items-center hover:shadow-md" v-bind:href="profile.urls.subscription">
                        <div class="flex-none p-2">
                            <img class="w-16 h-16" v-bind:src="profile.subscription.image" v-bind:alt="profile.subscription.tier">
                        </div>
                        <div class="flex-grow p-2">
                            <div class="font-bold text-lg">
                                {{ profile.subscription.tier}}
                            </div>
                            <div class="more" v-if="profile.subscription.tier !== 'Kobold'">
                                {{ profile.subscription.created }}<br />
                                {{ profile.subscription.boosters }}
                            </div>
                            <div class="more" v-else>
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

                <ul class="m-0 p-0 list-none flex flex-col gap-2" v-if="!profile.is_impersonating">
                    <li>
                        <a v-bind:href="profile.urls.settings.url" class="p-2 block">
                            <i class="fa-regular fa-cog mr-3" aria-hidden="true"></i>
                            {{ profile.urls.settings.name }}
                        </a>
                    </li>
                    <li>
                        <a v-bind:href="profile.urls.profile.url" class="p-2 block">
                            <i class="fa-regular fa-user mr-3" aria-hidden="true"></i>
                            {{ profile.urls.profile.name }}
                        </a>
                    </li>
                    <li>
                        <a v-bind:href="profile.urls.help.url" class="p-2 block" target="_blank">
                            <i class="fa-regular fa-question-circle mr-3" aria-hidden="true"></i>
                            {{ profile.urls.help.name }}
                        </a>
                    </li>
                    <li>
                        <a href="#" v-on:click="logout()" class="p-2 block">
                            <i class="fa-regular fa-sign-out mr-3" aria-hidden="true"></i>
                            {{ profile.urls.logout.name }}
                        </a>
                    </li>
                </ul>
                <ul class="m-0 p-0 list-none flex flex-col gap-2" v-else>
                    <li>
                        <a v-bind:href="profile.return.url" class="">
                            <i class="fa-regular fa-sign-out-alt mr-3" aria-hidden="true"></i>
                            {{ profile.return.name }}
                        </a>
                    </li>
                </ul>
            </div>
            <div class="campaigns p-5" v-else>
                <div v-if="!profile.is_impersonating" class="campaigns flex flex-col gap-5">
                  <div class="flex flex-col gap-2">
                    <div class="flex w-full">
                        <div class="flex-grow uppercase font-bold">
                          {{campaigns.texts.campaigns }}
                        </div>
                        <div class="flex-grow text-right" v-if="campaigns.member.length > 0">
                            <a v-bind:href="campaigns.urls.reorder">
                                {{ campaigns.texts.reorder}}
                            </a>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-3 gap-5">
                        <Campaign v-for="campaign in campaigns.member"
                                  :campaign="campaign">
                        </Campaign>

                        <a v-bind:href="campaigns.urls.new" class="new-campaign flex items-center text-center border-dashed border rounded-lg h-24 p-2 overflow-hidden">
                            <span class="text-xs text-break uppercase">
                                <i class="fa-regular fa-plus" aria-hidden="true" style="display: none"></i>
                                {{ campaigns.texts.new }}
                            </span>
                        </a>
                    </div>
                  </div>

                  <hr v-if="!profile.is_impersonating" />

                  <div class="flex flex-col gap-2">
                    <p class="uppercase" v-if="!profile.is_impersonating">{{ campaigns.texts.followed }}</p>

                    <div class="grid grid-cols-2 md:grid-cols-3 gap-5 following"  v-if="!profile.is_impersonating">
                        <Campaign v-for="campaign in campaigns.following"
                                  :campaign="campaign">
                        </Campaign>


                        <a v-bind:href="campaigns.urls.follow" class="new-campaign flex items-center text-center border-dashed border rounded-lg h-24 p-2 overflow-hidden">
                        <span class="text-xs uppercase text-break">
                            {{ campaigns.texts.follow }}
                        </span>
                        </a>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import Campaign from './Campaign.vue';
import Notification from './Notification.vue';
import Release from './Release.vue';
import GridSvg from "../icons/GridSvg.vue";
import {onMounted, ref} from "vue";


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
const show_alerts = ref( false)
// Determine if data from the api has been loaded
const is_loaded = ref( false)
const pro = ref( false)

const openCampaigns = () => {
    view_campaigns.value = true;
    view_profile.value = false;
    loadData();
}
const openProfile = () => {
    view_profile.value = true;
    view_campaigns.value = false;
    loadData();
}
const loadData = () => {
    is_expanded.value = true;
    if (has_data.value) {
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
        return 'block p-4 flex-grow items-center focus:box-shadow';
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
    notifications.value.messages.slice(index, 1);
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
    setTimeout(function () { updateAlerts() }, props.alert_delta);
}
const showInitials = () => {
    return props.avatar.startsWith('/images/');
}
const profilePictureUrl = () => {
    return 'url(' + props.avatar + ')'
}
onMounted(() => {
  show_alerts.value = props.has_alerts;
  queueFetch();
})
</script>
