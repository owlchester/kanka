export const t = (key, fallback) => {
    const translations = globalThis.window?.tiptapTranslations
    if (translations && typeof translations[key] === 'string' && translations[key].length > 0) {
        return translations[key]
    }
    return fallback
}
