<template>
    <div class="entity-header p-3 bg-entity-focus">
        <div class="w-full flex items-center">

            <a class="text-2xl font-extrabold entity-name" v-bind:href="entity.link" :title="entity.name" v-html="entity.name">
            </a>

            <i class="fa-regular fa-skull mx-2" aria-hidden="true" v-if="entity.is_dead"></i>

            <a class="ml-2 text-xs" target="_blank" v-bind:href="entity.link">
                <i class="fa-regular fa-external-link" aria-hidden="true" aria-label="Open in a new window"></i>
            </a>
        </div>
        <div class="block w-full" v-if="hasTitle()" v-html="entity.title">
        </div>
        <div class="my-1 w-full flex flex-wrap gap-1" v-if="entity.tags.length > 0">
            <a :class="tagClass(tag)" v-for="tag in entity.tags"
                v-bind:href="tag.link"
               :data-tag-id="tag.id"
               :data-tag-slug="tag.slug"

               v-html="tag.name"
                >
            </a>
        </div>
        <a class="block w-full cursor-pointer my-2"
           v-if="entity.location"
           v-bind:href="entity.location.link"
           :data-tag="entity.id"
        >
            <i class="fa-duotone circle-location-arrow" aria-hidden="true" aria-label="Location"></i>
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
            <div v-bind:class="tabClass('profile')" v-on:click="switchTab('profile')">{{ entity.texts.profile }}</div>
            <div v-bind:class="tabClass('links')" v-on:click="switchTab('links')">{{ entity.texts.connections }}</div>
            <div v-bind:class="tabClass('access')" v-on:click="switchTab('access')"></div>
        </div>
        <div class="tab-profile p-5 flex flex-col gap-5" v-if="focus_profile">
            <div class="entity-pinned-attributes flex flex-col gap-3" v-if="entity.attributes.length > 0">
                <div v-for="attribute in entity.attributes" class="" v-bind:data-attribute="attribute.name" v-bind:data-target="attribute.id">
                    <span class="inline-block uppercase font-extrabold mr-1" v-html="attribute.name"></span>
                    <span v-html="attribute.value"></span>
                </div>
            </div>
          <hr  v-if="entity.attributes.length > 0" />
          <div class="flex flex-col gap-3">
            <div v-for="profile in entity.profile" class="" v-bind:class="profileClass(profile)">
                <div class="uppercase font-extrabold truncate" v-html="profile.field"></div>
                <div v-html="profile.value"></div>
            </div>
          </div>
        </div>
        <div class="tab-links p-3" v-if="focus_pins">
            <LookupEntity  v-for="relation in entity.connections"
                :entity="relation">
            </LookupEntity>
            <p class="text-center italic" v-if="entity.connections.length === 0">
                {{ entity.texts['no-connections'] }}
            </p>
        </div>
    </div>
</template>

<script setup lang="ts">
import LookupEntity from "./LookupEntity.vue";
import {ref} from "vue";

const props = defineProps<{
  entity: Object,
}>()

const focus_profile = ref(true);
const focus_pins = ref(false);
const focus_access = ref(false);

const hasTitle = () => {
    return props.entity.title;
}
const tagClass = (tag) => {
    let cls = 'inline-block rounded-xl px-3 py-1 bg-base-100 text-base-content text-xs';
    if (tag.colour) {
        cls += ' bg-' + tag.colour;
        if (tag.colour === 'black') {
            cls += ' text-white';
        }
    }
    return cls;
}

const backgroundImage = () => {
    return 'url(\'' + props.entity.image + '\')';
}

const tabClass = (tab) => {
    let cls = 'p-1 px-1 mx-1 pt-2 select-none text-center truncate border-b-2 border-solid border-r-0 border-t-0 border-l-0';
    if ((tab === 'profile' && focus_profile.value) || (tab === 'links' && focus_pins.value) || (tab === 'access' && focus_access.value)) {
        cls += ' font-black border-slate-600';
    } else {
        cls += ' cursor-pointer border-base-100';
    }

    return cls;
}

const switchTab = (tab) => {
    focus_profile.value = false;
    focus_pins.value = false;
    focus_access.value = false;
    if (tab === 'profile') {
        focus_profile.value = true;
    } else if (tab === 'links') {
        focus_pins.value = true;
    } else if (tab === 'access') {
        focus_access.value = true;
    }
}

const profileClass = (profile) => {
    return 'entity-profile-' + profile.slug;
}
</script>
