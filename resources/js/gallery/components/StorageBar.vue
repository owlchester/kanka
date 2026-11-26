<template>
    <div class="bg-base-100 rounded-xl p-3 md:p-4 flex flex-col sm:flex-row sm:items-center gap-3 md:gap-4 shadow-sm">
        <div class="flex flex-col gap-1.5 grow min-w-0">
            <div class="flex items-center justify-between gap-2 text-sm">
                <div class="flex items-center gap-2 font-semibold">
                    <i class="fa-regular fa-cloud text-base text-primary" aria-hidden="true"></i>
                    <span>{{ trans('storage') }}</span>
                </div>
                <div class="text-xs sm:text-sm text-base-content/80 tabular-nums">
                    <span class="font-medium">{{ human(used) }}</span>
                    <span class="mx-1 text-neutral-content">{{ trans('of') }}</span>
                    <span>{{ total === 0 ? '∞' : human(total) }}</span>
                    <span v-if="total > 0" class="ml-1.5 text-neutral-content">({{ percentage }}%)</span>
                </div>
            </div>
            <div class="bg-base-300 rounded-full h-2 w-full overflow-hidden">
                <div :class="barClasses" :style="{ width: percentage + '%' }"></div>
            </div>
        </div>

        <div class="flex items-center gap-2 shrink-0 flex-wrap">
            <button
                type="button"
                class="btn2 btn-default btn-sm"
                @click="$emit('cleanup')"
                :title="trans('cleanup_unused')"
            >
                <i class="fa-regular fa-broom-wide" aria-hidden="true"></i>
                <span class="hidden md:inline">{{ trans('cleanup_unused') }}</span>
                <span class="md:hidden">{{ trans('usage_unused') }}</span>
            </button>
            <a
                v-if="upgradeLink && (!premium || (percentage > 89 && (isWyvern || isElemental)))"
                :href="upgradeLink"
                class="btn2 btn-primary btn-sm"
            >
                <i class="fa-regular fa-gem" aria-hidden="true"></i>
                <span>{{ trans('upgrade') }}</span>
            </a>
        </div>
    </div>
</template>

<script setup lang="ts">
import { computed } from 'vue'

const props = defineProps<{
    used: number
    total: number
    premium: boolean
    isWyvern: boolean
    isElemental: boolean
    upgradeLink: string | null
    trans: (key: string) => string
}>()

defineEmits<{
    (e: 'cleanup'): void
}>()

const percentage = computed(() => {
    if (!props.total || props.total === 0) return 0
    return Math.min(100, Math.round((props.used / props.total) * 100))
})

const barClasses = computed(() => {
    const base = 'rounded-full h-2 transition-all duration-300'
    if (percentage.value < 60) return `${base} bg-primary`
    if (percentage.value < 90) return `${base} bg-orange-400`
    return `${base} bg-red-500`
})

const human = (kb: number): string => {
    if (!kb || kb === 0) return '0 KiB'
    if (kb >= 1024 * 1024) return (kb / (1024 * 1024)).toFixed(2) + ' GiB'
    if (kb >= 1024) return (kb / 1024).toFixed(2) + ' MiB'
    return Number(kb).toFixed(0) + ' KiB'
}
</script>
