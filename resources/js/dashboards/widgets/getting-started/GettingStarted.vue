<template>
    <div v-if="loading" class="flex items-center align-middle">
        <i class="fa-solid fa-spinner fa-spin" aria-label="Loading tasks"></i>
    </div>
    <div
        v-else
        class="flex flex-col gap-2">
        <div class="flex items-center justify-between gap-2 mb-3">

            <span
                class="widget-title block text-lg "
                v-html="name"></span>
            <span
                class="text-xs text-neutral-content"
                v-html="progress()">
            </span>
        </div>

        <div class="tasks flex flex-col gap-2 lg:gap-3 xl:gap-4">
            <div
                v-for="task in tasks"
            class="flex items-center gap-2 task">
                <div class="task-icon">
                    <i class="fa-regular fa-square-check" aria-label="Completed" v-if="task.completed"></i>
                    <i class="fa-regular fa-square" aria-label="Pending" v-else></i>
                </div>
                <a
                    v-if="!task.completed"
                    :href="task.url"
                    v-html="task.title"></a>
                <span
                    v-else
                    v-html="task.title"
                    class="line-through"></span>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import {ref, onMounted} from "vue";

const props = defineProps<{
    api: undefined,
    name: String,
}>()

const loading = ref(true)
const tasks = ref([])


onMounted(() => {
    axios.get(props.api).then(res => {
        tasks.value = res.data
        loading.value = false
    })
})

const progress = () => {
    let str = '';

    let total = tasks.value.length;
    let completed = tasks.value.filter(s => { return s.completed }).length;

    if (total == completed) {
        return '';
    }

    return completed + ' / ' + total;
}

</script>
