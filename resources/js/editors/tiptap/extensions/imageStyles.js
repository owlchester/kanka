const FLOAT_CLASSES = ['note-float-left', 'note-float-right', 'float-left', 'float-right']

export const filterImageClasses = (element) => {
    const classes = element.getAttribute('class') || ''
    const filtered = classes
        .split(/\s+/)
        .filter(c => c && !FLOAT_CLASSES.includes(c))
        .join(' ')
        .trim()
    return filtered || null
}

export const parsePixelDimension = (element, prop) => {
    const style = element.getAttribute('style') || ''
    const match = style.match(new RegExp(`(?:^|;)\\s*${prop}:\\s*(\\d+(?:\\.\\d+)?)px`, 'i'))
    if (match) return parseFloat(match[1])

    const attr = element.getAttribute(prop)
    if (attr && /^\d+(?:\.\d+)?$/.test(attr.trim())) {
        return parseFloat(attr)
    }

    return null
}

export const parsePercentWidth = (element) => {
    const style = element.getAttribute('style') || ''
    const match = style.match(/(?:^|;)\s*width:\s*(\d+(?:\.\d+)?%)/i)
    return match ? match[1] : null
}

export const parseFloatStyle = (element) => {
    const style = element.getAttribute('style') || ''
    const match = style.match(/(?:^|;)\s*float:\s*(left|right)/i)
    if (match) return match[1].toLowerCase()

    const classes = (element.getAttribute('class') || '').split(/\s+/)
    if (classes.includes('note-float-left') || classes.includes('float-left')) return 'left'
    if (classes.includes('note-float-right') || classes.includes('float-right')) return 'right'

    return null
}

export const buildImageStyle = ({ width, height, widthStyle, floatStyle }) => {
    const styleParts = []

    if (widthStyle) {
        styleParts.push(`width: ${widthStyle}`)
    } else if (width != null) {
        styleParts.push(`width: ${typeof width === 'number' ? `${width}px` : width}`)
    }

    if (!widthStyle && height != null) {
        styleParts.push(`height: ${typeof height === 'number' ? `${height}px` : height}`)
    }

    if (floatStyle) {
        styleParts.push(`float: ${floatStyle}`)
        if (floatStyle === 'left') styleParts.push('margin-right: 0.5rem')
        if (floatStyle === 'right') styleParts.push('margin-left: 0.5rem')
    }

    return styleParts.length > 0 ? styleParts.join('; ') : null
}

export const applyImageNodeViewStyles = (attrs, el, container) => {
    const { width, height, widthStyle, floatStyle, alt, title } = attrs

    if (alt) {
        el.setAttribute('alt', alt)
    } else {
        el.removeAttribute('alt')
    }

    if (title) {
        el.setAttribute('title', title)
    } else {
        el.removeAttribute('title')
    }

    if (widthStyle) {
        container.style.width = widthStyle
        el.style.width = '100%'
        el.style.height = 'auto'
    } else if (width != null) {
        container.style.width = ''
        el.style.width = typeof width === 'number' ? `${width}px` : width
        el.style.height = height != null ? (typeof height === 'number' ? `${height}px` : height) : 'auto'
    } else if (height != null) {
        container.style.width = ''
        el.style.width = ''
        el.style.height = typeof height === 'number' ? `${height}px` : height
    } else {
        container.style.width = ''
        el.style.width = ''
        el.style.height = ''
    }

    container.style.float = floatStyle || ''
    container.style.marginRight = floatStyle === 'left' ? '0.5rem' : ''
    container.style.marginLeft = floatStyle === 'right' ? '0.5rem' : ''
}
