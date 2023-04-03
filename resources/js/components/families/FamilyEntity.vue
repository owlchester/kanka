<template>
    <div v-bind:class="boxClasses()" v-bind:style="position()" v-bind:data-uuid="uuid" v-bind:data-entity="entity.id" v-bind:data-tags="tags()">
        <div class="flex items-center gap-1 max-w-full">
            <div class="flex-0">
                <a v-bind:href="entity.url">
                    <img v-bind:src="entity.thumb" class="rounded-full entity-image" v-bind:alt="entity.name" />
                </a>
            </div>
            <div class="grow justify-center truncate">
                <a v-bind:href="entity.url" v-bind:class="cssClasses()" v-bind:title="entity.name">
                    <span class="truncate">
                        {{ entity.name }}
                    </span>
                    <span class="self-end" v-show="entity.is_dead">
                        <i class="fa-solid fa-skull" v-bind:title="tooltip('is_dead')" aria-hidden="true"/>
                    </span>
                </a>
                <span class="text-xs" v-if="!isEditing && false">
                    (#{{ entity.id }})
                </span>
                <div class="flex gap-1" v-if="isEditing">
                    <a v-on:click="editEntity(uuid)" class="cursor-pointer" v-bind:title="i18n('entity', 'edit')">
                        <i class="fa-solid fa-pencil" aria-hidden="true"></i>
                        <span class="sr-only">{{ i18n('entity', 'edit') }}</span>
                    </a>
                    <a v-if="!isRelation" v-on:click="addRelation(uuid)" class="cursor-pointer" v-bind:title="i18n('relation', 'add')">
                        <i class="fa-solid fa-user-plus" aria-hidden="true"></i>
                        <span class="sr-only">{{ i18n('relation', 'add') }}</span>
                    </a>
                    <a v-on:click="deleteEntity(uuid)" class="align-end cursor-pointer" v-bind:title="i18n('entity', 'remove')">
                        <i class="fa-solid fa-trash" aria-hidden="true"></i>
                        <span class="sr-only">{{  i18n('entity', 'remove') }}</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    props: {
        entity: undefined,
        uuid: undefined,
        drawX: 0,
        drawY: 0,
        column: 0,
        row: 0,
        isRelation: false,
        isFounder: false,
        isEditing: undefined,
        node: undefined,
    },

    methods: {
        boxClasses() {
            let css = 'family-node-entity rounded-2xl px-2 flex items-center absolute inline-block overflow-hidden ' +
                'text-base leading-none ft-col-' + this.column + ' ft-row-' + this.row;
            if (this.isRelation) {
                css += ' family-node-entity-relation';
            }
            if (this.isFounder) {
                css += ' family-node-entity-founder';
            }
            if (this.entity.is_dead) {
                css += ' character-dead';
            }
            this.entity.tags.forEach(function (tag) {
                css += ' ' + tag;
            });
            return css;
        },
        position() {
            return '';
            /*return 'left: ' + this.drawX + 'px; top: ' + this.drawY + 'px;' +
                'width:' + this.entityWidth + 'px; height: ' + this.entityHeight + 'px';*/
        },
        editEntity(uuid) {
            this.emitter.emit('editEntity', uuid);
        },
        deleteEntity(uuid) {
            this.emitter.emit('deleteEntity', uuid);
        },
        addRelation(uuid) {
            this.emitter.emit('addRelation', uuid);
        },
        cssClasses() {
            let classes = '';
            if (this.entity.is_dead) {
                classes += 'flex grid-cols-2 items-center'
            } else {
                classes += 'block'
            }
            if (this.isEditing) {
                classes += ' font-bold';
            }
            return classes;
        },
        tags() {
            return '';
        },
        i18n(group, action) {
            return window.ftTexts.modals[group][action].title
        },
        tooltip(key) {
            return window.ftTexts.tooltips[key]
        },
    },

    mounted() {
        this.emitter.emit('trackX', this.drawX);
        this.emitter.emit('trackY', this.drawY);
        //console.log('entity', this.entity);
    }
};
</script>