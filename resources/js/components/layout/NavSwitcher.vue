<template>
    <div class="nav-switcher flex items-center justify-center h-12">
        <div class="campaigns inline cursor-pointer text-center px-3 text-2xl hover:text-primary-focus" v-on:click="openCampaigns()" aria-label="Switch campaigns" tabindex="0" role="button">
            <GridSvg :size="7" />
            <span class="sr-only">Campaigns</span>
        </div>
        <div class="profile inline cursor-pointer text-center uppercase pt-1" v-on:click="openProfile()" aria-label="Profile settings" tabindex="0" role="button">
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
                      <Notification v-for="notification in notifications.messages"
                                    :notification="notification">
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
                      <Release v-for="release in releases.releases"
                                    :release="release">
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
                                <i class="fa-solid fa-palette" aria-hidden="true"></i>
                            </div>
                            <div>{{ marketplace.themes.title }}</div>
                            <div class="text-muted text-xs">{{ marketplace.themes.number }}</div>
                        </a>
                        <a v-bind:href="marketplace.sheets.url" class="border py-2 items-center justify-center rounded-md hover:shadow-md flex flex-col gap-1" target="_blank">
                            <div class="icon bg-base-200 rounded-full w-14 h-14 text-3xl aspect-square flex justify-center items-center">
                            <i class="fa-solid fa-columns" aria-hidden="true"></i>
                            </div>
                            <div>{{ marketplace.sheets.title }}</div>
                            <div class="text-muted text-xs">{{ marketplace.sheets.number }}</div>
                        </a>
                        <a v-bind:href="marketplace.content.url" class="border py-2 items-center justify-center rounded-md hover:shadow-md flex flex-col gap-1" target="_blank">
                            <div class="icon bg-base-200 rounded-full w-14 h-14 text-3xl aspect-square flex justify-center items-center">
                                <i class="fa-solid fa-dice-d20" aria-hidden="true"></i>
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
                                    <i class="fa-solid fa-credit-card" aria-hidden="true" v-else></i>
                                    <i class="fa-brands fa-paypal" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <ul class="m-0 p-0 list-none flex flex-col gap-2" v-if="!profile.is_impersonating">
                    <li>
                        <a v-bind:href="profile.urls.settings.url" class="p-2 block">
                            <i class="fa-solid fa-cog mr-3" aria-hidden="true"></i>
                            {{ profile.urls.settings.name }}
                        </a>
                    </li>
                    <li>
                        <a v-bind:href="profile.urls.profile.url" class="p-2 block">
                            <i class="fa-solid fa-user mr-3" aria-hidden="true"></i>
                            {{ profile.urls.profile.name }}
                        </a>
                    </li>
                    <li>
                        <a v-bind:href="profile.urls.help.url" class="p-2 block" target="_blank">
                            <i class="fa-solid fa-question-circle mr-3" aria-hidden="true"></i>
                            {{ profile.urls.help.name }}
                        </a>
                    </li>
                    <li>
                        <a href="#" v-on:click="logout()" class="p-2 block">
                            <i class="fa-solid fa-sign-out mr-3" aria-hidden="true"></i>
                            {{ profile.urls.logout.name }}
                        </a>
                    </li>
                </ul>
                <ul class="m-0 p-0 list-none flex flex-col gap-2" v-else>
                    <li>
                        <a v-bind:href="profile.return.url" class="">
                            <i class="fa-solid fa-sign-out-alt mr-3" aria-hidden="true"></i>
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
                                <i class="fa-solid fa-plus" aria-hidden="true" style="display: none"></i>
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

<script>
import Campaign from './Campaign.vue';
import Notification from './Notification.vue';
import Release from './Release.vue';
import vClickOutside from "click-outside-vue3"
import GridSvg from "../icons/GridSvg.vue";

