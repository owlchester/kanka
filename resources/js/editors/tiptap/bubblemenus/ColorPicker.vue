<script setup lang="ts">
import { ref, onMounted, onBeforeUnmount, computed } from 'vue'
import { buttonClass } from '../utils'

const props = defineProps<{
    currentColor: string | null
    icon: string
    title: string
}>()

const emit = defineEmits<{
    select: [color: string | null]
}>()

const RECENT_COLORS_KEY = 'recent_colors'
const MAX_COLORS = 10

const pickerId = Math.random().toString(36).substring(7)
const showPicker = ref(false)
const customColor = ref('')
const recentColors = ref<string[]>([])

const presetColors = [
    '#000000', '#434343', '#666666', '#999999', '#cccccc', '#efefef', '#ffffff',
    '#FB0300', '#FF9900', '#FFFF01', '#00FF00', '#00FFFF', '#0000FF', '#9900FF',
    '#FB3533', '#FFAD33', '#FFFF34', '#33FF33', '#33FFFF', '#3333FF', '#AD33FF',
    '#FC6866', '#FFC266', '#FFFF67', '#66FF66', '#66FFFF', '#6666FF', '#C266FF',
    '#FD9B99', '#FFD699', '#FFFF9A', '#99FF99', '#99FFFF', '#9999FF', '#D699FF',
    '#FECECC', '#FFEBCC', '#FFFFCD', '#CCFFCC', '#CCFFFF', '#CCCCFF', '#EBCCFF',
    '#FEE1E0', '#FFF3E0', '#FFFFE1', '#E0FFE0', '#E0FFFF', '#E0E0FF', '#F3E0FF',
    '#FFF5F4', '#FFF9F4', '#FFFFF5', '#F4FFF4', '#F4FFFF', '#F4F4FF', '#F9F4FF',
]

const getCookies = () => {
    return document.cookie.split(';').reduce((cookies: Record<string, string>, cookie) => {
        const [key, value] = cookie.split('=').map(c => c.trim())
        if (key && value) cookies[key] = decodeURIComponent(value)
        return cookies
    }, {})
}

const setCookie = (name: string, value: string, days = 30) => {
    const date = new Date()
    date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000))
    document.cookie = `${name}=${encodeURIComponent(value)}; expires=${date.toUTCString()}; path=/`
}

const loadRecentColors = () => {
    const cookies = getCookies()
    recentColors.value = cookies[RECENT_COLORS_KEY] ? JSON.parse(cookies[RECENT_COLORS_KEY]) : []
}

const saveRecentColor = (color: string) => {
    recentColors.value = [color, ...recentColors.value.filter(c => c !== color)]
    if (recentColors.value.length > MAX_COLORS) {
        recentColors.value = recentColors.value.slice(0, MAX_COLORS)
    }
    setCookie(RECENT_COLORS_KEY, JSON.stringify(recentColors.value))
}

const selectColor = (color: string) => {
    saveRecentColor(color)
    emit('select', color)
    showPicker.value = false
}

const selectCustomColor = () => {
    if (customColor.value && /^#[0-9A-Fa-f]{6}$/.test(customColor.value)) {
        selectColor(customColor.value)
        customColor.value = ''
    }
}

const clearColor = () => {
    emit('select', null)
    showPicker.value = false
}

const handleCloseOthers = (event: CustomEvent) => {
    if (event.detail !== pickerId) {
        showPicker.value = false
    }
}

const togglePicker = () => {
    if (!showPicker.value) {
        // Close other color pickers
        window.dispatchEvent(new CustomEvent('colorpicker:close', { detail: pickerId }))
        loadRecentColors()
    }
    showPicker.value = !showPicker.value
}

const hasColor = computed(() => !!props.currentColor)

onMounted(() => {
    loadRecentColors()
    window.addEventListener('colorpicker:close', handleCloseOthers as EventListener)
})

onBeforeUnmount(() => {
    window.removeEventListener('colorpicker:close', handleCloseOthers as EventListener)
})
</script>

<template>
    <div class="relative">
        <button
            @click.prevent="togglePicker"
            :class="buttonClass(hasColor)"
            class="flex items-center gap-0.5"
            :title="title"
        >
            <i :class="icon" aria-hidden="true"></i>
            <span
                v-if="currentColor"
                class="w-2 h-2 rounded-full border border-base-300"
                :style="{ backgroundColor: currentColor }"
            ></span>
        </button>

        <div
            v-show="showPicker"
            class="absolute top-full left-0 mt-1 bg-base-100 shadow-lg rounded-lg p-3 z-50 w-[220px]"
        >
            <!-- Recent colors -->
            <div v-if="recentColors.length > 0" class="mb-2">
                <div class="text-xs text-neutral-content mb-1">Recent</div>
                <div class="flex flex-wrap gap-1">
                    <button
                        v-for="color in recentColors"
                        :key="color"
                        @mousedown.prevent="selectColor(color)"
                        class="w-5 h-5 rounded border border-base-300 hover:scale-110 transition-transform"
                        :style="{ backgroundColor: color }"
                        :title="color"
                    ></button>
                </div>
            </div>

            <!-- Preset colors -->
            <div class="mb-2">
                <div class="text-xs text-neutral-content mb-1">Colors</div>
                <div class="grid grid-cols-7 gap-1">
                    <button
                        v-for="color in presetColors"
                        :key="color"
                        @mousedown.prevent="selectColor(color)"
                        class="w-5 h-5 rounded border border-base-300 hover:scale-110 transition-transform"
                        :style="{ backgroundColor: color }"
                        :title="color"
                    ></button>
                </div>
            </div>

            <!-- Custom color input -->
            <div class="mb-2">
                <input
                    v-model="customColor"
                    type="text"
                    placeholder="#000000"
                    maxlength="7"
                    class="w-full p-1 text-xs rounded border border-base-300 outline-none focus:ring-1 focus:ring-primary"
                    @keydown.enter.prevent="selectCustomColor"
                    @blur="selectCustomColor"
                />
            </div>

            <!-- Clear button -->
            <button
                @mousedown.prevent="clearColor"
                class="w-full text-xs text-neutral-content hover:text-error py-1 flex items-center justify-center gap-1 cursor-pointer"
            >
                <i class="fa-regular fa-eraser" aria-hidden="true"></i>
                Remove color
            </button>
        </div>
    </div>
</template>
