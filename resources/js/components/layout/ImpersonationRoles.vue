<template>
    <section class="flex flex-col gap-2">
        <h3 class="m-0 text-xs font-semibold text-neutral-content">{{ impersonation.rolesLabel }}</h3>
        <ul v-if="impersonation.roles.length" class="m-0 flex list-none flex-wrap gap-2 p-0" role="list">
            <li v-for="(role, index) in impersonation.roles" :key="index" class="max-w-full rounded-md bg-base-200 px-2 py-1 text-sm wrap-anywhere">
                {{ role }}
            </li>
        </ul>
        <p v-else class="m-0 text-sm">{{ impersonation.noRolesLabel }}</p>
    </section>
</template>

<script setup lang="ts">
import type { Impersonation } from './impersonation'

defineProps<{ impersonation: Impersonation }>()
</script>
