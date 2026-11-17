<template>
    <MobileSheet :model-value="modelValue" :title="title" :close-label="closeLabel" :back-label="backLabel" @update:model-value="emit('update:modelValue', $event)" @back="back">
        <div v-if="!authenticated" class="flex flex-col gap-4">
            <p class="text-sm text-neutral-content">{{ texts.guest }}</p>
            <a :href="loginUrl" class="btn2 btn-primary min-h-11">{{ loginLabel }}</a>
            <a v-if="registerUrl" :href="registerUrl" class="btn2 btn-outline min-h-11">{{ texts.register }}</a>
            <button type="button" class="min-h-11 text-sm text-link" @click="emit('update:modelValue', false)">{{ texts.browse }}</button>
        </div>
        <div v-else-if="loading" class="flex min-h-32 items-center justify-center" role="status" :aria-label="texts.loading">
            <i class="fa-solid fa-spinner fa-spin" aria-hidden="true"></i>
        </div>
        <div v-else-if="error" class="flex flex-col gap-4">
            <p class="text-sm text-neutral-content">{{ texts.error }}</p>
            <button type="button" class="btn2 btn-outline min-h-11" @click="load">{{ texts.retry }}</button>
        </div>
        <template v-else-if="data">
            <div v-if="panel === 'home'" class="flex flex-col gap-5">
                <div class="flex min-w-0 items-center gap-3">
                    <component :is="data.profile.is_impersonating ? 'span' : 'a'" :href="data.profile.urls?.settings.url" :aria-label="data.profile.urls?.settings.name" class="flex size-11 shrink-0 items-center justify-center rounded-xl">
                        <img v-if="avatar && !avatar.startsWith('/images/')" :src="avatar" alt="" class="size-11 rounded-xl object-cover" />
                        <span v-else class="flex size-11 items-center justify-center rounded-xl bg-base-200 font-semibold uppercase">{{ initials }}</span>
                    </component>
                    <div class="min-w-0">
                        <div class="truncate" v-text="data.profile.name"></div>
                        <div class="truncate text-xs text-neutral-content" v-text="data.profile.email"></div>
                    </div>
                </div>
                <section class="overflow-hidden rounded-xl border border-base-300">
                    <div class="px-4 pt-3 text-xs text-neutral-content">{{ texts.current_world }}</div>
                    <a :href="worldUrl" class="flex min-h-12 items-center justify-between gap-3 px-4 pb-2 text-link">
                        <span class="min-w-0 truncate">{{ worldName }}</span>
                        <span class="flex shrink-0 items-center gap-2 text-xs">{{ texts.home }}<i class="fa-regular fa-angle-right" aria-hidden="true"></i></span>
                    </a>
                    <button v-if="!data.profile.is_impersonating" type="button" class="flex min-h-12 w-full items-center gap-3 border-t border-base-300 px-4 text-left hover:bg-base-200" @click="panel = 'worlds'">
                        <i class="fa-regular fa-grid-2 text-neutral-content" aria-hidden="true"></i>
                        <span class="grow">{{ texts.switch_world }}</span>
                        <i class="fa-regular fa-angle-right text-neutral-content" aria-hidden="true"></i>
                    </button>
                </section>
                <div class="flex flex-col gap-1">
                    <button v-if="data.notifications.title" type="button" class="flex min-h-12 items-center gap-3 rounded-xl px-3 text-left hover:bg-base-200" @click="panel = 'notifications'">
                        <i class="fa-regular fa-bell w-5 text-neutral-content" aria-hidden="true"></i>
                        <span class="grow">{{ data.notifications.title }}</span>
                        <span v-if="data.notifications.messages?.length" class="rounded-full bg-base-200 px-2 text-xs">{{ data.notifications.messages.length }}</span>
                        <i class="fa-regular fa-angle-right text-neutral-content" aria-hidden="true"></i>
                    </button>
                    <template v-if="!data.profile.is_impersonating">
                        <a :href="data.profile.urls.settings.url" class="flex min-h-12 items-center gap-3 rounded-xl px-3 hover:bg-base-200">
                            <i class="fa-regular fa-gear w-5 text-neutral-content" aria-hidden="true"></i><span>{{ texts.preferences }}</span>
                        </a>
                        <button type="button" class="flex min-h-12 items-center gap-3 rounded-xl px-3 text-left hover:bg-base-200" @click="panel = 'more'">
                            <i class="fa-regular fa-ellipsis w-5 text-neutral-content" aria-hidden="true"></i><span class="grow">{{ texts.more }}</span><i class="fa-regular fa-angle-right text-neutral-content" aria-hidden="true"></i>
                        </button>
                        <button type="button" class="flex min-h-12 items-center gap-3 rounded-xl px-3 text-left text-neutral-content hover:bg-base-200" @click="logout">
                            <i class="fa-regular fa-sign-out w-5" aria-hidden="true"></i><span>{{ data.profile.urls.logout.name }}</span>
                        </button>
                    </template>
                    <a v-else :href="data.profile.return.url" class="flex min-h-12 items-center gap-3 rounded-xl px-3 text-link">{{ data.profile.return.name }}</a>
                </div>
            </div>
            <div v-else-if="panel === 'worlds'" class="flex flex-col gap-5">
                <section v-for="group in worldGroups" :key="group.key">
                    <h3 class="mb-2 text-xs text-neutral-content">{{ group.label }}</h3>
                    <div class="flex flex-col gap-1">
                        <a v-for="world in group.worlds" :key="world.url" :href="world.url" class="flex min-h-14 items-center gap-3 rounded-xl px-2 hover:bg-base-200">
                            <img :src="world.image || worldPlaceholder" alt="" class="size-10 shrink-0 rounded-lg object-cover" />
                            <span class="min-w-0 grow break-words">{{ world.name }}</span>
                            <i class="fa-regular fa-angle-right shrink-0 text-neutral-content" aria-hidden="true"></i>
                        </a>
                    </div>
                </section>
                <div class="flex flex-col gap-1 border-t border-base-300 pt-3">
                    <a :href="data.campaigns.urls.new" class="flex min-h-11 items-center gap-3 px-2 text-link"><i class="fa-regular fa-plus" aria-hidden="true"></i>{{ texts.new_world }}</a>
                    <a :href="data.campaigns.urls.follow" class="flex min-h-11 items-center gap-3 px-2 text-link"><i class="fa-regular fa-compass" aria-hidden="true"></i>{{ texts.discover }}</a>
                    <a :href="data.campaigns.urls.reorder" class="flex min-h-11 items-center gap-3 px-2 text-link"><i class="fa-regular fa-arrow-up-arrow-down" aria-hidden="true"></i>{{ data.campaigns.texts.reorder }}</a>
                </div>
            </div>
            <div v-else-if="panel === 'notifications'" class="flex flex-col gap-3">
                <a :href="data.notifications.all.url" class="flex min-h-11 items-center text-sm text-link">{{ data.notifications.all.text }}</a>
                <Notification v-for="notification in data.notifications.messages" :key="notification.id" :notification="notification" @read="readNotification" />
                <p v-if="!data.notifications.messages.length" class="text-sm text-neutral-content">{{ data.notifications.none }}</p>
            </div>
            <div v-else-if="panel === 'more'" class="flex flex-col gap-4">
                <div class="flex flex-col gap-1">
                    <a :href="data.profile.urls.profile.url" class="flex min-h-11 items-center gap-3 text-link">{{ data.profile.urls.profile.name }}</a>
                    <a v-if="data.profile.subscription" :href="data.profile.urls.subscription" class="flex min-h-11 items-center gap-3 text-link">{{ data.profile.subscription.title }}</a>
                    <a href="https://plugins.kanka.io" class="flex min-h-11 items-center gap-3 text-link">{{ data.marketplace.title }}</a>
                    <a :href="data.profile.urls.help.url" class="flex min-h-11 items-center gap-3 text-link">{{ data.profile.urls.help.name }}</a>
                </div>
                <section v-if="data.releases.releases?.length" class="flex flex-col gap-3">
                    <h3 class="text-sm text-neutral-content">{{ data.releases.title }}</h3>
                    <Release v-for="release in data.releases.releases" :key="release.id" :release="release" @read="readRelease" />
                </section>
            </div>
        </template>
    </MobileSheet>
