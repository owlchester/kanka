<template>
    <div :class="backgroundClass(release)" v-if="!is_dismissed" :data-id="release.id">
        <div class="flex-grow p-2">
            <a v-html="release.title" class="font-bold cursor-pointer block w-full" v-bind:href="release.url" target="_blank"></a>
            <p v-html="release.text"></p>
        </div>
        <div class="flex-none p-2 cursor-pointer dismissable" v-on:click="dismiss(release)" v-if="!this.is_loading" :title="release.dismiss_text">
            <i class="fa-solid fa-times" aria-hidden="true"></i>
        </div>
        <div class="flex-none p-2" v-else>
            <i class="fa-solid fa-spinner fa-spin" aria-hidden="true"></i>
        </div>

    </div>
</template>


<script>
export default {
    props: [
        'release'
    ],
    data() {
        return {
            is_dismissed: false,
            is_loading: false,
        }
    },
    methods: {
        backgroundClass: function(release) {
            let css = 'release background-accent flex justify-center items-center mb-2 px-2 py-2  rounded-md';
            return css;
        },
        dismiss: function(release) {
            this.is_loading = true;
            axios.post(release.dismiss)
                .then(() => {
                    this.is_dismissed = true;
                    this.emitter.emit('read_release', release);
                });
        }
    },
}
</script>
