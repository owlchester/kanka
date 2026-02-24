export const buttonClass = (active: boolean): string => {
    const base = 'px-2 py-1 rounded-lg hover:bg-base-200 block hover:text-base-content '
    const state = active ? 'bg-base-300 border-primary text-base-content' : 'text-neutral-content '
    return base + ' ' + state
}
