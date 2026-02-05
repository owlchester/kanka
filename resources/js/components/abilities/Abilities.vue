<template>
    <div class="viewport box-abilities relative flex flex-col gap-5">
        <div v-if="loading" class="load more text-center text-2xl">
            <i class="fa-solid fa-spin fa-spinner" aria-hidden="true"></i>
        </div>

        <div class="flex gap-5 flex-wrap">
            <parent v-for="group in groups"
                :key="group.id"
                :group="group"
                :permission="permission"
                :meta="meta">
            </parent>
        </div>
    </div>
</template>


<script setup lang="ts">
import Parent from "./Parent.vue";

import {onMounted, onUpdated, ref} from "vue"

const props = defineProps<{
    id: Number,
    api: String,
    permission: String,
}>()

const groups = ref([])
const meta = ref([])
const loading = ref(true)
const waiting = ref(true)

const getAbilities = () => {
    axios.get(props.api).then(res => {
        groups.value = res.data.data.groups;
        meta.value = res.data.data.meta;
        loading.value = false;
        waiting.value = false;
    })
}


onMounted(() => {
    getAbilities()
})

onUpdated(() => {
    // Add the ajax tooltip listener when the dom is updated (for example when displaying
    // children abilities)
    window.ajaxTooltip();
    window.initTooltips();
})

</script>
