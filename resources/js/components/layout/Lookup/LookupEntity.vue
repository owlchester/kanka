<template>
    <a :class="boxCss()"
       v-bind:data-id="entity.id"
       v-bind:href="entity.link"
    >
        <div class="flex-none">
            <div
                v-bind:style="{backgroundImage: backgroundImage(entity)}"
                :title="entity.name"
                class="rounded cover-background block h-16 w-16" />
        </div>
        <div class="grow truncate pl-1 text-base-content"  @click="preview">
            <div class="font-extrabold entity-name truncate" :title="entity.name" v-html="entity.name">
            </div>
            <div class="entity-type text-xs" v-html="entity.type">
            </div>
        </div>
    </a>
</template>

<script setup lang="ts">
const emit = defineEmits(['preview'])

const props = defineProps<{
    entity: undefined,
}>()

const backgroundImage = (entity) => {
    return 'url(\'' + entity.image + '\')';
}
const preview = (event) => {
    event.stopPropagation(); // Prevent the click event from propagating to the <a>
    event.preventDefault();
    // console.log('preview', entity);
    emit('preview', props.entity);
}

const boxCss = () => {
    let css = 'flex justify-center gap-1 cursor-pointer hover:bg-base-200 rounded w-full focus:bg-base-200';
    return css;
}
</script>
