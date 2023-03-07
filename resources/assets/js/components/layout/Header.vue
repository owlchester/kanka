<template>
    <header class="">
        <nav class="">
            <NavToggler></NavToggler>
            <NavSearch></NavSearch>
            <NavSwitcher
                :user_id="switcher.user_id"
                :initials="switcher.initials"
                :avatar="switcher.avatar"
                :api="switcher.api"
                :fetch="switcher.fetch"
                :campaign_id="switcher.campaign_id"
                :has_alerts="switcher.has_alerts"
                :pro="switcher.pro"
            ></NavSwitcher>
        </nav>
    </header>
</template>


<script>
import NavSwitcher from "./NavSwitcher";
import NavToggler from "./NavToggler";
import NavSearch from "./NavSearch";
import vClickOutside from "click-outside-vue3"

export default {

    directives: {
        clickOutside: vClickOutside.directive
    },
    props: {
        /* Config for the switcher */
        switcher: {
            type: Array,
        },
        /* Config for the search */
        search: {
            type: Array
        }
    },

    component: {
        NavToggler,
        NavSearch,
        NavSwitcher,
    },
};
</script>
