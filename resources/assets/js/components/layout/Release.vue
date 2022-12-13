<template>
    <a :class="backgroundClass(release)" v-bind:href="release.link" v-if="!is_dismissed">
        <div class="flex-grow p-2">
            <strong>{{ release.title }}</strong>
            <p>{{ release.text }}</p>
        </div>
        <div class="flex-none p-2">
            <a v-on:click="dismiss(release)" class="cursor" aria-label="Dismiss" v-if="!this.is_loading">
                <i class="fa-solid fa-times" aria-hidden="true"></i>
            </a>
            <i class="fa-solid fa-spinner fa-spin" aria-hidden="true" v-else></i>
        </div>
    </a>
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
            let css = 'release flex justify-center items-center mb-2 px-2 py-2';
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
