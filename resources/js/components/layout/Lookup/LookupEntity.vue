<template>
    <div class="flex justify-center gap-1 cursor-pointer hover:bg-base-200 rounded w-full"
         v-bind:data-id="entity.id"
         v-on:click="preview(entity)">
        <div class="flex-none">
            <a
                v-bind:href="entity.link"
                v-bind:style="{backgroundImage: backgroundImage(entity)}"
                v-on:click.stop
                :title="entity.name"
                class="rounded cover-background block h-16 w-16" />
        </div>
        <div class="flex-grow truncate pl-1">
            <div class="font-extrabold entity-name truncate" :title="entity.name" v-html="entity.name">
            </div>
            <div class="entity-type text-xs" v-html="entity.type">
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
const emit = defineEmits(['preview'])

const props = defineProps<{
    entity: undefined
}>()

const backgroundImage = (entity) => {
    return 'url(\'' + entity.image + '\')';
}
const preview = (entity) => {
    //console.log('preview', entity);
    emit('preview', entity);
}
</script>
