<template>
    <div class="flex w-full gap-1 mb-5 justify-end" v-if="!isLoading">
        <button class="btn btn-sm btn-warning" v-if="!isEditing" v-on:click="startEditing()">
            <i class="fa-solid fa-edit" aria-hidden="true"></i>
            Edit
        </button>
        <button class="btn btn-sm btn-default" v-if="isEditing" v-on:click="resetTree()">
            <i class="fa-solid fa-redo" aria-hidden="true"></i>
            Reset
        </button>
        <button class="btn btn-sm btn-default" v-if="isEditing" v-on:click="clearTree()">
            <i class="fa-solid fa-eraser" aria-hidden="true"></i>
            Clear
        </button>
        <button class="btn btn-sm btn-primary" :disabled="!isDirty" v-if="isEditing" v-on:click="saveTree()">
            <i class="fa-solid fa-save" aria-hidden="true"></i>
            Save
        </button>
    </div>
    <div class="family-tree relative">
        <div class="text-center px-5" v-if="isLoading">
            <i class="fa-solid fa-spinner fa-spin fa-2x" aria-hidden="true"></i>
            <span class="sr-only">Loading...</span>
        </div>
        <div v-else>
            <FamilyNode v-for="node in nodes"
                        :node="node"
                        :entities="entities"
                        :sourceX="0"
                        :sourceY="0"
                        :drawX="0"
                        :drawY="0"
                        :isEditing="isEditing"
            >
            </FamilyNode>
        </div>
    </div>
    <div class="modal fade" id="family-tree-modal" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmLabel" ref="modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" v-on:click="closeModal()">
                        <i class="fa-solid fa-times" aria-hidden="true"></i>
                    </button>
                    <h4 class="modal-title" v-if="isAddingChild">Add a child</h4>
                    <h4 class="modal-title" v-else-if="isEditingEntity">Change an entity</h4>
                    <h4 class="modal-title" v-else-if="isAddingRelation">Add a relation</h4>
                    <h4 class="modal-title" v-else-if="isEditingRelation">Change a relation</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group" v-show="isAddingRelation || isAddingChild || isEditingEntity">
                        <label>Entity</label>
                        <select class="form-control select2" style="width: 100%" data-url="http://kanka.test:8081/en/campaign/2/search/relation-entities?only=1" data-placeholder="Choose a character" data-language="en" data-allow-clear="true" name="character_id" data-dropdown-parent="#family-tree-modal" tabindex="-1" aria-hidden="true" v-model="this.entity"></select>
                    </div>
                    <div class="form-group" v-show="isEditingRelation || isAddingRelation">
                        <label>Relation</label>
                        <input v-model="relation" type="text" maxlength="70" class="form-control" />
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
import FamilyNode from './FamilyNode.vue';
import axios from "axios";
import {stringify} from "bloodhound-js/lib/utils";

