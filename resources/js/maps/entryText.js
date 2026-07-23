const HTML_ENTITIES = {
    '&amp;': '&',
    '&lt;': '<',
    '&gt;': '>',
    '&quot;': '"',
    '&#039;': "'",
    '&#39;': "'",
}

function decodeHtmlEntities(text) {
    return text.replace(/&amp;|&lt;|&gt;|&quot;|&#0?39;/g, (match) => HTML_ENTITIES[match] ?? match)
}

/**
 * Convert entry HTML (server-purified Tiptap output) into a plain-text approximation:
 * paragraph boundaries become blank lines, <br> becomes a single newline, remaining tags
 * are stripped. Used for the collapsed description preview and hasContent check, not for
 * anything sent back to the server.
 */
export function htmlToPlainText(html) {
    if (!html) {
        return ''
    }

    const withBreaks = html
        .replace(/<br\s*\/?>/gi, '\n')
        .replace(/<\/p>\s*<p(?:\s[^>]*)?>/gi, '\n\n')
        .replace(/<\/?p(?:\s[^>]*)?>/gi, '')

    const stripped = withBreaks.replace(/<[^>]+>/g, '')

    return decodeHtmlEntities(stripped).trim()
}

/**
 * Collapse entry HTML into a single-line, whitespace-normalized snippet for a truncated
 * preview — the visual truncation itself is CSS line-clamp, not this.
 */
export function htmlToPreviewText(html) {
    return htmlToPlainText(html).replace(/\s+/g, ' ').trim()
}
