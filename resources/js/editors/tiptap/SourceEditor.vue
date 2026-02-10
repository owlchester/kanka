<script setup lang="ts">
import { ref, onMounted, onBeforeUnmount, watch } from 'vue'
import { EditorView, basicSetup } from 'codemirror'
import { html } from '@codemirror/lang-html'
import { oneDark } from '@codemirror/theme-one-dark'
import { EditorState } from '@codemirror/state'
import { indentWithTab } from '@codemirror/commands'
import { keymap } from '@codemirror/view'

const props = defineProps<{
    modelValue: string
}>()

const emit = defineEmits<{
    'update:modelValue': [value: string]
    'exit': []
}>()

const editorContainer = ref<HTMLElement | null>(null)
let editorView: EditorView | null = null

const isDarkMode = () => {
    return document.documentElement.getAttribute('data-theme')?.includes('dark') ||
           window.matchMedia('(prefers-color-scheme: dark)').matches
}

// Convert mention spans back to bracket notation
const convertMentionsToText = (html: string): string => {
    const parser = new DOMParser()
    const doc = parser.parseFromString(html, 'text/html')

    // Find all mention elements
    const mentions = doc.querySelectorAll('a[data-type="mention"]')

    mentions.forEach(mention => {
        const dataMention = mention.getAttribute('data-mention')
        if (dataMention) {
            // Replace the element with the text representation
            const textNode = doc.createTextNode(dataMention)
            mention.parentNode?.replaceChild(textNode, mention)
        }
    })

    return doc.body.innerHTML
}

// Simple HTML formatter
const formatHtml = (html: string): string => {
    const tab = '    '
    let result = ''
    let indent = 0

    // Self-closing and inline tags that shouldn't add newlines
    const inlineTags = ['a', 'span', 'strong', 'em', 'b', 'i', 'u', 's', 'mark', 'small', 'sub', 'sup', 'code', 'br', 'img']
    const selfClosingTags = ['br', 'hr', 'img', 'input', 'meta', 'link', 'area', 'base', 'col', 'embed', 'param', 'source', 'track', 'wbr']

    // Normalize whitespace first
    html = html.replace(/>\s+</g, '><').trim()

    // Split into tokens (tags and text)
    const tokens = html.split(/(<[^>]+>)/g).filter(t => t.trim())

    for (const token of tokens) {
        if (token.startsWith('</')) {
            // Closing tag
            indent = Math.max(0, indent - 1)
            const tagName = token.match(/<\/([a-zA-Z0-9]+)/)?.[1]?.toLowerCase()
            if (tagName && !inlineTags.includes(tagName)) {
                result += '\n' + tab.repeat(indent)
            }
            result += token
        } else if (token.startsWith('<')) {
            // Opening or self-closing tag
            const tagName = token.match(/<([a-zA-Z0-9]+)/)?.[1]?.toLowerCase()
            const isSelfClosing = selfClosingTags.includes(tagName || '') || token.endsWith('/>')

            if (tagName && !inlineTags.includes(tagName)) {
                if (result) {
                    result += '\n' + tab.repeat(indent)
                }
            }
            result += token

            if (!isSelfClosing && tagName && !inlineTags.includes(tagName)) {
                indent++
            }
        } else {
            // Text content
            result += token
        }
    }

    return result.trim()
}

onMounted(() => {
    if (!editorContainer.value) return

    // Convert mentions to text notation and format
    const withMentionsAsText = convertMentionsToText(props.modelValue)
    const formattedHtml = formatHtml(withMentionsAsText)

    const extensions = [
        basicSetup,
        html(),
        keymap.of([indentWithTab]),
        EditorView.updateListener.of((update) => {
            if (update.docChanged) {
                emit('update:modelValue', update.state.doc.toString())
            }
        }),
        EditorView.lineWrapping,
    ]

    if (isDarkMode()) {
        extensions.push(oneDark)
    }

    const state = EditorState.create({
        doc: formattedHtml,
        extensions,
    })

    editorView = new EditorView({
        state,
        parent: editorContainer.value,
    })

    // Emit the formatted HTML so it syncs
    emit('update:modelValue', formattedHtml)
})

watch(() => props.modelValue, (newValue) => {
    if (editorView && newValue !== editorView.state.doc.toString()) {
        editorView.dispatch({
            changes: {
                from: 0,
                to: editorView.state.doc.length,
                insert: newValue,
            },
        })
    }
})

onBeforeUnmount(() => {
    editorView?.destroy()
})

const exitSourceMode = () => {
    emit('exit')
}
</script>

<template>
    <div class="source-editor">
        <div class="source-editor-toolbar">
            <span class="text-xs text-neutral-content">Source Mode</span>
            <button
                type="button"
                @click="exitSourceMode"
                class="btn btn-xs btn-ghost"
                title="Exit source mode"
            >
                <i class="fa-regular fa-eye" aria-hidden="true" />
                Visual Editor
            </button>
        </div>
        <div ref="editorContainer" class="source-editor-content" />
    </div>
</template>

<style scoped>
.source-editor {
    border: 1px solid hsl(var(--bc)/.1);
    border-radius: var(--rounded-btn);
    overflow: hidden;
}

.source-editor-toolbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.5rem 0.75rem;
    background: hsl(var(--b2));
    border-bottom: 1px solid hsl(var(--bc)/.1);
}

.source-editor-content {
    min-height: 200px;
    max-height: 70vh;
    overflow-y: auto;
}

.source-editor-content :deep(.cm-editor) {
    height: 100%;
    min-height: 200px;
    max-height: calc(70vh - 40px);
    font-size: 0.875rem;
}

.source-editor-content :deep(.cm-scroller) {
    overflow: auto;
}

.source-editor-content :deep(.cm-content) {
    padding: 0.5rem;
}

.source-editor-content :deep(.cm-focused) {
    outline: none;
}
</style>
