<template>
    <div class="flex justify-center gap-1 mb-1 cursor-pointer hover:bg-base-200 rounded p-1 w-full"
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
            <div class="font-extrabold entity-name truncate" :title="entity.name">
                {{ entity.name }}
            </div>
            <div class="entity-type text-xs">
                {{ entity.type }}
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: [
        'entity'
    ],

    methods: {
        backgroundImage: function(entity) {
            return 'url(\'' + entity.image + '\')';
        },
        preview: function(entity) {
            //console.log('preview', entity);
            this.emitter.emit('preview', entity);
        }
    }
}
</script>
