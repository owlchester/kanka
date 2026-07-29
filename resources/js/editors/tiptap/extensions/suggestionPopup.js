const maximumHeight = 300

export function suggestionPopupDimensions(availableWidth, availableHeight) {
    return {
        maxWidth: Math.max(0, availableWidth),
        maxHeight: Math.max(0, Math.min(maximumHeight, availableHeight)),
    }
}
