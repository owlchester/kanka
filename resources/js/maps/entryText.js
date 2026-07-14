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
 * Convert entry HTML (server-purified, currently just <p>/<br> from the simple textarea
 * editor) back into editable plain text: paragraph boundaries become blank lines, <br>
 * becomes a single newline, remaining tags are stripped. Safe/idempotent on plain text
 * (no tags match), which matters because after a local unsaved edit `pin.entry` holds
 * plain text rather than HTML until the whole marker panel is saved.
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
