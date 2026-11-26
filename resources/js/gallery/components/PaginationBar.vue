<template>
    <div
        v-if="pagination.total > 0"
        class="bg-base-100 rounded-xl px-3 py-2.5 md:px-4 flex flex-col sm:flex-row items-center justify-between gap-3 text-sm shadow-sm"
    >
        <div class="text-xs md:text-sm text-neutral-content tabular-nums">
            {{ trans('showing', { from: pagination.from, to: pagination.to, total: pagination.total }) }}
        </div>

        <div class="flex items-center gap-1 flex-wrap justify-center" v-if="pagination.last_page > 1">
            <button
                type="button"
                class="btn2 btn-ghost btn-xs"
                :disabled="pagination.current_page <= 1"
                @click="$emit('page', pagination.current_page - 1)"
            >
                <i class="fa-regular fa-chevron-left" aria-hidden="true"></i>
                <span class="hidden sm:inline">{{ trans('previous') }}</span>
            </button>

            <template v-for="(item, idx) in pageItems" :key="idx">
                <span v-if="item === '...'" class="px-2 text-neutral-content select-none">…</span>
                <button
                    v-else
                    type="button"
                    class="btn2 btn-xs min-w-7 justify-center tabular-nums"
                    :class="item === pagination.current_page ? 'btn-primary' : 'btn-ghost'"
                    @click="$emit('page', item)"
                >
                    {{ item }}
                </button>
            </template>

            <button
                type="button"
                class="btn2 btn-ghost btn-xs"
                :disabled="pagination.current_page >= pagination.last_page"
                @click="$emit('page', pagination.current_page + 1)"
            >
                <span class="hidden sm:inline">{{ trans('next') }}</span>
                <i class="fa-regular fa-chevron-right" aria-hidden="true"></i>
            </button>
        </div>

        <div class="flex items-center gap-2 text-xs">
            <label for="gallery-per-page" class="text-neutral-content whitespace-nowrap">{{ trans('per_page') }}</label>
            <select
                id="gallery-per-page"
                class="select select-xs bg-base-200 rounded-lg px-2 py-1 text-xs"
                :value="perPage"
                @change="$emit('per-page', Number(($event.target as HTMLSelectElement).value))"
            >
                <option :value="24">24</option>
                <option :value="48">48</option>
                <option :value="96">96</option>
            </select>
        </div>
    </div>
</template>

<script setup lang="ts">
import { computed } from 'vue'
import type { GalleryPagination } from '../types'

const props = defineProps<{
    pagination: GalleryPagination
    perPage: number
    trans: (key: string, replacements?: Record<string, string | number>) => string
}>()

defineEmits<{
    (e: 'page', page: number): void
    (e: 'per-page', perPage: number): void
}>()

const pageItems = computed<(number | '...')[]>(() => {
    const current = props.pagination.current_page
    const last = props.pagination.last_page
    if (last <= 7) {
        return Array.from({ length: last }, (_, i) => i + 1)
    }

    const pages: (number | '...')[] = [1]
    const start = Math.max(2, current - 1)
    const end = Math.min(last - 1, current + 1)

    if (start > 2) pages.push('...')
    for (let p = start; p <= end; p++) pages.push(p)
    if (end < last - 1) pages.push('...')
    pages.push(last)

    return pages
})
</script>
