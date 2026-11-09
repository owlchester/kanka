export function toggleTableClass(classList, className, removeClasses = []) {
    const filtered = classList.filter(value => !removeClasses.includes(value))

    return classList.includes(className)
        ? filtered.filter(value => value !== className)
        : [...filtered, className]
}
