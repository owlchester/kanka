const LONG_PRESS_DELAY = 500
const MOVE_THRESHOLD = 10

export function useLongPress(onLongPress: () => void) {
    let timer: ReturnType<typeof setTimeout> | null = null
    let startX = 0
    let startY = 0

    const start = (e: PointerEvent) => {
        if (e.pointerType === 'mouse') return
        startX = e.clientX
        startY = e.clientY
        timer = setTimeout(() => {
            timer = null
            onLongPress()
        }, LONG_PRESS_DELAY)
    }

    const cancel = () => {
        if (timer !== null) {
            clearTimeout(timer)
            timer = null
        }
    }

    const move = (e: PointerEvent) => {
        if (Math.abs(e.clientX - startX) > MOVE_THRESHOLD || Math.abs(e.clientY - startY) > MOVE_THRESHOLD) {
            cancel()
        }
    }

    return { start, cancel, move }
}