export default {
    props: {
        api: undefined,
        save_api: undefined,
        entity_api: undefined,
    },
    components: {
        FamilyNode,
    },

    data() {
        return {
            nodes: [],
            entities: [],
            isEditing: false,
            isLoading: true,
            isDirty: false,
            originalNodes: undefined,
            originalEntities: undefined,

            currentUuid: undefined,
            isAddingRelation: false,
            isAddingChild: false,
            isEditingEntity: false,
            isEditingRelation: false,

            relation: undefined,
            entity: undefined,

            modal: '#family-tree-modal',
            entityField: 'select[name="character_id"]',
            newUuid: 1,
        }
    },

    methods: {
        startEditing() {
            this.isEditing = true;
        },
        resetTree() {
            this.isEditing = false;
            this.isDirty = false;


            this.nodes = JSON.parse(JSON.stringify(this.originalNodes));
            this.entities = JSON.parse(JSON.stringify(this.originalEntities));
        },
        saveTree() {
            axios.post(this.save_api, {data: this.nodes, entities: this.entities})
                .then((resp) => {
                    //console.log('Saved Tree');
                    window.showToast('Yooo');
                    this.isDirty = false;
                });
        },
        clearTree() {
            this.nodes = [];
        },
        deleteUuid(uuid) {
            if (confirm('Are you sure you want to delete?')) {
                this.deleteUuidFromNodes(uuid);
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
            this.currentUuid = undefined;
            this.relation = undefined;
            this.entity = undefined;

            $(this.modal).modal('hide');
            $(this.entityField).val(null).trigger('change');
        },
        showDialog() {
            $(this.modal).modal('show')
        },
        saveModal() {
            if (this.isEditingRelation) {
                this.editRelation();
            } else if(this.isAddingRelation) {
                this.addRelation();
            } else if(this.isAddingChild) {
                this.addChild();
            } else if(this.isEditingEntity) {
                this.editEntity();
            }
        },
        editRelation() {
            this.isDirty = true;
            console.log('edit relation', this.currentUuid, this.relation);
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
            this.closeModal();
        },
        addRelation() {
            let entity_id = $(this.entityField).val();
            if (!entity_id) {
                // Nothing, ignore
                this.closeModal();
            }

            let url = this.entity_api.replace('/0', '/' + entity_id);
            axios.get(url).then((res) => {
                let entity = res.data;
                this.insertRelation(entity);
                this.isDirty = true;
                this.closeModal();
            });
        },
        insertRelation(entity) {
            let entity_id = entity.id;
            if (!this.entities[entity.id]) {
                this.entities[entity.id] = entity;
            }

            const getRelationNodes = (result, object) => {
                if (object.uuid === this.currentUuid) {
                    if (Array.isArray(object.relations)) {
                        object.relations.push({entity_id: entity_id, role: this.relation, uuid: stringify(this.newUuid)});
                    } else {
                        object.relations = [{entity_id: entity_id, role: this.relation, uuid: stringify(this.newUuid)}];
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
            }

            let url = this.entity_api.replace('/0', '/' + entity_id);
            axios.get(url).then((res) => {
                let entity = res.data;
                this.insertChild(entity);
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
                        object.children.push({entity_id: entity_id, uuid: stringify(this.newUuid)});
                    } else {
                        object.children = [{entity_id: entity_id, uuid: stringify(this.newUuid)}];
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
        editEntity() {
            let entity_id = $(this.entityField).val();
            if (!entity_id) {
                // Nothing, ignore
                this.closeModal();
            }

            let url = this.entity_api.replace('/0', '/' + entity_id);
            axios.get(url).then((res) => {
                let entity = res.data;
                if (this.currentUuid === 0) {
                    this.addEntity(entity);
                } else {
                    this.replaceEntity(entity);
                }
                this.isDirty = true;
                this.closeModal();
            });
        },
        addEntity(entity) {
            this.entities[entity.id] = entity;
            this.nodes.push({entity_id: entity.id, uuid: stringify(this.newUuid), relations: []});
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
                        object.uuid = stringify(this.newUuid);
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
    },

    mounted() {
        axios.get(this.api).then((resp) => {
            this.nodes = resp.data.nodes;
            this.entities = resp.data.entities;

            this.originalNodes = JSON.parse(JSON.stringify(resp.data.nodes));
            this.originalEntities = JSON.parse(JSON.stringify(resp.data.entities));
            this.isLoading = false;
        });

        this.emitter.on('editEntity', (uuid) => {
            this.currentUuid = uuid;
            this.isEditingEntity = true;
            this.showDialog();
        });

        this.emitter.on('deleteEntity', (uuid) => {
            this.deleteUuidFromNodes(uuid);
        });

        this.emitter.on('addRelation', (uuid) => {
            this.currentUuid = uuid;
            this.isAddingRelation = true;
            this.showDialog();
        });
        this.emitter.on('editRelation', (data) => {
            this.currentUuid = data.uuid;
            this.relation = data.relation;
            this.isEditingRelation = true;
            this.showDialog();
        });

        this.emitter.on('addChild', (uuid) => {
            this.currentUuid = uuid;
            this.isAddingChild = true;
            this.showDialog();
        });
    },
};
</script>
