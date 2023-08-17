<template>
    <div class="mx-5">
        <span role="button" class="sidebar-toggle text-center cursor-pointer" data-toggle="tooltip" :data-title="title" data-placement="right" data-html="true" tabindex="3">
            <i class="fa-solid fa-chevrons-left" aria-hidden="true" data-sidebar="collapse"></i>
            <i class="fa-solid fa-chevrons-right" aria-hidden="true" data-sidebar="expand"></i>
            <span class="sr-only">{{ text }}</span>
        </span>
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
