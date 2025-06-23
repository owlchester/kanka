<template>
    <div class="flex gap-2 mb-5 justify-end items-center align-right" v-if="!isLoading && permission">
        <button class="btn2 btn-sm btn-primary" v-if="!isEditing" v-on:click="startEditing()">
            <i class="fa-regular fa-edit" aria-hidden="true"></i>
            {{ this.texts.actions.edit }}
        </button>
        <button class="btn2 btn-sm " v-if="showEditFounder()" v-on:click="createNewFounder()">
            <i class="fa-regular fa-user" aria-hidden="true"></i>
            {{ this.texts.actions.founder }}
        </button>
        <button class="btn2 btn-sm " v-if="isEditing" v-on:click="resetTree()">
            <i class="fa-regular fa-redo" aria-hidden="true"></i>
            {{ this.texts.actions.reset }}
        </button>
        <button class="btn2 btn-sm " v-if="isEditing" v-on:click="clearTree()">
            <i class="fa-regular fa-eraser" aria-hidden="true"></i>
            {{ this.texts.actions.clear }}
        </button>
        <button class="btn2 btn-primary" v-if="isEditing && (isDirty)" v-on:click="saveTree()">
            <i class="fa-regular fa-save" aria-hidden="true"></i>
            {{ this.texts.actions.save }}
        </button>
    </div>
    <div class="family-tree overflow-auto w-full h-full min-h-50 block relative" ref="familytree">
        <div class="absolute top-0 right-0 z-10">
            <button class="btn2 btn-ghost btn-sm" aria-label="Close" v-on:click="zoom()">
                <i class="fa-regular fa-square-plus" aria-hidden="true"></i>
            </button>
            <button class="btn-sm btn2 btn-ghost" aria-label="Close" v-on:click="unzoom()">
                <i class="fa-regular fa-square-minus" aria-hidden="true"></i>
            </button>
        </div>
        <div class="text-center px-5" v-if="isLoading">
            <i class="fa-solid fa-spinner fa-spin fa-2x" aria-hidden="true"></i>
            <span class="sr-only">Loading...</span>
        </div>
        <div v-else class="relative" v-bind:style="{width: '100%'}">
            <PinchScrollZoom
                id="treeMap"
                ref="zoomer"
                key-actions
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
                    <a class="btn2 btn-primary" v-on:click="createNode()" v-if="showCreateNode()">
                        <i class="fa-regular fa-plus" aria-hidden="true"></i>
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

  <dialog class="dialog rounded-top md:rounded-2xl bg-base-100 min-w-fit shadow-md text-base-content" id="family-tree-modal" aria-modal="true" v-if="!isLoading">
    <header class="flex gap-6 items-center p-4 md:p-6 justify-between">
      <h4 v-if="isAddingChild" class="text-lg font-normal">{{ this.texts.modals.entity.child.title }}</h4>
      <h4 v-else-if="isAddingCharacter" class="text-lg font-normal">{{ this.texts.modals.entity.add.title }}</h4>
      <h4 v-else-if="isEditingEntity" class="text-lg font-normal">{{ this.texts.modals.entity.edit.title }}</h4>
      <h4 v-else-if="isAddingRelation" class="text-lg font-normal">{{ this.texts.modals.relation.add.title }}</h4>
      <h4 v-else-if="isEditingRelation" class="text-lg font-normal">{{ this.texts.modals.relation.edit.title }}</h4>
      <h4 v-else-if="isAddingNewFounder" class="text-lg font-normal">{{ this.texts.modals.entity.founder.title }}</h4>

      <button autofocus type="button" class="text-xl opacity-50 hover:opacity-100 focus:opacity-100 cursor-pointer text-decoration-none" aria-label="Close" v-on:click="closeModal()">
        <i class="fa-regular fa-circle-xmark" aria-hidden="true"></i>
        <span class="sr-only">Close</span>
      </button>
    </header>
    <article class="max-w-2xl py-4 px-4 md:px-6">
      <div class="flex flex-col gap-5 w-full">
        <div class="field field-founder flex flex-col gap-1 w-full" v-show="isAddingNewFounder">
          <label>{{ this.texts.modals.fields.founder }}</label>
          <select class="select2 w-full" style="width: 100%" v-bind:data-url="this.search_api" data-placeholder="Choose a character" data-language="en" data-allow-clear="true" name="founder_id_ft" data-dropdown-parent="#family-tree-modal" tabindex="-1" aria-hidden="true"></select>
        </div>
        <div class="field field-character flex flex-col gap-1 w-full" v-show="isAddingRelation || isAddingChild || isEditingEntity || isAddingCharacter || isAddingNewFounder">
          <label>{{ this.texts.modals.fields.character }}</label>
          <select class="select2 w-full" style="width: 100%" v-bind:data-url="this.search_api" data-placeholder="Choose a character" data-language="en" data-allow-clear="true" name="character_id_ft" data-dropdown-parent="#family-tree-modal" tabindex="-1" aria-hidden="true"></select>
        </div>
        <div class="field field-member flex flex-col gap-1" v-show="isAddingCharacter && this.showMembers()">
          <label>{{ this.texts.modals.fields.member }}</label>
          <ul>
            <li v-for="(suggestion) in this.suggestions"
            >
              <a class="cursor-pointer" v-on:click="this.saveSuggestion(suggestion.id)"> {{ suggestion.name }} </a>
            </li>
          </ul>
        </div>
      </div>
      <div class="flex flex-col gap-5 w-full" v-show="isEditingRelation || isAddingRelation || isAddingChild || isEditingEntity || isAddingNewFounder">
        <div v-if="isAddingRelation || isEditingEntity || isAddingNewFounder" class="field field-unknown checkbox flex flex-col gap-1">
          <label>
            <input type="checkbox" v-model="isUnknown" id="family_tree_unknown" name="isUnknown" value="isUnknown" />
            {{ this.texts.modals.fields.unknown }}
          </label>
          <p class="help-block text-neutral-content">{{ this.texts.modals.entity.edit.helper }}</p>
        </div>

        <div v-if="!isAddingChild" class="field field-relation flex flex-col gap-1">
          <label>{{ this.texts.modals.fields.relation }}</label>
          <input v-model="relation" type="text" maxlength="70" class="w-full" id="family_tree_relation" @keyup.enter="saveModal()"/>
        </div>

        <div class="grid grid-cols-2 gap-5" v-show="isAddingRelation || isAddingNewFounder || isAddingChild || isEditingEntity">
          <div class="field field field-colour flex flex-col gap-1">
            <label>{{ this.texts.modals.fields.colour }}</label>
            <div>
              <input v-model="colour" name="colour" type="text" maxlength="7" data-append-to="#family-tree-modal" class="w-full spectrum" id="family_tree_colour" @keyup.enter="saveModal()" ref="colour" />
            </div>
          </div>

          <div class="field field-visibility flex flex-col gap-1">
            <label>{{ this.texts.modals.fields.visibility.title }}</label>
            <select v-model="visibility" name="visibility" id="family_tree_visibility" class="w-full">
              <option value="1">{{ this.texts.modals.fields.visibility.all }}</option>
              <option value="2">{{ this.texts.modals.fields.visibility.admins }}</option>
              <option value="5">{{ this.texts.modals.fields.visibility.members }}</option>
            </select>
          </div>

          <div class="field field-css flex flex-col gap-1">
            <label>{{ this.texts.modals.fields.css }}</label>
            <input v-model="cssClass" type="text" maxlength="70" class="w-full" id="family_tree_class" @keyup.enter="saveModal()"/>
          </div>
        </div>
      </div>
    </article>
      <footer class="flex flex-wrap gap-3 justify-end items-center p-4 md:px-6">
          <menu class="flex flex-wrap gap-3 ps-0" >
              <div class="submit-group">
                  <button class="btn2 btn-primary" @click="saveModal()" v-html="texts.actions.save"></button>
              </div>
          </menu>
      </footer>
  </dialog>
    <dialog class="dialog rounded-top md:rounded-2xl bg-base-100 min-w-fit shadow-md text-base-content" id="family-tree-pitch" aria-modal="true" v-if="!isLoading">
      <header class="flex gap-6 items-center p-4 md:p-6 justify-between">
          <h4 class="text-lg font-normal" v-html="texts.modals.pitch.title"></h4>

          <button autofocus type="button" class="text-xl opacity-50 hover:opacity-100 focus:opacity-100 cursor-pointer text-decoration-none" aria-label="Close" v-on:click="closePitchModal()">
              <i class="fa-regular fa-circle-xmark" aria-hidden="true"></i>
              <span class="sr-only">Close</span>
          </button>
      </header>
      <article class="max-w-2xl py-4 px-4 md:px-6">
          <p v-html="texts.modals.pitch.content" class="text-neutral-content"></p>
          <div class="flex flex-col sm:flex-row gap-3 flex-wrap w-full">
              <a href="https://kanka.io/premium" class="btn2 btn-outline btn-sm" v-html="texts.modals.pitch.more"></a>
              <a :href=this.subscribe_url class="btn2 bg-boost text-white btn-sm" v-html="texts.modals.pitch.subscription">
              </a>
          </div>
      </article>
    </dialog>
