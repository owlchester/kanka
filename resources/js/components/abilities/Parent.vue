

<template>
    <div class="ability-parent flex flex-col gap-5 w-full"
    >
        <div class="parent-head flex gap-2 md:gap-5 items-center">
            <div
                class="parent-image rounded-full w-12 h-12 md:w-16 md:h-16 cover-background flex-none"
                v-if="group.has_image"
                v-bind:style="backgroundImage()">
            </div>
            <div class="flex flex-col gap-1 grow overflow-hidden">
                <div v-if="group.url">
                    <a v-bind:href="group.url" v-html="group.name" class="parent-name text-xl md:text-2xl"></a>
                </div>
                <span v-else class="parent-name text-xl md:text-2xl" v-html="group.name"></span>
                <p class="md:text-lg truncate" v-html="group.type"></p>
            </div>
            <div class="flex-none self-end">
                <span role="button" @click="click(group)" class="cursor-pointer inline-block">
                    <i v-if="!collapsed" aria-hidden="true" class="fa-thin fa-chevron-circle-up fa-2x"></i>
                    <i v-else aria-hidden="true" class="fa-thin fa-chevron-circle-down fa-2x"></i>
                </span>
            </div>
        </div>
        <div class="parent-abilities flex flex-col gap-5" v-if="!collapsed">
            <ability v-for="ability in group.abilities"
                    :key="ability.id"
                    :ability="ability"
                     :permission="permission"
                     :meta="meta">
            </ability>
        </div>
    </div>
</template>

<script setup lang="ts">

import Ability from "./Ability.vue";
import {ref} from "vue"


const props = defineProps<{
    group: Object,
    permission: String,
    meta: Object,
}>()

const collapsed = ref(false)

const backgroundImage = () => {
    if (props.group.has_image) {
        return {
            backgroundImage: 'url(' + props.group.image + ')'
        }
    }
    return {}
}

const click = (group) => {
    collapsed.value = !collapsed.value;
}
</script>
