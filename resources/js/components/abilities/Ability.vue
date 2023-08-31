

<template>
    <div class="ability" v-bind:data-tags="ability.class">
        <div class="ability-box p-3 rounded bg-box shadow-xs">
            <div class="ability-header border-b flex items-center gap-2 pb-2 mb-2">
                <div v-bind:class="dropdownClass()" v-click-outside="onClickOutside" v-if="permission">
                    <a v-on:click="openDropdown()" class="dropdown-toggle" data-dropdown role="button"  v-if="!this.openedDropdown">
                        <i class="fa-solid fa-lock" v-if="ability.visibility_id === 2" v-bind:title="translate('admin')"></i>
                        <i class="fa-solid fa-user-lock" v-if="ability.visibility_id === 3" v-bind:title="translate('admin-self')"></i>
                        <i class="fa-solid fa-users" v-if="ability.visibility_id === 5" v-bind:title="translate('members')"></i>
                        <i class="fa-solid fa-user-secret" v-if="ability.visibility_id === 4" v-bind:title="translate('self')"></i>
                        <i class="fa-solid fa-eye" v-if="ability.visibility_id === 1" v-bind:title="translate('all')"></i>
                    </a>
                    <div class="flex gap-2 flex-wrap" v-else>
                          <a role="button" class="btn2 btn-sm" v-on:click="setVisibility(1)">{{ translate('all') }}</a>
                          <a role="button" class="btn2 btn-sm" v-on:click="setVisibility(2)" v-if="meta.is_admin">{{ translate('admin') }}</a>
                          <a role="button" class="btn2 btn-sm" v-on:click="setVisibility(4)" v-if="this.isSelf">{{ translate('self') }}</a>
                          <a role="button" class="btn2 btn-sm" v-on:click="setVisibility(5)" v-if="this.isSelf">{{ translate('members') }}</a>
                          <a role="button" class="btn2 btn-sm" v-on:click="setVisibility(3)" v-if="this.isSelf">{{ translate('admin-self') }}</a>
                    </div>
                </div>
                <div class="grow" v-if="!this.openedDropdown">
                    <a role="button" v-on:click="showAbility(ability)" data-toggle="tooltip-ajax" class="grow text-lg"
                       v-bind:data-id="ability.entity.id" v-bind:data-url="ability.entity.tooltip">
                      {{ ability.name }}
                    </a>
                </div>
                <a role="button"
                    v-on:click="updateAbility(ability)"
                    v-if="this.canDelete && !this.openedDropdown"
                    class="btn2 btn-ghost btn-xs"
                    v-bind:title="translate('update')">
                    <i class="fa-solid fa-pencil" aria-hidden="true"></i>
                    <span class="sr-only">{{ translate('update') }}</span>
                </a>
            </div>
            <div class="ability-body entity-content">
                <div class="flex">
                    <div class="flex-1">
                        <span class="help-block">{{ ability.type }}</span>
                        <div v-html="ability.entry"></div>
                        <div v-html="ability.note" class="help-block"></div>
                    </div>
                    <div class="flex-none text-right ml-2 mb-2" v-if="ability.images.has" >
                        <a class="ability-image block w-32 h-32 cover-background" target="_blank" v-bind:href="ability.images.url"
                           v-bind:style="backgroundImage">
                        </a>
                    </div>
                </div>


                <div v-if="ability.charges && permission">
                    <div class="charges relative">
                        <div class="charge inline-block mr-2 h-5 w-5 cursor-pointer bg-white shadow-xs" v-for="n in ability.charges" v-on:click="useCharge(ability, n)"
                             v-bind:class="{ used: ability.used_charges >= n }">
                        </div>
                    </div>
                </div>

                <div class="text-center cursor-pointer" v-if="hasAttribute"
                     v-on:click="click(ability)">
                    <i class="fa-solid fa-chevron-down" v-if="!details"></i>
                </div>
                <div v-if="details && hasAttribute">
                    <dl class="dl-horizontal">
                        <div v-for="att in ability.attributes">
                            <h4 v-if="att.type == 'section'" class="font-bold text-center" v-html="att.name"></h4>
                            <div v-else>
                                <dt>{{ att.name}}</dt>
                                <dd v-if="att.type == 'checkbox'">
                                    <i v-if="att.value == 1" class="fa-solid fa-check" aria-hidden="true"></i>
                                </dd>
                                <dd v-else v-html="att.value"></dd>
                            </div>
                        </div>
                    </dl>
                </div>
                <div class="text-center cursor-pointer" v-if="hasAttribute"
                     v-on:click="click(ability)">
                    <i class="fa-solid fa-chevron-up" v-if="details"></i>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import vClickOutside from "click-outside-vue3";

    export default {
        props: [
            'ability',
            'permission',
            'meta',
            'trans',
        ],
        directives: {
            clickOutside: vClickOutside.directive
        },

        data() {
            return {
                details: false,
                openedDropdown: false
            }
        },

        computed: {
            hasAttribute: function() {
                return this.ability.attributes.length > 0;
            },
            canDelete: function() {
                return this.permission;
            },
            isSelf: function() {
                return this.meta.user_id === this.ability.created_by;
            },
            backgroundImage: function() {
                if (this.ability.images.thumb) {
                    return {
                        backgroundImage: 'url(' + this.ability.images.thumb + ')'
                    }
                }
                return {}
            }
        },

        methods: {
            click: function(ability) {
                this.details = !this.details;
            },
            deleteAbility: function(ability) {
                this.emitter.emit('delete_ability', ability);
            },
            updateAbility: function(ability) {
                window.openDialog('abilities-dialog', ability.actions.edit);
            },
            showAbility: function(ability) {
                window.open(ability.actions.view, "_blank");
            },
            setVisibility: function(visibility_id) {
                var data = {
                    visibility_id: visibility_id,
                    ability_id: this.ability.ability_id,
                };
                axios.patch(this.ability.actions.update, data).then(response => {
                    this.ability.visibility_id = visibility_id;
                    this.emitter.emit('edited_ability', ability);
                })
                .catch(() => {

                });
                this.openedDropdown = false;
            },
            useCharge: function(ability, charge) {
                if (charge > ability.used_charges) {
                    ability.used_charges += 1;
                } else {
                    ability.used_charges -= 1;
                }

                axios.post(ability.actions.use, {'used': ability.used_charges})
                    .then((res) => {
                        if (!res.data.success) {
                            ability.used_charges -= 1;
                        }
                    })
                    .catch(() => {
                        ability.used_charges -= 1;
                    });
            },
            translate(key) {
                return this.trans[key] ?? 'unknown';
            },
            dropdownClass() {
                return this.openedDropdown ? 'open dropdown' : 'dropdown';
            },
            openDropdown() {
                this.openedDropdown = !this.openedDropdown;
            },
            onClickOutside (event) {
                //console.log('Clicked outside. Event: ', event)
                this.openedDropdown = false;
            },
        },
    }
</script>
