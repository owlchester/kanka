<template>
    <div class="nav-switcher flex items-center justify-center">
        <div class="campaigns inline poiner text-center px-5 text-lg py-2" v-on:click="openCampaigns()" aria-label="Switch campaigns">
            <i class="fa-solid fa-grip " aria-hidden="true"></i>
        </div>
        <div class="profile inline poiner text-center text-uppercase py-2" v-on:click="openProfile()" aria-label="Profile settings">
            <div class="profile-box rounded-lg p-2 text-center font-bold">
                {{ initials }}
            </div>
        </div>
    </div>
    <div class="navigation-drawer h-full overflow-y fixed top-0 right-0" v-if="is_expanded" v-click-outside="onClickOutside">
        <div class="temporary p-8 text-center" v-if="is_loading">
            <i class="fa-solid fa-spinner fa-spin" aria-hidden="true"></i>
        </div>
        <div class="" v-else>
            <div class="header flex">
                <div :class="blockClass(view_campaigns)" v-on:click="openCampaigns()">
                    <div class="full flex items-center" v-if="view_campaigns">
                        <div class="flex-none mr-4 text-lg">
                            <i class="fa-solid fa-grip" aria-hidden="true"></i>
                        </div>
                        <div class="flex-grow">
                            <div class="font-bold">{{ campaigns.texts.campaigns }}</div>
                            <div>{{campaigns.texts.count }}</div>
                        </div>
                    </div>
                    <div class="flex items-center justify-center h-full text-lg" v-else>
                        <i class="fa-solid fa-grip" aria-hidden="true"></i>
                    </div>
                </div>
                <div :class="blockClass(view_profile)" v-on:click="openProfile()">
                    <div class="full flex items-center" v-if="view_profile">
                        <div class="flex-none mr-4 profile-box rounded-lg p-2 text-center text-uppercase font-bold">
                            {{ initials}}
                        </div>
                        <div class="flex-grow">
                            <div class="font-bold">{{ profile.name }}</div>
                            <div>{{ profile.created }}</div>
                        </div>
                    </div>
                    <div class="" v-else>
                        <div class="flex-none profile-box rounded-lg p-2 text-center text-uppercase font-bold">
                            {{ initials}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="profile p-5" v-if="view_profile">
                <div class="notifications mb-5" v-if="notifications.title">
                    <div class="flex w-full py-2">
                        <div class="flex-grow text-uppercase font-bold">
                            {{ notifications.title }}
                        </div>
                        <div class="flex-grow text-right">
                            <a v-bind:href="notifications.all.url">
                                {{ notifications.all.text}}
                            </a>
                        </div>
                    </div>

                    <Notification v-for="notification in notifications.messages"
                                  :notification="notification">
                    </Notification>
                    <div class="no-notifications help-block italic" v-if="notifications.messages.length === 0">
                        {{  notifications.none }}
                    </div>
                </div>

                <div class="releases mb-5" v-if="releases.title && releases.releases.length > 0">
                    <div class="flex w-full py-2">
                        <div class="flex-grow text-uppercase font-bold">
                            {{ releases.title }}
                        </div>
                    </div>

                    <Release v-for="release in releases.releases"
                                  :release="release">
                    </Release>
                </div>

                <div class="marketplace mb-5" v-if="!profile.is_impersonating && marketplace.title">

                    <div class="flex w-full py-2">
                        <div class="flex-grow text-uppercase font-bold">
                            {{ marketplace.title }}
                        </div>
                        <div class="flex-grow text-right">
                            <a v-bind:href="marketplace.explore.url">
                                {{ marketplace.explore.text}}
                            </a>
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-2">
                        <a v-bind:href="marketplace.themes.url" class="bordered py-2 text-center justify-center rounded-md" target="_blank">
                            <div class="icon rounded-full w-14 h-14 mb-1 text-3xl inline-block">
                                <i class="fa-solid fa-palette mt-3" aria-hidden="true"></i>
                            </div>
                            <div>{{ marketplace.themes.title }}</div>
                            <div class="text-muted text-xs">{{ marketplace.themes.number }}</div>
                        </a>
                        <a v-bind:href="marketplace.sheets.url" class="bordered py-2 text-center  justify-center rounded-md" target="_blank">
                            <div class="icon rounded-full w-14 h-14 mb-1 text-3xl inline-block">
                            <i class="fa-solid fa-columns mt-3" aria-hidden="true"></i>
                            </div>
                            <div>{{ marketplace.sheets.title }}</div>
                            <div class="text-muted text-xs">{{ marketplace.sheets.number }}</div>
                        </a>
                        <a v-bind:href="marketplace.content.url" class="bordered py-2 text-center  justify-center rounded-md" target="_blank">
                            <div class="icon rounded-full w-14 h-14 mb-1 text-3xl inline-block">
                                <i class="fa-solid fa-dice-d20 mt-3" aria-hidden="true"></i>
                            </div>
                            <div>{{ marketplace.content.title }}</div>
                            <div class="text-muted text-xs">{{ marketplace.content.number }}</div>
                        </a>
                    </div>
                </div>

                <div class="subscription mb-5" v-if="!profile.is_impersonating">
                    <div class="text-uppercase font-bold py-2">{{ profile.subscription.title }}</div>
                    <a class="bordered rounded-lg flex justify-center items-center" v-bind:href="profile.urls.subscription">
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
                            </div>
                        </div>
                    </a>
                </div>

                <ul class="m-0 p-0 list-none" v-if="!profile.is_impersonating">
                    <li>
                        <a v-bind:href="profile.urls.settings.url" class="p-2 mb-2 block">
                            <i class="fa-solid fa-cog mr-3" aria-hidden="true"></i>
                            {{ profile.urls.settings.name }}
                        </a>
                    </li>
                    <li>
                        <a v-bind:href="profile.urls.profile.url" class="p-2 mb-2 block">
                            <i class="fa-solid fa-user mr-3" aria-hidden="true"></i>
                            {{ profile.urls.profile.name }}
                        </a>
                    </li>
                    <li>
                        <a v-bind:href="profile.urls.help.url" class="p-2 mb-2 block" target="_blank">
                            <i class="fa-solid fa-question-circle mr-3" aria-hidden="true"></i>
                            {{ profile.urls.help.name }}
                        </a>
                    </li>
                    <li>
                        <a href="#" v-on:click="logout()" class="p-2 mb-2">
                            <i class="fa-solid fa-sign-out mr-3" aria-hidden="true"></i>
                            {{ profile.urls.logout.name }}
                        </a>
                    </li>
                </ul>
                <ul class="m-0 p-0" v-else>
                    <li>
                        <a v-bind:href="profile.return.url" class="p-2 mb-2">
                            <i class="fa-solid fa-sign-out-alt mr-3" aria-hidden="true"></i>
                            {{ profile.return.name }}
                        </a>
                    </li>
                </ul>
            </div>
            <div class="campaigns p-5" v-else>
                <div v-if="!profile.is_impersonating">

                    <div class="flex w-full py-2">
                        <div class="flex-grow text-uppercase font-bold">{{campaigns.texts.campaigns }}
                        </div>
                        <div class="flex-grow text-right">
                            <a v-bind:href="campaigns.urls.reorder">
                                {{ campaigns.texts.reorder}}
                            </a>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-3 gap-5">
                        <Campaign v-for="campaign in campaigns.member"
                                  :campaign="campaign">
                        </Campaign>

                        <a v-bind:href="campaigns.urls.new" class="new-campaign flex items-center text-center bordered rounded-lg h-24 p-2">
                            <span class="text-xs">
                                <i class="fa-solid fa-plus" aria-hidden="true"></i>
                                {{ campaigns.texts.new }}
                            </span>
                        </a>
                    </div>

                    <div class="following" v-if="!profile.is_impersonating && campaigns.following.length > 0">
                        <hr />
                        <p class="text-uppercase">{{ campaigns.texts.followed }}</p>

                        <div class="grid grid-cols-2 md:grid-cols-3 gap-5">
                            <Campaign v-for="campaign in campaigns.following"
                                      :campaign="campaign">
                            </Campaign>
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

export default {

    directives: {
        clickOutside: vClickOutside.directive
    },
    props: {
        api: undefined,
        initials: undefined,
        campaign_id: undefined,
    },

    components: {
        Campaign,
        Notification,
        Release,
    },

    data() {
        return {
            is_loading: false,
            is_expanded: false,
            has_data: false,
            view_campaigns: false,
            view_profile: false,
            profile: {},
            campaigns: {},
            notifications: {},
            marketplace: {},
            releases: {}
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
            axios.get(this.api).then(response => {
                this.profile = response.data.profile;
                this.campaigns = response.data.campaigns;
                this.notifications = response.data.notifications;
                this.marketplace = response.data.marketplace;
                this.releases = response.data.releases;
                this.has_data = true;
                this.is_loading = false;
            });
        },
        blockClass: function(active) {
            if (active) {
                return 'block p-4 flex-grow items-center';
            }
            return 'block p-4  items-center inactive cursor flex-none';
        },
        logout: function() {
            document.getElementById('logout-form').submit();
        },
        onClickOutside (event) {
            //console.log('Clicked outside. Event: ', event)
            this.is_expanded = false;
        },
        readRelease: function(release) {
            let index = this.releases.releases.findIndex(msg => msg.id === release.id);
            this.releases.releases.slice(index, 1);
        },
        readNotification: function(notification) {
            let index = this.notifications.messages.findIndex(msg => msg.id == notification.id);
            this.notifications.messages.slice(index, 1);
        },
    },
    mounted() {
        this.emitter.on('read_release', (release) => {
            this.readRelease(release);
        });
        this.emitter.on('read_notification', (notification) => {
            this.readNotification(notification);
        });
    }
};
</script>
