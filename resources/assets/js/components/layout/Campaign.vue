<template>
    <a :class="campaignClass(campaign)" v-bind:href="campaign.url" v-bind:style="{backgroundImage: backgroundImage(campaign)}">
        <div class="name">
        {{ campaign.name }}
        </div>
    </a>
</template>


<script>
export default {
    props: [
        'campaign'
    ],
    methods: {
        backgroundImage: function(campaign) {
            return campaign.image ? 'url(' + campaign.image + ')' : '';
        },
        campaignClass: function(campaign) {
            return 'campaign bordered' + (campaign.is_boosted ? ' boosted' : '')
        }
    },
}
</script>
