

<template>
    <div class="ability">
        <div class="box box-solid">
            <div class="box-header with-border">
                <span class="box-title">
                    {{ ability.name }}
                </span>
                <i class="fas fa-lock pull-right" v-if="ability.visibility === 'admin'"></i>
                <i class="fas fa-user-lock pull-right" v-if="ability.visibility === 'self'"></i>

                <dropdown tag="a" menu-right class="message-options pull-right" v-if="permission">
                    <a class="dropdown-toggle" role="button"><span class="caret"></span></a>
                    <template slot="dropdown">
                        <li><a role="button" v-on:click="editMessage(ability)">{{ $t('crud.edit') }}</a></li>
                        <li><a role="button" v-on:click="deleteMessage(ability)">{{ $t('crud.remove') }}</a></li>
                    </template>
                </dropdown>
            </div>
            <div class="box-body">
                <span class="help-block">{{ ability.type }}</span>

                <div v-html="ability.entry"></div>

                <div class="text-center more-available" v-if="hasAttribute"
                     v-on:click="click(ability)">
                    <i class="fa fa-chevron-down" v-if="!details"></i>
                </div>
                <div v-if="details && hasAttribute">
                    <hr />
                    <dl class="dl-horizontal">
                        <div v-for="att in ability.attributes">
                            <dt>{{ att.name}}</dt>
                            <dd v-html="att.value"></dd>
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
        ],

        data() {
            return {
                details: false,
            }
        },

        computed: {
            hasAttribute: function() {
                console.log('attr', this.ability.attributes.length);
                return this.ability.attributes.length > 0;
            },
            canChange: function() {
                return this.permission;
            }
        },

        methods: {
            click: function(ability) {
                this.details = !this.details;
            },
            delete: function(ability) {
                Event.$emit('delete_ability', ability);
            },
        }
    }
</script>
