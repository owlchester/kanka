

<template>
    <div class="ability">
        <div class="box box-solid">
            <div class="box-header with-border">
                <span class="box-title">
                    <dropdown tag="a" menu-left class="message-options" v-if="permission">
                        <a class="dropdown-toggle" role="button">
                            <i class="fas fa-lock" v-if="ability.visibility === 'admin'" v-bind:title="translate('admin')"></i>
                            <i class="fas fa-user-lock" v-if="ability.visibility === 'admin-self'" v-bind:title="translate('admin-self')"></i>
                            <i class="fas fa-users" v-if="ability.visibility === 'members'" v-bind:title="translate('members')"></i>
                            <i class="fas fa-user-secret" v-if="ability.visibility === 'self'" v-bind:title="translate('self')"></i>
                            <i class="fa fa-eye" v-if="ability.visibility === 'all'" v-bind:title="translate('all')"></i>
                        </a>
                        <template slot="dropdown">
                            <li>
                                <a role="button" v-on:click="setVisibility('all')">{{ translate('all') }}</a>
                            </li>
                            <li v-if="meta.is_admin">
                                <a role="button" v-on:click="setVisibility('admin')">{{ translate('admin') }}</a>
                            </li>
                            <li v-if="this.isSelf">
                                <a role="button" v-on:click="setVisibility('self')">{{ translate('self') }}</a>
                            </li>
                            <li v-if="this.isSelf">
                                <a role="button" v-on:click="setVisibility('members')">{{ translate('members') }}</a>
                            </li>
                            <li v-if="this.isSelf">
                                <a role="button" v-on:click="setVisibility('admin.self')">{{ translate('admin-self') }}</a>
                            </li>
                        </template>
                    </dropdown>
                    <a role="button" v-on:click="showAbility(ability)">
                      {{ ability.name }}
                    </a>
                </span>
              <div class="box-tools">
                <a role="button"
                   v-on:click="updateAbility(ability)"
                   v-if="this.canDelete"
                   class="btn btn-box-tool"
                  v-bind:title="translate('update')">
                  <i class="fa fa-pencil"></i>
                </a>
                <a class="btn btn-box-tool" role="button" v-on:click="deleteAbility(ability)" v-if="this.canDelete" v-bind:title="translate('remove')">
                  <i class="fa fa-trash"></i>
                </a>
              </div>
            </div>
            <div class="box-body">
                <span class="help-block">{{ ability.type }}</span>

                <div v-html="ability.entry"></div>

                <div v-html="ability.note" class="help-block"></div>

                <div v-if="ability.charges">
                    <div class="charges">
                        <div class="charge" v-for="n in ability.charges" v-on:click="useCharge(ability, n)"
                             v-bind:class="{ used: ability.used_charges >= n }">
                        </div>
                    </div>
                </div>

                <div class="text-center more-available" v-if="hasAttribute"
                     v-on:click="click(ability)">
                    <i class="fa fa-chevron-down" v-if="!details"></i>
                </div>
                <div v-if="details && hasAttribute">
                    <dl class="dl-horizontal">
                        <div v-for="att in ability.attributes">
                            <div v-if="att.type == 'section'" class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">{{ att.name}}</h4>
                                </div>
                            </div>
                            <div v-else>
                                <dt>{{ att.name}}</dt>
                                <dd v-if="att.type == 'checkbox'">
                                    <i v-if="att.value == 1" class="fa fa-check"></i>
                                </dd>
                                <dd v-else v-html="att.value"></dd>
                            </div>
                        </div>
                    </dl>
                </div>
                <div class="text-center more-available" v-if="hasAttribute"
                     v-on:click="click(ability)">
                    <i class="fa fa-chevron-up" v-if="details"></i>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Event from '../event.js';

    export default {
        props: [
            'ability',
            'permission',
            'meta',
            'trans',
        ],

        data() {
            return {
                details: false,
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
                return this.meta.user_id == this.ability.created_by;
            }
        },

        methods: {
            click: function(ability) {
                this.details = !this.details;
            },
            deleteAbility: function(ability) {
                Event.$emit('delete_ability', ability);
            },
            updateAbility: function(ability) {
                axios.get(ability.actions.edit).then(response => {
                  $('#entity-modal').find('.modal-content').html(response.data);
                  $('#entity-modal').modal();
                });
            },
            showAbility: function(ability) {
                window.open(ability.actions.view, "_blank");
            },
            setVisibility: function(visibility) {
                var data = {
                    visibility: visibility,
                    ability_id: this.ability.ability_id,
                };
                axios.patch(this.ability.actions.update, data).then(response => {
                    this.ability.visibility = visibility;
                    Event.$emit('edited_ability', ability);
                })
                        .catch(() => {

                        });
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
            }
        }
    }
</script>
