<template>
    <div v-bind:class="boxClasses()" v-bind:style="position()" v-bind:data-uuid="uuid" v-bind:data-entity="entity ? entity.id : undefined" v-bind:data-tags="tags()">
        <div class="flex items-center gap-1 max-w-full">
            <div class="flex-none">
                <span class="truncate" v-if="node.isUnknown">
                    <i class="fa-solid fa-3x fa-question" aria-hidden="true"/>
                </span>
                <a v-bind:href="entity.url" v-if="!node.isUnknown">
                    <img v-bind:src="entity.thumb" class="rounded-full entity-image w-10 h-10" v-bind:alt="entity.name" />
                </a>
            </div>
            <div class="grow justify-center truncate">
                <a v-bind:href="entity.url" v-bind:class="cssClasses()" v-bind:title="entity.name" v-if="!node.isUnknown">
                    <span class="truncate">
                        {{ entity.name }}
                    </span>
                    <span class="self-end" v-show="entity.is_dead">
                        <i class="fa-solid fa-skull" v-bind:title="tooltip('is_dead')" aria-hidden="true"></i>
                    </span>
                </a>
                <span v-bind:class="cssClasses()" v-if="node.isUnknown">
                    <i>{{ fields('unknown') }}</i>
                </span>
                <span class="text-xs" v-show="entity ? entity.birth : undefined">
                    {{ entity ? entity.birth : ''}}
                </span>
                <span class="text-xs" v-if="entity && entity.birth && entity.death">
                    -
                </span>
                <span class="text-xs" v-show="entity ? entity.death : undefined">
                    ✝ {{ entity ? entity.death : ''}}
                </span>
                <span class="text-xs" v-if="!isEditing && false">
                    (#{{ entity ? entity.id : '' }})
                </span>
                <div class="flex gap-1" v-if="isEditing">
                    <a v-on:click="editEntity(uuid, node)" class="cursor-pointer" v-bind:title="i18n('entity', 'edit')">
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
            let css = 'family-node-entity rounded-2xl px-2 flex items-center absolute overflow-hidden ' +
                'text-base leading-none ft-col-' + this.column + ' ft-row-' + this.row;
            if (this.isRelation) {
                css += ' family-node-entity-relation';
            }
            if (this.isFounder) {
                css += ' family-node-entity-founder';
            }
            if (this.entity) {
                if (this.entity.is_dead) {
                    css += ' character-dead';
                }
                this.entity.tags.forEach(function (tag) {
                    css += ' ' + tag;
                });
            }

            if (this.node.isUnknown) {
                css += ' unknown-character'
            }

            if (this.node.cssClass) {
                css += ' ' + this.node.cssClass;
            }

            return css;
        },
        position() {
            return '';
            /*return 'left: ' + this.drawX + 'px; top: ' + this.drawY + 'px;' +
                'width:' + this.entityWidth + 'px; height: ' + this.entityHeight + 'px';*/
        },
        editEntity(uuid, node) {
            this.emitter.emit('editEntity', {uuid: uuid, relation: node});
        },
        //editEntity(uuid) {
        //    this.emitter.emit('editEntity', uuid);
       // },
        deleteEntity(uuid) {
            this.emitter.emit('deleteEntity', uuid);
        },
        addRelation(uuid) {
            this.emitter.emit('addRelation', uuid);
        },
        cssClasses() {
            let classes = '';
            if (this.entity && this.entity.is_dead) {
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
        fields(field) {
            return window.ftTexts.modals.fields[field]
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
