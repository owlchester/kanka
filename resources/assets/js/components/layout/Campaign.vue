<template>
    <a :class="campaignClass(campaign)" v-bind:href="campaign.url" v-bind:style="{backgroundImage: backgroundImage(campaign)}" :title="campaign.name">
        <div class="flex items-end justify-center name w-full text-xs p-2 pt-6 text-center" v-html="campaign.name">
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
            return 'campaign flex items-end bordered rounded-lg cover-background relative h-24 overflow-hidden text-break' + (campaign.is_boosted ? ' boosted' : '')
        }
    },
}
</script>
