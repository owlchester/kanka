import { ref } from 'vue'

const hasUnread = ref(false)

export function useNavigationAlerts() {
    return { hasUnread }
}
