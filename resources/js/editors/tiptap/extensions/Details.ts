import { Node, mergeAttributes } from '@tiptap/core'
import { VueNodeViewRenderer } from '@tiptap/vue-3'
import DetailsWrapper from './DetailsWrapper.vue'

export const Details = Node.create({
    name: 'details',
    group: 'block',
    content: 'detailsSummary block+',
    defining: true,

    addAttributes() {
        return {
            open: {
                default: null,
                parseHTML: element => element.hasAttribute('open'),
                renderHTML: attributes => {
                    if (!attributes.open) {
                        return {}
                    }
                    return { open: '' }
                },
            },
            class: {
                default: null,
                parseHTML: element => element.getAttribute('class'),
                renderHTML: attributes => {
                    if (!attributes.class) {
                        return {}
                    }
                    return { class: attributes.class }
                },
            },
            style: {
                default: null,
                parseHTML: element => element.getAttribute('style'),
                renderHTML: attributes => {
                    if (!attributes.style) {
                        return {}
                    }
                    return { style: attributes.style }
                },
            },
        }
    },

    parseHTML() {
        return [{ tag: 'details' }]
    },

    renderHTML({ HTMLAttributes }) {
        return ['details', mergeAttributes(HTMLAttributes), 0]
    },

    addNodeView() {
        return VueNodeViewRenderer(DetailsWrapper)
    },
})

export const DetailsSummary = Node.create({
    name: 'detailsSummary',
    group: 'block',
    content: 'inline*',
    defining: true,

    addAttributes() {
        return {
            class: {
                default: null,
                parseHTML: element => element.getAttribute('class'),
                renderHTML: attributes => {
                    if (!attributes.class) {
                        return {}
                    }
                    return { class: attributes.class }
                },
            },
            style: {
                default: null,
                parseHTML: element => element.getAttribute('style'),
                renderHTML: attributes => {
                    if (!attributes.style) {
                        return {}
                    }
                    return { style: attributes.style }
                },
            },
        }
    },

    parseHTML() {
        return [{ tag: 'summary' }]
    },

    renderHTML({ HTMLAttributes }) {
        return ['summary', mergeAttributes(HTMLAttributes), 0]
    },
})
