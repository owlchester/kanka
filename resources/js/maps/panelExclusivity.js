const RIGHT_SLOT_KINDS = ['detail', 'marker', 'settings']

export function panelsToClose(openingKind, isMobile) {
    if (openingKind === 'legend') {
        return isMobile ? RIGHT_SLOT_KINDS : []
    }

    const closing = RIGHT_SLOT_KINDS.filter((kind) => kind !== openingKind)

    return isMobile ? [...closing, 'legend'] : closing
}
