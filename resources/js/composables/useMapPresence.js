import { onBeforeUnmount, ref, watch } from 'vue'
import Echo from 'laravel-echo'
import Pusher from 'pusher-js'

// laravel-echo's reverb broadcaster routes through the same Pusher-protocol
// connector as the 'pusher' broadcaster, which requires a Pusher client to be
// globally available (or passed via options.client) — it is never bundled
// automatically, so it must be set here explicitly.
window.Pusher = Pusher

const CURSOR_EVENT = 'cursor'

export function colourForUser(userId) {
    const hue = (Number(userId) * 137.508) % 360

    return `hsl(${hue}, 70%, 50%)`
}

export function useMapPresence(getInteractive, getI18n, { canEdit, onMapUpdated, onContentsChanged, onMarkerChanged, onTilingChanged } = {}) {
    const activeUsers = ref([])
    const remoteCursors = ref({})
    const error = ref(null)

    let echo = null
    let channel = null
    let connectedChannelName = null
    let adminChannelName = null

    function connect(interactive) {
        if (!interactive || channel) {
            return
        }

        const i18n = getI18n() || {}

        echo = new Echo({
            broadcaster: 'reverb',
            key: interactive.key,
            wsHost: interactive.host,
            wsPort: interactive.port,
            wssPort: interactive.port,
            forceTLS: interactive.scheme === 'https',
            enabledTransports: ['ws', 'wss'],
        })

        echo.connector.pusher.connection.bind('unavailable', () => {
            error.value = i18n.error_unavailable
        })

        echo.connector.pusher.connection.bind('error', () => {
            error.value = i18n.error_connecting
        })

        channel = echo.join(interactive.channel)
        connectedChannelName = interactive.channel

        channel.here((users) => {
            activeUsers.value = users
        })

        channel.joining((user) => {
            activeUsers.value = [...activeUsers.value, user]
        })

        channel.leaving((user) => {
            activeUsers.value = activeUsers.value.filter((u) => u.id !== user.id)

            const cursors = { ...remoteCursors.value }
            delete cursors[user.id]
            remoteCursors.value = cursors
        })

        channel.listenForWhisper(CURSOR_EVENT, (payload) => {
            remoteCursors.value = {
                ...remoteCursors.value,
                [payload.userId]: {
                    lat: payload.lat,
                    lng: payload.lng,
                    name: payload.name,
                    colour: colourForUser(payload.userId),
                },
            }
        })

        channel.listen('.MapUpdated', (payload) => {
            onMapUpdated?.(payload.map)
        })

        channel.listen('.MapTilingChanged', (payload) => {
            onTilingChanged?.(payload)
        })

        if (canEdit) {
            adminChannelName = interactive.channel + '.admin'
            const adminChannel = echo.private(adminChannelName)
            adminChannel.listen('.MapContentsChanged', (payload) => {
                onContentsChanged?.(payload)
            })
            adminChannel.listen('.MapMarkerChanged', (payload) => {
                onMarkerChanged?.(payload)
            })
        } else {
            channel.listen('.MapContentsChanged', (payload) => {
                onContentsChanged?.(payload)
            })
            channel.listen('.MapMarkerChanged', (payload) => {
                onMarkerChanged?.(payload)
            })
        }

        channel.error(() => {
            error.value = i18n.error_disconnected
        })
    }

    watch(getInteractive, (interactive) => connect(interactive), { immediate: true })

    function sendCursor(lat, lng) {
        const interactive = getInteractive()
        if (!channel || !interactive) {
            return
        }

        channel.whisper(CURSOR_EVENT, {
            userId: interactive.user.id,
            name: interactive.user.name,
            lat,
            lng,
        })
    }

    onBeforeUnmount(() => {
        if (echo && connectedChannelName) {
            echo.leave(connectedChannelName)
        }
        if (echo && adminChannelName) {
            echo.leave(adminChannelName)
        }
    })

    return { activeUsers, remoteCursors, error, sendCursor }
}
