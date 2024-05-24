

<template>
    <div class="ability" v-bind:data-tags="ability.class">
        <div class="ability-box p-4 rounded bg-box shadow-xs flex flex-col md:flex-row items-center md:items-start gap-2 md:gap-4">
            <div class="" v-if="ability.images.has">
                <a class="ability-image rounded-xl block w-40 h-40 cover-background"
                   v-bind:href="ability.images.url"
                   v-bind:style="backgroundImage">
                </a>
            </div>
            <div class="flex flex-col gap-4 w-full">
                <div class="flex gap-2 md:gap-4 items-center w-full">
                    <div class="flex gap-2 items-center text-xl grow">
                        <a v-bind:href="ability.actions.view" class="ability-name text-2xl" v-html="ability.name"></a>
                        <i class="fa-solid fa-lock" v-if="ability.visibility_id === 2" v-bind:title="ability.visibility"></i>
                        <i class="fa-solid fa-user-lock" v-if="ability.visibility_id === 3" v-bind:title="ability.visibility"></i>
                        <i class="fa-solid fa-users" v-if="ability.visibility_id === 5" v-bind:title="ability.visibility"></i>
                        <i class="fa-solid fa-user-secret" v-if="ability.visibility_id === 4" v-bind:title="ability.visibility"></i>
                        <i class="fa-solid fa-eye" v-if="ability.visibility_id === 1" v-bind:title="ability.visibility"></i>
                    </div>
                    <div v-if="ability.type" class="hidden md:inline bg-base-200 p-2 rounded-xl flex-none" v-html="ability.type"></div>

                    <div v-if="permission" class="">
                        <a role="button"
                            v-on:click="updateAbility(ability)"
                            v-if="this.canDelete && !this.openedDropdown"
                            class="btn2 btn-ghost btn-sm"
                            v-bind:title="ability.i18n.edit">
                            <i class="fa-solid fa-pencil text-xl" aria-hidden="true"></i>
                            <span class="sr-only" v-html="ability.i18n.edit"></span>
                        </a>
                    </div>
                </div>

                <div v-if="ability.type" class="visible md:hidden">
                    <div class="inline-block bg-base-200 p-2 rounded-xl" v-html="ability.type"></div>
                </div>
                <p class="text-sm" v-if="ability.entry" v-html="ability.entry"></p>
                <div class="flex gap-2 items-center" v-if="ability.tags">
                    <a v-for="tag in ability.tags"
                       class="rounded-lg bg-base-200 text-xs py-1 px-2 text-base-content"
                       v-bind:href="tag.url"
                       v-html="tag.name">
                    </a>
                </div>
                <div class="entity-content" v-if="ability.note" v-html="ability.note">
                </div>

                <div v-if="ability.charges && permission" class="flex gap-2 md:gap-4 ability-charges border-b pb-3 w-full items-end">
                    <div class="flex gap-1 flex-wrap grow">
                        <div class="charge cursor-pointer rounded-full p-2 hover:bg-accent hover:text-accent-content w-8 h-8 flex items-center justify-center" v-for="n in ability.charges" v-on:click="useCharge(ability, n)"
                            v-bind:class="{ 'bg-base-200 charge-used': ability.used_charges >= n }">
                            <span v-html="n"></span>
                        </div>
                    </div>
                    <div class="flex-none">
                        <span class="text-2xl" v-html="remainingNumber()"></span>
                        <span v-html="remainingText()"></span>
                    </div>
                </div>
            </div>




                            <!--            -->
