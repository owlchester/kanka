<template>
    <div class="mx-5">
        <button class="sidebar-toggle text-center" data-toggle="tooltip" :title="title" data-placement="right" data-html="true" tabindex="3">
            <span class="sr-only">{{ text }}</span>
        </button>
    </div>
</template>

<script>
export default {
    props: {
        text: String,
        title: String
    }

};
</script>
