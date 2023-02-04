<template>
    <div class="entity-header p-3 bg-slate-300">
        <div class="block text-2xl font-extrabold">
            {{ entity.name }}
        </div>
        <div class="block w-full" v-if="hasTitle()">
            {{ entity.title}}
        </div>
        <div class="my-2" v-if="entity.tags.length > 0">
            <a :class="tagClass(tag)" v-for="tag in entity.tags"
                v-bind:href="tag.link"
                >
                {{ tag.name }}
            </a>
        </div>
        <a class="block cursor-pointer my-2"
           v-if="entity.location"
           v-bind:href="entity.location.link"
           :data-tag="entity.id"
        >
            <i class="ra ra-tower" aria-hidden="true" aria-label="Location"></i>
            {{ entity.location.name }}
        </a>
        <a
            v-if="entity.image"
            v-bind:href="entity.link"
            v-bind:style="{backgroundImage: backgroundImage()}"
            :title="entity.name"
            class="rounded cover-background block w-full aspect-square">
        </a>
    </div>
    <div class="entity-sections">
        <div class="tabs flex my-2 justify-center items-center border-solid border-slate-600 border-b-2 border-r-0 border-t-0 border-l-0">
            <div v-bind:class="tabClass('profile')" v-on:click="switchTab('profile')">Profile</div>
            <div v-bind:class="tabClass('connections')" v-on:click="switchTab('connections')">Connections</div>
            <div v-bind:class="tabClass('access')" v-on:click="switchTab('access')"></div>
        </div>
        <div class="tab-profile p-3" v-if="focus_profile">
            <div class="entity-pinned-attributes" v-if="entity.attributes.length > 0">
                <div  v-for="attribute in entity.attributes" class="mb-3">
                    <span class="inline-block text-uppercase font-extrabold mr-1">
                        {{ attribute.name }}
                    </span>
                    <span v-html="attribute.value"></span>
                </div>
                <hr />
            </div>
            <div v-for="profile in entity.profile" class="mb-3" v-bind:class="profileClass(profile)">
                <div class="text-uppercase font-extrabold truncate">
                    {{ profile.field }}
                </div>
                <div>
                    {{ profile.value }}
                </div>
            </div>
        </div>
        <div class="tab-connections p-3" v-if="focus_connections">
            <LookupEntity  v-for="relation in entity.connections"
                :entity="relation">
            </LookupEntity>
        </div>
    </div>
</template>

<script>
import LookupEntity from "./LookupEntity";

export default {
    props: [
        'entity'
    ],
    components: {
        LookupEntity,
    },
    data() {
        return {
            focus_profile: true,
            focus_connections: false,
            focus_access: false,
        }
    },
    methods: {
        hasTitle() {
            return this.entity.title;
        },
        tagClass(tag) {
            let cls = 'inline-block rounded-xl px-3 py-1 mr-1 bg-neutral-400 text-black text-xs mb-1';
            if (tag.colour) {
                cls += ' bg-' + tag.colour;
            }
            return cls;
        },
        backgroundImage: function() {
            return 'url(' + this.entity.image + ')';
        },
        tabClass: function(tab) {
            let cls = 'p-1 px-1 mx-1 pt-2 select-none text-center truncate border-b-2';
            if ((tab === 'profile' && this.focus_profile) || (tab === 'connections' && this.focus_connections) || (tab === 'access' && this.focus_access)) {
                cls += ' font-black border-solid border-slate-600 border-r-0 border-t-0 border-l-0';
            } else {
                cls += ' cursor-pointer';
            }

            return cls;
        },
        switchTab: function (tab) {
            this.focus_profile = false;
            this.focus_connections = false;
            this.focus_access = false;
            if (tab === 'profile') {
                this.focus_profile = true;
            } else if (tab === 'connections') {
                this.focus_connections = true;
            } else if (tab === 'access') {
                this.focus_access = true;
            }
        },
        profileClass: function (profile) {
            return 'entity-profile-' + profile.slug;
        }
    }
}
</script>