</template>

<script setup lang="ts">
import { computed, ref, watch } from 'vue'
import MobileSheet from './MobileSheet.vue'
import Notification from './Notification.vue'
import Release from './Release.vue'
import { useNavigationAlerts } from '../../composables/useNavigationAlerts'

const props = defineProps<{
    modelValue: boolean
    authenticated: boolean
    api?: string
    worldName: string
    worldUrl: string
    avatar?: string
    initials?: string
    texts: Record<string, string>
    loginLabel: string
    loginUrl: string
    registerUrl?: string
    backLabel: string
    closeLabel: string
}>()
const emit = defineEmits<{ 'update:modelValue': [value: boolean] }>()
const { hasUnread } = useNavigationAlerts()
const worldPlaceholder = 'https://th.kanka.io/c26cVXHRNnJXThmKZry4xpUuBS8=/100x96/smart/src/app/backgrounds/mountain-background-medium.jpg'
const data = ref<any>(null)
const loading = ref(false)
const error = ref(false)
const panel = ref('home')
const title = computed(() => !props.authenticated ? props.loginLabel : panel.value === 'worlds' ? props.texts.worlds : panel.value === 'notifications' ? data.value?.notifications.title : panel.value === 'more' ? props.texts.more : props.texts.title)
const worldGroups = computed(() => [
    { key: 'member', label: props.texts.your_worlds, worlds: data.value?.campaigns.member ?? [] },
    { key: 'following', label: props.texts.followed_worlds, worlds: data.value?.campaigns.following ?? [] },
].filter(group => group.worlds.length))

const load = async () => {
    if (!props.api || loading.value) return
    loading.value = true
    error.value = false
    try {
        const response = await fetch(props.api, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
        if (!response.ok) throw new Error('Navigation unavailable')
        data.value = await response.json()
        hasUnread.value = data.value.has_unread
    } catch {
        error.value = true
    } finally {
        loading.value = false
    }
}
const back = () => {
    if (panel.value === 'home') emit('update:modelValue', false)
    else panel.value = 'home'
}
const logout = () => (document.getElementById('logout-form') as HTMLFormElement)?.requestSubmit()
const updateUnread = () => {
    hasUnread.value = !!(data.value.notifications.messages?.length || data.value.releases.releases?.length)
}
const readNotification = (notification: any) => {
    data.value.notifications.messages = data.value.notifications.messages.filter((item: any) => item.id !== notification.id)
    updateUnread()
}
const readRelease = (release: any) => {
    data.value.releases.releases = data.value.releases.releases.filter((item: any) => item.id !== release.id)
    updateUnread()
}
watch(() => props.modelValue, (open) => {
    if (!open) return
    panel.value = 'home'
    if (props.authenticated) load()
})
</script>