<!--            <div class="ability-header border-b flex items-center gap-2 pb-2 mb-2">-->
<!--                <div v-bind:class="dropdownClass()" v-click-outside="onClickOutside" v-if="permission">-->
<!--                    <a v-on:click="openDropdown()" role="button"  v-if="!this.openedDropdown">-->
<!--                        <i class="fa-solid fa-lock" v-if="ability.visibility_id === 2" v-bind:title="translate('admin')"></i>-->
<!--                        <i class="fa-solid fa-user-lock" v-if="ability.visibility_id === 3" v-bind:title="translate('admin-self')"></i>-->
<!--                        <i class="fa-solid fa-users" v-if="ability.visibility_id === 5" v-bind:title="translate('members')"></i>-->
<!--                        <i class="fa-solid fa-user-secret" v-if="ability.visibility_id === 4" v-bind:title="translate('self')"></i>-->
<!--                        <i class="fa-solid fa-eye" v-if="ability.visibility_id === 1" v-bind:title="translate('all')"></i>-->
<!--                    </a>-->
<!--                    <div class="flex gap-2 flex-wrap" v-else>-->
<!--                          <a role="button" class="btn2 btn-sm" v-on:click="setVisibility(1)">{{ translate('all') }}</a>-->
<!--                          <a role="button" class="btn2 btn-sm" v-on:click="setVisibility(2)" v-if="meta.is_admin">{{ translate('admin') }}</a>-->
<!--                          <a role="button" class="btn2 btn-sm" v-on:click="setVisibility(4)" v-if="this.isSelf">{{ translate('self') }}</a>-->
<!--                          <a role="button" class="btn2 btn-sm" v-on:click="setVisibility(5)" v-if="this.isSelf">{{ translate('members') }}</a>-->
<!--                          <a role="button" class="btn2 btn-sm" v-on:click="setVisibility(3)" v-if="this.isSelf">{{ translate('admin-self') }}</a>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="grow" v-if="!this.openedDropdown">-->
<!--                    <a role="button" v-on:click="showAbility(ability)" data-toggle="tooltip-ajax" class="grow text-lg"-->
<!--                       v-bind:data-id="ability.entity.id" v-bind:data-url="ability.entity.tooltip">-->
<!--                      {{ ability.name }}-->
<!--                    </a>-->
<!--                </div>-->
<!--                <a role="button"-->
<!--                    v-on:click="updateAbility(ability)"-->
<!--                    v-if="this.canDelete && !this.openedDropdown"-->
<!--                    class="btn2 btn-ghost btn-xs"-->
<!--                    v-bind:title="translate('update')">-->
<!--                    <i class="fa-solid fa-pencil" aria-hidden="true"></i>-->
<!--                    <span class="sr-only">{{ translate('update') }}</span>-->
<!--                </a>-->
<!--            </div>-->
<!--            <div class="ability-body entity-content">-->
<!--                <div class="flex">-->
<!--                    <div class="flex-1">-->
<!--                        <span class="help-block">{{ ability.type }}</span>-->
<!--                        <div v-html="ability.entry"></div>-->
<!--                        <div v-html="ability.note" class="help-block"></div>-->
<!--                    </div>-->
<!--                    <div class="flex-none text-right ml-2 mb-2" v-if="ability.images.has" >-->
<!--                        <a class="ability-image block w-32 h-32 cover-background" target="_blank" v-bind:href="ability.images.url"-->
<!--                           v-bind:style="backgroundImage">-->
<!--                        </a>-->
<!--                    </div>-->
<!--                </div>-->


<!--                <div v-if="ability.charges && permission">-->
<!--                    <div class="charges relative">-->
<!--                        <div class="charge inline-block mr-2 h-5 w-5 cursor-pointer bg-white shadow-xs" v-for="n in ability.charges" v-on:click="useCharge(ability, n)"-->
<!--                             v-bind:class="{ used: ability.used_charges >= n }">-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->

<!--                <div class="text-center cursor-pointer" v-if="hasAttribute"-->
<!--                     v-on:click="click(ability)">-->
<!--                    <i class="fa-solid fa-chevron-down" v-if="!details"></i>-->
<!--                </div>-->
<!--                <div v-if="details && hasAttribute">-->
<!--                    <dl class="dl-horizontal">-->
<!--                        <div v-for="att in ability.attributes">-->
<!--                            <h4 v-if="att.type == 'section'" class="font-bold text-center" v-html="att.name"></h4>-->
<!--                            <div v-else>-->
<!--                                <dt>{{ att.name}}</dt>-->
<!--                                <dd v-if="att.type == 'checkbox'">-->
<!--                                    <i v-if="att.value == 1" class="fa-solid fa-check" aria-hidden="true"></i>-->
<!--                                </dd>-->
<!--                                <dd v-else v-html="att.value"></dd>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </dl>-->
<!--                </div>-->
<!--                <div class="text-center cursor-pointer" v-if="hasAttribute"-->
<!--                     v-on:click="click(ability)">-->
<!--                    <i class="fa-solid fa-chevron-up" v-if="details"></i>-->
<!--                </div>-->
<!--            </div>-->
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
            remainingNumber: function() {
                return this.ability.charges - this.ability.used_charges;
            },
            remainingText: function() {
                return this.ability.i18n.left.replace(/:amount/, '');
            },
            setVisibility: function(visibility_id) {
                let data = {
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