</template>

<script>
import axios from "axios";
import PinchScrollZoom from "@coddicat/vue-pinch-scroll-zoom";

export default {
    props: {
        api: undefined,
        save_api: undefined,
        entity_api: undefined,
        search_api: undefined,
        permission: undefined,
        subscribe_url: undefined,
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
            isAddingNewFounder: false,
            isNotPremium: false,

            relation: undefined,
            entity: undefined,
            cssClass: undefined,
            colour: undefined,
            visibility: undefined,
            isUnknown: undefined,

            maxX: 0,
            maxY: 0,

            modal: 'family-tree-modal',
            pitchModal: 'family-tree-pitch',
            founderField: 'select[name="founder_id_ft"]',
            entityField: 'select[name="character_id_ft"]',
            newUuid: 1,
        }
    },

    methods: {

        zoom() {
            // create a new keyboard event and set the key to "Enter"
            const event = new KeyboardEvent('keydown', {
            key: '+',
            code: 'Equal',
            which: 187,
            keyCode: 187,
            });

            // dispatch the event on some DOM element
            document.getElementById('treeMap').dispatchEvent(event);
        },

        unzoom() {
            //zoomer.value?.manualZoom(0.5);

            // create a new keyboard event and set the key to "Enter"
            const event = new KeyboardEvent('keydown', {
            key: '-',
            code: 'Minus',
            which: 189,
            keyCode: 189,
            });

            // dispatch the event on some DOM element
            document.getElementById('treeMap').dispatchEvent(event);
        },

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
                    if (resp.status === 204) {
                        this.showPitchDialog();
                        return;
                    }
                    window.showToast(this.texts.toasts.saved);
                    this.isDirty = false;
                }).catch((err) => {
                    console.log('save tree error', err);
                this.showPitchDialog();
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
                return [];
            }
            return array.reduce(getNodes, []);
        },
        closePitchModal() {
            window.closeDialog(this.pitchModal);
        },
        closeModal() {
            this.isAddingChild = false;
            this.isAddingRelation = false;
            this.isEditingRelation = false;
            this.isEditingEntity = false;
            this.isAddingCharacter = false;
            this.isAddingNewFounder = false;
            this.currentUuid = undefined;
            this.relation = undefined;
            this.cssClass = undefined;
            this.colour = undefined;
            this.entity = undefined;
            this.visibility = 1;
            this.isUnknown = undefined;

            window.closeDialog(this.modal);
            $(this.entityField).val(null).trigger('change');
            $(this.founderField).val(null).trigger('change');
        },
        showDialog() {
            window.openDialog(this.modal);
            window.initForeignSelect();
            window.triggerEvent();
        },
        showPitchDialog() {
            window.openDialog(this.pitchModal);
        },
        resetVariables() {
            this.isAddingChild = false;
            this.isAddingRelation = false;
            this.isEditingRelation = false;
            this.isEditingEntity = false;
            this.isAddingCharacter = false;
            this.isAddingNewFounder = false;
            this.currentUuid = undefined;
            this.relation = undefined;
            this.cssClass = undefined;
            this.colour = undefined;
            this.visibility = 1;
            this.isUnknown = undefined;
            this.entity = undefined;

            window.closeDialog(this.modal);
            $(this.founderField).val(null).trigger('change');
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
            } else if(this.isAddingNewFounder) {
                this.addFounder();
            }
        },
        showCreateNode() {
            return this.nodes.length === 0 && this.isEditing;
        },
        showEditFounder() {
            return this.nodes.length > 0 && this.isEditing;
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
        createNewFounder() {
            this.resetVariables();
            this.isAddingNewFounder = true;
            this.currentUuid = 0;
            this.showDialog();
        },
        editRelation() {
            this.isDirty = true;
            //console.log('edit relation', this.currentUuid, this.relation);
            const getRelationNodes = (result, object) => {
                if (object.uuid === this.currentUuid) {
                    object.role = this.relation;
                    object.cssClass = this.cssClass;
                    object.colour = this.colour;
                    object.visibility = this.visibility;
                    object.isUnknown = this.isUnknown;
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
            if (this.isUnknown) {
                this.insertUnknownRelation();
                this.isDirty = true;
                window.showToast(this.texts.toasts.relations.add);
                this.closeModal();
            }

            if (entity_id && !this.isUnknown) {
                let url = this.entity_api.replace('/0', '/' + entity_id);
                axios.get(url).then((res) => {
                    let entity = res.data;
                    //console.log('add relation then', entity);
                    this.insertRelation(entity);
                    this.isDirty = true;
                    window.showToast(this.texts.toasts.relations.add);
                    this.closeModal();
                });
            }
        },
        insertUnknownRelation() {
            let entity_id = '';

            const getRelationNodes = (result, object) => {
                if (object.uuid === this.currentUuid) {
                    if (Array.isArray(object.relations)) {
                        object.relations.push({entity_id: entity_id, role: this.relation, cssClass: this.cssClass, colour: this.colour, isUnknown: this.isUnknown, visibility: this.visibility, uuid: JSON.stringify(this.newUuid)});
                    } else {
                        object.relations = [{entity_id: entity_id, role: this.relation, cssClass: this.cssClass, colour: this.colour, isUnknown: this.isUnknown, visibility: this.visibility, uuid: JSON.stringify(this.newUuid)}];
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
                        object.relations.push({entity_id: entity_id, role: this.relation, cssClass: this.cssClass, colour: this.colour, isUnknown: this.isUnknown, visibility: this.visibility, uuid: JSON.stringify(this.newUuid)});
                    } else {
                        object.relations = [{entity_id: entity_id, role: this.relation, cssClass: this.cssClass, colour: this.colour, isUnknown: this.isUnknown, visibility: this.visibility, uuid: JSON.stringify(this.newUuid)}];
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
            //console.log('child');
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
                        object.children.push({entity_id: entity_id, role: this.relation, cssClass: this.cssClass, colour: this.colour, visibility: this.visibility, uuid: JSON.stringify(this.newUuid)});
                    } else {
                        object.children = [{entity_id: entity_id, role: this.relation, cssClass: this.cssClass, colour: this.colour, visibility: this.visibility, uuid: JSON.stringify(this.newUuid)}];
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
                if (!(this.currentUuid === 0)) {
                    this.editEntityNode();
                    window.showToast(this.texts.toasts.entity.edit);
                    this.isDirty = true;
                }
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

        addFounder() {
            let founder_id = $(this.founderField).val();
            let entity_id = $(this.entityField).val();

            if (!founder_id) {
                // Nothing, ignore
                this.closeModal();
                return;
            }

            let url2 = this.entity_api.replace('/0', '/' + founder_id);
            axios.get(url2).then((res) => {
                let founder = res.data;
                if (entity_id) {
                    let url = this.entity_api.replace('/0', '/' + entity_id);
                    axios.get(url).then((res) => {
                        let entity = res.data;
                        this.addFounderEntity(founder, entity);
                        this.isDirty = true;
                        window.showToast(this.texts.toasts.entity.add);
                        this.closeModal();
                    });
                    return;
                }
                this.addFounderEntity(founder);
                this.isDirty = true;
                window.showToast(this.texts.toasts.entity.add);
                this.closeModal();
            });
        },
        addFounderEntity(founder, entity = null) {
            let entity_id = '';
            this.entities[founder.id] = Object.freeze(founder);
            if (entity) {
                this.entities[entity.id] = Object.freeze(entity);
                entity_id = entity.id;
            }

            this.nodes = [{entity_id: entity_id, role: this.relation, cssClass: this.cssClass, colour: this.colour, visibility: this.visibility, uuid: JSON.stringify(this.newUuid), children: this.nodes, isUnknown: this.isUnknown}];
            this.newUuid++;
            this.nodes = [{entity_id: founder.id, role: this.relation, cssClass: this.cssClass, colour: this.colour, visibility: this.visibility, uuid: JSON.stringify(this.newUuid), relations: this.nodes}];
            this.newUuid++;
        },
        addEntity(entity) {
            this.entities[entity.id] = Object.freeze(entity);
            this.nodes.push({entity_id: entity.id, role: this.relation, cssClass: this.cssClass, colour: this.colour, visibility: this.visibility, uuid: JSON.stringify(this.newUuid)});
            this.newUuid++;
        },
        editEntityNode() {
            const getRelationNodes = (result, object) => {
                if (object.uuid === this.currentUuid) {
                    object.role = this.relation;
                    object.isUnknown = this.isUnknown;
                    object.cssClass = this.cssClass;
                    object.colour = this.colour;
                    object.visibility = this.visibility;
                    object.entity_id = object.entity_id;
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
                    object.role = this.relation;
                    object.cssClass = this.cssClass;
                    object.colour = this.colour;
                    object.visibility = this.visibility;
                    object.isUnknown = this.isUnknown;
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

        this.emitter.on('editEntity', (data) => {
            this.resetVariables();
            this.entity = data.relation.entity_id;
            this.currentUuid = data.uuid;
            this.relation = data.relation.role;
            this.cssClass = data.relation.cssClass;
            this.colour = data.relation.colour;
            this.visibility = data.relation.visibility;
            this.isUnknown = data.relation.isUnknown,
            this.isEditingEntity = true;
            if (this.entity) {
                let newOption = new Option(this.entities[this.entity].name, this.entity, true, true);
                $(this.entityField).append(newOption).trigger('change');
            }
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
            //console.log(data.relation);
            this.resetVariables();
            this.currentUuid = data.uuid;
            this.relation = data.relation.role;
            this.cssClass = data.relation.cssClass;
            this.colour = data.relation.colour;
            this.visibility = data.relation.visibility;
            this.isUnknown = data.relation.isUnknown,
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
