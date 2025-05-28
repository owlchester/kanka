

<template>
    <div class="ability" v-bind:data-tags="ability.class">
        <div class="ability-box p-4 rounded bg-box shadow-xs flex flex-col md:flex-row items-center md:items-start gap-2 md:gap-4">
            <div class="" v-if="ability.images.has">
                <a class="ability-image rounded-xl block w-40 h-40 cover-background"
                   v-bind:href="ability.images.url"
                   v-bind:style="backgroundImage()">
                </a>
            </div>
            <div class="flex flex-col gap-4 w-full">
                <div class="flex gap-2 md:gap-4 items-center w-full">
                    <div class="flex gap-2 items-center text-xl grow">
                        <a v-bind:href="ability.actions.view" class="ability-name text-2xl" v-html="ability.name"></a>
                        <i class="fa-regular fa-lock" v-if="ability.visibility_id === 2" v-bind:title="ability.visibility"></i>
                        <i class="fa-regular fa-user-lock" v-if="ability.visibility_id === 3" v-bind:title="ability.visibility"></i>
                        <i class="fa-regular fa-users" v-if="ability.visibility_id === 5" v-bind:title="ability.visibility"></i>
                        <i class="fa-regular fa-user-secret" v-if="ability.visibility_id === 4" v-bind:title="ability.visibility"></i>
                        <i class="fa-regular fa-eye" v-if="ability.visibility_id === 1" v-bind:title="ability.visibility"></i>
                    </div>
                    <div v-if="ability.type" class="hidden md:inline bg-base-200 p-2 rounded-xl flex-none" v-html="ability.type"></div>

                    <div v-if="permission" class="">
                        <a role="button"
                            v-on:click="updateAbility(ability)"
                            v-if="canDelete"
                            class="btn2 btn-ghost btn-sm"
                            v-bind:title="ability.i18n.edit">
                            <i class="fa-regular fa-pencil text-xl" aria-hidden="true"></i>
                            <span class="sr-only" v-html="ability.i18n.edit"></span>
                        </a>
                    </div>
                </div>

                <div v-if="ability.type" class="visible md:hidden">
                    <div class="inline-block bg-base-200 p-2 rounded-xl" v-html="ability.type"></div>
                </div>
                <div class="entity-content" v-if="ability.entry" v-html="ability.entry"></div>
                <div class="flex gap-2 items-center ability-tags" v-if="ability.tags">
                    <a v-for="tag in ability.tags"
                       v-bind:class="tagClass(tag)"
                       v-bind:href="tag.url"
                       data-toggle="tooltip-ajax"
                       v-bind:data-url="tag.tooltip"

                       v-html="tag.name">
                    </a>
                </div>
                <div class="entity-content" v-if="ability.note" v-html="ability.note">
                </div>

                <div v-if="ability.charges && permission" class="flex gap-2 md:gap-4 ability-charges w-full items-end">
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
        </div>
    </div>
</template>

<script setup lang="ts">

import {ref} from "vue"

const details = ref(false)

const props = defineProps<{
    ability: Object,
    permission: String,
}>()

const hasAttribute = () => {
    return props.ability.attributes.length > 0;
}

const canDelete = () => {
    return props.permission.value;
}

const backgroundImage = () => {
    if (props.ability.images.thumb) {
        return {
            backgroundImage: 'url(' + props.ability.images.thumb + ')'
        }
    }
    return {}
}

const updateAbility = (ability) => {
    window.openDialog('abilities-dialog', ability.actions.edit);
}

const remainingNumber = () => {
    return props.ability.charges - props.ability.used_charges;
}

const remainingText = () => {
    return props.ability.i18n.left.replace(/:amount/, '');
}

const tagClass = (tag) => {
   let css = 'rounded-xl bg-base-200 text-xs py-1 px-3 text-base-content';
   return css += ' ' + tag.class;
};

const useCharge = (ability, charge) => {
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
}
</script>
