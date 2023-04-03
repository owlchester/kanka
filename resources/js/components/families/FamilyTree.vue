<template>
    <div class="flex w-full gap-1 mb-3 justify-end items-center" v-if="!isLoading">
        <button class="btn btn-sm btn-warning" v-if="!isEditing" v-on:click="startEditing()">
            <i class="fa-solid fa-edit" aria-hidden="true"></i>
            {{ this.texts.actions.edit }}
        </button>
        <a class="cursor-pointer mr-5" v-if="isEditing" v-on:click="resetTree()">
            <i class="fa-solid fa-redo" aria-hidden="true"></i>
            {{ this.texts.actions.reset }}
        </a>
        <a class="cursor-pointer mr-5" v-if="isEditing" v-on:click="clearTree()">
            <i class="fa-solid fa-eraser" aria-hidden="true"></i>
            {{ this.texts.actions.clear }}
        </a>
        <button class="btn btn-sm btn-primary" :disabled="!isDirty" v-if="isEditing" v-on:click="saveTree()">
            <i class="fa-solid fa-save" aria-hidden="true"></i>
            {{ this.texts.actions.save }}
        </button>
    </div>
    <div class="family-tree overflow-auto w-full h-full min-h-50 block" ref="familytree">
        <div class="text-center px-5" v-if="isLoading">
            <i class="fa-solid fa-spinner fa-spin fa-2x" aria-hidden="true"></i>
            <span class="sr-only">Loading...</span>
        </div>
        <div v-else class="relative" v-bind:style="{width: '100%'}">
            <PinchScrollZoom
                ref="zoomer"
                :width="pincherWidth()"
                :height="pincherHeight()"
                :contentWidth="dragWidth()"
                :contentHeight="dragHeight()"
                :scale="1"
                :maxScale="3"
                :within="false"
                class="!cursor-move"
                >
                <div class="relative" v-bind:style="{width: dragWidth() + 'px', height: dragHeight() + 'px'}">
                    <a class="btn btn-default rounded-2xl px-5 py-2 cursor-pointer" v-on:click="createNode()" v-if="showCreateNode()">
                        <i class="fa-solid fa-plus" aria-hidden="true"></i>
                        {{ this.texts.actions.first }}
                    </a>

                    <FamilyNode v-for="node in nodes"
                                :node="node"
                                :entities="entities"
                                :sourceX="0"
                                :sourceY="0"
                                :drawX="0"
                                :drawY="0"
                                :column="0"
                                :row="0"
                                :sourceColumn="0"
                                :sourceRow="0"
                                :isEditing="isEditing"
                                :isFirst="true"
                    >
                    </FamilyNode>
                </div>
            </PinchScrollZoom>

        </div>
    </div>
    <div class="modal fade" id="family-tree-modal" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmLabel" ref="modal" v-if="!isLoading">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" v-on:click="closeModal()">
                        <i class="fa-solid fa-times" aria-hidden="true"></i>
                    </button>
                    <h4 class="modal-title" v-if="isAddingChild">{{ this.texts.modals.entity.child.title }}</h4>
                    <h4 class="modal-title" v-else-if="isAddingCharacter">{{ this.texts.modals.entity.add.title }}</h4>
                    <h4 class="modal-title" v-else-if="isEditingEntity">{{ this.texts.modals.entity.edit.title }}</h4>
                    <h4 class="modal-title" v-else-if="isAddingRelation">{{ this.texts.modals.relation.add.title }}</h4>
                    <h4 class="modal-title" v-else-if="isEditingRelation">{{ this.texts.modals.relation.edit.title }}</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group" v-show="isAddingRelation || isAddingChild || isEditingEntity || isAddingCharacter">
                        <label>{{ this.texts.modals.fields.character }}</label>
                        <select class="form-control select2" style="width: 100%" v-bind:data-url="this.search_api" data-placeholder="Choose a character" data-language="en" data-allow-clear="true" name="character_id_ft" data-dropdown-parent="#family-tree-modal" tabindex="-1" aria-hidden="true"></select>
                    </div>
                    <div class="form-group" v-show="isAddingCharacter && this.showMembers()">
                        <label>{{ this.texts.modals.fields.member }}</label>
                        <ul>
                            <li v-for="(suggestion) in this.suggestions"
                            >
                                <a class="cursor-pointer" v-on:click="this.saveSuggestion(suggestion.id)"> {{ suggestion.name }} </a>
                            </li>
                        </ul>
                    </div>
                    <div class="form-group" v-show="isEditingRelation || isAddingRelation">
                        <label>{{ this.texts.modals.fields.relation }}</label>
                        <input v-model="relation" type="text" maxlength="70" class="form-control" id="family_tree_relation" @keyup.enter="saveModal()"/>
                    </div>
                </div>
                <div class="modal-footer">

                    <button class="btn btn-primary" @click="saveModal()">
                        Save
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import PinchScrollZoom from "@coddicat/vue3-pinch-scroll-zoom";

