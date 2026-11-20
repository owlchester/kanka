<template>
    <Teleport to="body">
        <nav class="mobile-navigation fixed inset-x-0 bottom-0 z-830 flex items-center justify-evenly gap-1 border-t border-base-300 bg-base-100 px-3 pt-2 md:hidden" :aria-label="navigationLabel" @wheel.prevent>
            <button ref="exploreButton" type="button" class="sidebar-toggle flex min-h-12 min-w-0 flex-1 flex-col items-center justify-center gap-1 rounded-xl text-neutral-content hover:bg-base-200" :aria-expanded="sidebarOpen" @click="toggleSidebar">
                <span class="flex size-6 shrink-0 items-center justify-center" aria-hidden="true">
                    <i class="fa-regular fa-bars text-xl leading-none"></i>
                </span>
                <span class="whitespace-nowrap text-xs font-medium tracking-normal">{{ exploreLabel }}</span>
            </button>
            <button type="button" class="flex min-h-12 min-w-0 flex-1 flex-col items-center justify-center gap-1 rounded-xl text-neutral-content hover:bg-base-200" @click="search">
                <span class="flex size-6 shrink-0 items-center justify-center" aria-hidden="true">
                    <i class="fa-regular fa-magnifying-glass text-xl leading-none"></i>
                </span>
                <span class="whitespace-nowrap text-xs font-medium tracking-normal">{{ searchLabel }}</span>
            </button>
            <button v-if="quickCreateUrl" type="button" class="flex min-h-12 min-w-0 flex-1 flex-col items-center justify-center gap-1 rounded-xl text-neutral-content hover:bg-base-200" @click="quickCreate">
                <span class="flex size-6 shrink-0 items-center justify-center" aria-hidden="true">
                    <i class="fa-regular fa-bolt text-xl leading-none"></i>
                </span>
                <span class="whitespace-nowrap text-xs font-medium tracking-normal">{{ createLabel }}</span>
            </button>
            <button type="button" class="flex min-h-12 min-w-0 flex-1 flex-col items-center justify-center gap-1 rounded-xl text-neutral-content hover:bg-base-200" :aria-label="impersonation?.label ?? (authenticated ? accountTexts.title : loginLabel)" :aria-describedby="authenticated && !impersonation && hasUnread ? 'mobile-account-alert' : undefined" aria-haspopup="dialog" @click="account">
                <span class="relative flex size-6 shrink-0 items-center justify-center" aria-hidden="true">
                    <template v-if="authenticated">
                        <img v-if="avatar && !avatar.startsWith('/images/')" :src="avatar" alt="" class="size-5 rounded-full object-cover" />
                        <span v-else class="flex size-5 items-center justify-center rounded-full bg-base-200 text-xs font-semibold uppercase">{{ initials }}</span>
                        <span v-if="!impersonation && hasUnread" class="absolute -right-0.5 -top-0.5 size-2 rounded-full bg-boost"></span>
                    </template>
                    <i v-else class="fa-regular fa-user text-xl leading-none"></i>
                </span>
                <span v-if="impersonation" class="max-w-full truncate rounded bg-warning px-1 text-xs font-semibold text-warning-content">{{ impersonation.shortLabel }}</span>
                <span v-else class="whitespace-nowrap text-xs font-medium tracking-normal">{{ authenticated ? accountTexts.title : loginLabel }}</span>
                <span v-if="authenticated && !impersonation && hasUnread" id="mobile-account-alert" class="sr-only">{{ accountTexts.unread }}</span>
            </button>
        </nav>
    </Teleport>
    <MobileAccount v-model="accountOpen" :authenticated="authenticated" :api="accountApi" :world-name="worldName" :world-url="worldUrl" :avatar="avatar" :initials="initials" :texts="accountTexts" :login-label="loginLabel" :login-url="loginUrl" :register-url="registerUrl" :back-label="backLabel" :close-label="closeLabel" :impersonation="impersonation" />
</template>

<script setup lang="ts">
import { onBeforeUnmount, onMounted, ref } from 'vue'
import { useCommandCenter } from '../../composables/useCommandCenter'
import { useNavigationAlerts } from '../../composables/useNavigationAlerts'
import MobileAccount from './MobileAccount.vue'
import type { Impersonation } from './impersonation'

const props = defineProps<{
    navigationLabel: string
    exploreLabel: string
    searchLabel: string
    createLabel: string
    quickCreateUrl?: string
    authenticated: boolean
    accountApi?: string
    accountTexts: Record<string, string>
    worldName: string
    worldUrl: string
    avatar?: string
    initials?: string
    hasAlerts: boolean
    loginLabel: string
    loginUrl: string
    registerUrl?: string
    backLabel: string
    closeLabel: string
    impersonation?: Impersonation
}>()

const { open } = useCommandCenter()
const sidebarOpen = ref(false)
const accountOpen = ref(false)
const { hasUnread } = useNavigationAlerts()
const exploreButton = ref<HTMLButtonElement>()
let observer: MutationObserver | undefined

const toggleSidebar = () => document.body.classList.toggle('sidebar-open')
const search = () => {
    document.body.classList.remove('sidebar-open')
    open()
}
const account = () => {
    document.body.classList.remove('sidebar-open')
    accountOpen.value = true
}
const quickCreate = () => {
    document.body.classList.remove('sidebar-open')
    ;(window as any).openDialog('primary-dialog', props.quickCreateUrl)
}
const handleDrawerAction = (event: MouseEvent) => {
    const action = (event.target as Element).closest<HTMLElement>('[data-mobile-navigation]')?.dataset.mobileNavigation
    if (!action) return
    document.body.classList.remove('sidebar-open')
    exploreButton.value?.focus()
}

onMounted(() => {
    hasUnread.value = props.hasAlerts
    sidebarOpen.value = document.body.classList.contains('sidebar-open')
    observer = new MutationObserver(() => {
        sidebarOpen.value = document.body.classList.contains('sidebar-open')
    })
    observer.observe(document.body, { attributes: true, attributeFilter: ['class'] })
    document.addEventListener('click', handleDrawerAction)
})

onBeforeUnmount(() => {
    observer?.disconnect()
    document.removeEventListener('click', handleDrawerAction)
})
</script>