export default {

    directives: {
        clickOutside: vClickOutside.directive
    },
    /* Properties provided by the html component initialisation */
    props: {
        /* The user ID */
        user_id: {
            type: String,
        },
        /* Route to the API to get info for the navbar */
        api: {
            type: String,
        },
        /* Route to the API to get new notifications */
        fetch: {
            type: String,
        },
        /* User's initials for when they have no picture */
        initials: {
            type: String,
        },
        /* User's profile picture link */
        avatar: {
            type: String,
        },
        /* The campaign ID (not used?) */
        campaign_id: undefined,
        /* Bool to define if there are unread notifications */
        has_alerts: {
            type: Boolean,
        },
    },

    components: {
        GridSvg,
        Campaign,
        Notification,
        Release,
    },

    data() {
        return {
            // Check for updates in the localstorage every minute for new alerts
            alert_delta: 60 * 1000,
            // Determine if waiting for data to load (show spinning wheel)
            is_loading: false,
            // Determine if the pop-out menu is out
            is_expanded: false,
            // Determine if the api data has been loaded
            has_data: false,
            // Determine if the campaign list is being shown
            view_campaigns: false,
            // Determine if the profile box is being shown
            view_profile: false,
            profile: {},
            campaigns: {},
            notifications: {},
            marketplace: {},
            releases: {},
            show_alerts: false,
            // Determine if data from the api has been loaded
            is_loaded: false,
            pro: false,
        }
    },

    methods: {
        openCampaigns: function() {
            this.view_campaigns = true;
            this.view_profile = false;
            this.loadData();
        },
        openProfile: function() {
            this.view_profile = true;
            this.view_campaigns = false;
            this.loadData();
        },
        loadData: function() {
            this.is_expanded = true;
            if (this.has_data) {
                return;
            }
            this.is_loading = true;
            fetch(this.api)
                .then(response => response.json())
                .then(response => {
                this.profile = response.profile;
                this.campaigns = response.campaigns;
                this.notifications = response.notifications;
                this.marketplace = response.marketplace;
                this.releases = response.releases;
                this.show_alerts = response.has_unread;
                this.has_data = true;
                this.is_loading = false;
                this.is_loaded = true;
                this.pro = response.fontawesome_pro;
            });
        },
        blockClass: function(active) {
            if (active) {
                return 'block p-4 flex-grow items-center focus:box-shadow';
            }
            return 'block p-4  items-center bg-base-200 cursor-pointer flex-none focus:box-shadow';
        },
        logout: function() {
            //console.info('loging out');
            document.getElementById('logout-form').submit();
        },
        onClickOutside (event) {
            //console.log('Clicked outside. Event: ', event)
            this.is_expanded = false;
        },
        readRelease: function(release) {
            let index = this.releases.releases.findIndex(msg => msg.id === release.id);
            this.releases.releases.slice(index, 1);
            this.updateUnread();
        },
        readNotification: function(notification) {
            let index = this.notifications.messages.findIndex(msg => msg.id == notification.id);
            this.notifications.messages.slice(index, 1);
            this.updateUnread();
        },
        // Figure out if the unread notification is removed
        updateUnread: function() {
            //console.log('test', this.notifications.messages.length, this.releases.releases.length);
            if (this.notifications.messages.length === 0 && this.releases.releases.length === 0) {
                this.show_alerts = false;
            }
        },
        updateAlerts: function() {
            //console.log('updateAlerts');
            // Only do an ajax call if we haven't done one in a while  by looking at the local storage
            let last = localStorage.getItem('last_notification-' + this.user_id);
            let now = new Date().getTime();
            let delay = now - (60 * 5000); // Wait 5 minutes between each request on the db

            if (!last || last < delay) {
                this.fetchAlerts();
            } else {
                //console.log('updating alerts', this.user_id);
                // If we have up to date info, show it to the user
                this.show_alerts = localStorage.getItem('notification-has-alerts-' + this.user_id) === 'true';
                this.queueFetch();

                // If the user hasn't opened the menu, don't bother with more details
                if (!this.is_loaded) {
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
        },
        fetchAlerts: function() {
            //console.log('fetchAlerts');
            let now = new Date().getTime();
            localStorage.setItem('last_notification-' + this.user_id, now);

            //console.log('fetch', this.fetch);
            fetch(this.fetch)
                .then(response => response.json())
                .then(response => {
                //console.log('responses', response);
                /*localStorage.setItem('notification-notifications-' + this.user_id, response.data.notifications);
                localStorage.setItem('notification-releases-' + this.user_id, response.data.releases);*/
                localStorage.setItem('notification-has-alerts-' + this.user_id, response.has_alerts);
                this.updateAlerts();
            });
        },
        queueFetch: function() {
            //console.log('queue fetch');
            let vm = this;
            setTimeout(function () { vm.updateAlerts() }.bind(this), this.alert_delta);
        },
        showInitials: function() {
            return this.avatar.startsWith('/images/');
        },
        profilePictureUrl: function() {
            return 'url(' + this.avatar + ')'
        },
    },
    mounted() {
        this.emitter.on('read_release', (release) => {
            this.readRelease(release);
        });
        this.emitter.on('read_notification', (notification) => {
            this.readNotification(notification);
        });
        this.show_alerts = this.has_alerts;
        this.queueFetch();
    }
};
</script>