export default {
    props: {
        api: undefined,
        save_api: undefined,
        entity_api: undefined,
        search_api: undefined,
    },
    components: {
        PinchScrollZoom,
    },

    data() {
        return {
            nodes: [],
            entities: [],
            texts: undefined,
            suggestions: [],
            isEditing: false,
            isLoading: true,
            isDirty: false,
            originalNodes: undefined,
            originalEntities: undefined,

            currentUuid: undefined,
            isAddingRelation: false,
            isAddingChild: false,
            isEditingEntity: false,
            isAddingCharacter: false,
            isEditingRelation: false,

            relation: undefined,
            entity: undefined,

            maxX: 0,
            maxY: 0,

            modal: '#family-tree-modal',
            entityField: 'select[name="character_id_ft"]',
            newUuid: 1,
        }
    },

    methods: {
        startEditing() {
            this.isEditing = true;
        },
        resetTree() {
            if (!this.isDirty || confirm(this.texts.modals.reset.confirm)) {
                this.isEditing = false;
                this.isDirty = false;

                this.nodes = JSON.parse(JSON.stringify(this.originalNodes));
                this.entities = JSON.parse(JSON.stringify(this.originalEntities));

                window.showToast(this.texts.toasts.reseted);
            }
        },
        saveTree() {
            axios.post(this.save_api, {data: this.nodes})
                .then((resp) => {
                    //console.log('Saved Tree');
                    window.showToast(this.texts.toasts.saved);
                    this.isDirty = false;
                });
        },
        clearTree() {
            if (confirm(this.texts.modals.clear.confirm)) {
                this.nodes = [];
                this.entities = [];
                this.isDirty = this.originalNodes.length > 0;
                this.resetVariables();
                window.showToast(this.texts.toasts.cleared);
            }
        },
        deleteUuid(uuid) {
            if (confirm(this.texts.modals.entity.remove.confirm)) {
                this.deleteUuidFromNodes(uuid);
                window.showToast(this.texts.toasts.entity.removed);
                this.isDirty = true;
            }
        },
        deleteUuidFromNodes(uuid) {
            this.nodes = this.filter(this.nodes, uuid);
        },
        filter(array, uuid) {
            //console.log('filter', array, uuid);
            const getNodes = (result, object) => {
                // If it's the uuid we're looking for, return an empty array
                if (object.uuid === uuid) {
                    return result;
                }
                if (Array.isArray(object.children)) {
                    const children = object.children.reduce(getNodes, []);
                    object.children = children;
                }
                else if (Array.isArray(object.relations)) {
                    const relations = object.relations.reduce(getNodes, []);
                    object.relations = relations;
                }
                result.push(object);
                return result;
            };
            // If the first node is the uuid, delete everything
            if (array[0].uuid === uuid) {
                return array.splice(0, 1);
            }
            return array.reduce(getNodes, []);
        },
        closeModal() {
            this.isAddingChild = false;
            this.isAddingRelation = false;
            this.isEditingRelation = false;
            this.isEditingEntity = false;
            this.isAddingCharacter = false;
            this.currentUuid = undefined;
            this.relation = undefined;
            this.entity = undefined;

            $(this.modal).modal('hide');
            $(this.entityField).val(null).trigger('change');
        },
        showDialog() {
            $(this.modal).modal('show')
        },
        resetVariables() {
            this.isAddingChild = false;
            this.isAddingRelation = false;
            this.isEditingRelation = false;
            this.isEditingEntity = false;
            this.isAddingCharacter = false;
            this.currentUuid = undefined;
            this.relation = undefined;
            this.entity = undefined;

            $(this.modal).modal('hide');
            $(this.entityField).val(null).trigger('change');
        },
        saveSuggestion: function(character) {
            this.emitter.emit('saveModal', [character]);
            this.saveModal(character);
        },
        saveModal(character = null) {
            if (this.isEditingRelation) {
                this.editRelation();
            } else if(this.isAddingRelation) {
                this.addRelation();
            } else if(this.isAddingChild) {
                this.addChild();
            } else if(this.isEditingEntity) {
                this.editEntity();
            } else if(this.isAddingCharacter) {
                this.editEntity(character);
            }
        },
        showCreateNode() {
            return this.nodes.length === 0 && this.isEditing;
        },
        showMembers() {
            //console.log('this', this.suggestions.length, this.suggestions)
            return this.suggestions.length > 0;
        },
        createNode() {
            this.isAddingCharacter = true;
            this.currentUuid = 0;
            this.showDialog();
        },
        editRelation() {
            this.isDirty = true;
            //console.log('edit relation', this.currentUuid, this.relation);
            const getRelationNodes = (result, object) => {
                if (object.uuid === this.currentUuid) {
                    object.role = this.relation;
                    result.push(object);
                    return result;
                }

                if (Array.isArray(object.children)) {
                    const children = object.children.reduce(getRelationNodes, []);
                    object.children = children;
                }
                else if (Array.isArray(object.relations)) {
                    const relations = object.relations.reduce(getRelationNodes, []);
                    object.relations = relations;
                }

                result.push(object);
                return result;
            };
            this.nodes = this.nodes.reduce(getRelationNodes, []);

            window.showToast(this.texts.toasts.relations.edit);
            this.closeModal();
        },
        addRelation() {
            let entity_id = $(this.entityField).val();
            if (!entity_id) {
                // Nothing, ignore
                this.closeModal();
                return;
            }

            let url = this.entity_api.replace('/0', '/' + entity_id);
            axios.get(url).then((res) => {
                let entity = res.data;
                //console.log('add relation then', entity);
                this.insertRelation(entity);
                this.isDirty = true;
                window.showToast(this.texts.toasts.relations.add);
                this.closeModal();
            });
        },
        insertRelation(entity) {
            let entity_id = entity.id;
            if (!this.entities[entity.id]) {
                //console.log('adding entity', entity);
                this.entities[entity.id] = entity;
                //console.log('entities', this.entities);
            }

            const getRelationNodes = (result, object) => {
                if (object.uuid === this.currentUuid) {
                    if (Array.isArray(object.relations)) {
                        object.relations.push({entity_id: entity_id, role: this.relation, uuid: JSON.stringify(this.newUuid)});
                    } else {
                        object.relations = [{entity_id: entity_id, role: this.relation, uuid: JSON.stringify(this.newUuid)}];
                    }
                    this.newUuid++;
                    result.push(object);
                    return result;
                }
                if (Array.isArray(object.children)) {
                    const children = object.children.reduce(getRelationNodes, []);
                    object.children = children;
                }
                else if (Array.isArray(object.relations)) {
                    const relations = object.relations.reduce(getRelationNodes, []);
                    object.relations = relations;
                }
                result.push(object);
                return result;
            };
            this.nodes = this.nodes.reduce(getRelationNodes, []);
        },
        addChild() {
            let entity_id = $(this.entityField).val();
            if (!entity_id) {
                // Nothing, ignore
                this.closeModal();
                return;
            }

            let url = this.entity_api.replace('/0', '/' + entity_id);
            axios.get(url).then((res) => {
                let entity = res.data;
                this.insertChild(entity);
                window.showToast(this.texts.toasts.entity.child);
                this.isDirty = true;
                this.closeModal();
            });
        },
        insertChild(entity) {
            var entity_id = entity.id;
            if (!this.entities[entity.id]) {
                this.entities[entity.id] = entity;
            }

            const getRelationNodes = (result, object) => {
                if (object.uuid === this.currentUuid) {
                    //console.log(object);

                    if (Array.isArray(object.children)) {
                        object.children.push({entity_id: entity_id, uuid: JSON.stringify(this.newUuid)});
                    } else {
                        object.children = [{entity_id: entity_id, uuid: JSON.stringify(this.newUuid)}];
                    }
                    this.newUuid++;
                    result.push(object);
                    return result;
                }
                if (Array.isArray(object.children)) {
                    const children = object.children.reduce(getRelationNodes, []);
                    object.children = children;
                }
                else if (Array.isArray(object.relations)) {
                    const relations = object.relations.reduce(getRelationNodes, []);
                    object.relations = relations;
                }
                result.push(object);
                return result;
            };
            return this.nodes = this.nodes.reduce(getRelationNodes, []);
        },
        editEntity(character = null) {
            let entity_id = $(this.entityField).val();
            if (character) {
                entity_id = character;
            }
            if (!entity_id) {
                // Nothing, ignore
                this.closeModal();
                return;
            }

            let url = this.entity_api.replace('/0', '/' + entity_id);
            axios.get(url).then((res) => {
                let entity = res.data;
                if (this.currentUuid === 0) {
                    this.newUuid = 1;
                    this.addEntity(entity);
                    window.showToast(this.texts.toasts.entity.add);
                } else {
                    this.replaceEntity(entity);
                    window.showToast(this.texts.toasts.entity.edit);
                }
                this.isDirty = true;
                this.closeModal();
            });
        },
        addEntity(entity) {
            this.entities[entity.id] = Object.freeze(entity);
            this.nodes.push({entity_id: entity.id, uuid: JSON.stringify(this.newUuid), relations: []});
            this.newUuid++;
        },
        replaceEntity(entity) {
            let entity_id = entity.id;
            if (!this.entities[entity.id]) {
                this.entities[entity.id] = entity;
            }

            const getRelationNodes = (result, object) => {
                if (object.uuid === this.currentUuid) {
                    if (object.uuid === 0) {
                        object.uuid = JSON.stringify(this.newUuid);
                        this.newUuid++;
                    }
                    object.entity_id = entity_id;
                    result.push(object);
                    return result;
                }

                if (Array.isArray(object.children)) {
                    const children = object.children.reduce(getRelationNodes, []);
                    object.children = children;
                }
                else if (Array.isArray(object.relations)) {
                    const relations = object.relations.reduce(getRelationNodes, []);
                    object.relations = relations;
                }

                result.push(object);
                return result;
            };
            return this.nodes = this.nodes.reduce(getRelationNodes, []);
        },
        dragHeight() {
            return this.maxY + 80;
        },
        dragWidth() {
            return this.maxX + 200;
        },
        pincherWidth() {
            let drag = this.dragWidth();
            let me = this.$refs.familytree.clientWidth;
            return Math.max(drag, me);
        },
        pincherHeight() {
            let drag = this.dragHeight();
            let me = this.$refs.familytree.clientHeight;
            return Math.max(drag, me);
        },
    },

    mounted() {
        axios.get(this.api).then((resp) => {
            this.nodes = resp.data.nodes;
            this.entities = resp.data.entities;
            this.texts = resp.data.texts;
            this.suggestions = resp.data.suggestions;
            window.ftTexts = this.texts;

            this.originalNodes = JSON.parse(JSON.stringify(resp.data.nodes));
            this.originalEntities = JSON.parse(JSON.stringify(resp.data.entities));
            this.isLoading = false;
        });

        this.emitter.on('editEntity', (uuid) => {
            this.resetVariables();
            this.currentUuid = uuid;
            this.isEditingEntity = true;
            this.showDialog();
        });

        this.emitter.on('deleteEntity', (uuid) => {
            this.resetVariables();
            this.deleteUuid(uuid);
        });

        this.emitter.on('addRelation', (uuid) => {
            this.resetVariables();
            this.currentUuid = uuid;
            this.isAddingRelation = true;
            this.showDialog();
        });
        this.emitter.on('editRelation', (data) => {
            this.resetVariables();
            this.currentUuid = data.uuid;
            this.relation = data.relation;
            this.isEditingRelation = true;
            this.showDialog();
        });

        this.emitter.on('addChild', (uuid) => {
            this.resetVariables();
            this.currentUuid = uuid;
            this.isAddingChild = true;
            this.showDialog();
        });
        this.emitter.on('trackX', (x) => {
            if (x > this.maxX) {
                this.maxX = x;
            }
        });
        this.emitter.on('trackY', (y) => {
            if (y > this.maxY) {
                this.maxY = y;
            }
        });
    },
};
</script>