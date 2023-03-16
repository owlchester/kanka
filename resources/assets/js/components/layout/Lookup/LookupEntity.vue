<template>
    <div class="flex justify-center gap-1 mb-1 cursor-pointer hover:lookup-entity rounded p-1"
         v-bind:data-id="entity.id"
         v-on:click="preview(entity)">
        <div class="flex-none">
          <a
              v-bind:href="entity.link"
              v-bind:style="{backgroundImage: backgroundImage(entity)}"
              :title="entity.name"
              class="rounded cover-background block h-16 w-16"></a>
        </div>
        <div class="flex-grow pl-1">
            <div class="font-extrabold entity-name truncate max-w-50 mb-0">
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
            return 'url(' + entity.image + ')';
        },
        preview: function(entity) {
            //console.log('preview', entity);
            this.emitter.emit('preview', entity);
        }
    }
}
</script>
