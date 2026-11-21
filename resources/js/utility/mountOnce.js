const apps = new WeakMap()

export function mountOnce(element, makeApp) {
    if (apps.has(element)) {
        return
    }

    const app = makeApp()
    apps.set(element, app)

    try {
        app.mount(element)
    } catch (error) {
        apps.delete(element)
        throw error
    }
}
