
import { computePosition, flip, shift } from '@floating-ui/dom'
import { posToDOMRect, VueRenderer } from '@tiptap/vue-3'
import SlashCommandList from './SlashCommandList.vue'
import type { Editor } from '@tiptap/core'

export interface SlashCommandItem {
    title: string
    description: string
    icon: string
    searchTerms?: string[]
    command: (editor: Editor) => void
}

const updatePosition = (editor: Editor, element: HTMLElement) => {
    const virtualElement = {
        getBoundingClientRect: () => posToDOMRect(editor.view, editor.state.selection.from, editor.state.selection.to),
    }

    computePosition(virtualElement, element, {
        placement: 'bottom-start',
        strategy: 'absolute',
        middleware: [shift(), flip()],
    }).then(({ x, y, strategy }) => {
        element.style.width = 'max-content'
        element.style.position = strategy
        element.style.left = `${x}px`
        element.style.top = `${y}px`
    })
}

const tableHTML = `
  <table class="table table-striped table-bordered" style="width: 200px;">
    <thead>
        <tr>
            <th>a</th>
            <th>b</th>
        </tr>
    </thead>
    <tbody>
        <tr>
          <td>1</td>
          <td>2</td>
        </tr>
        <tr>
          <td>3</td>
          <td>4</td>
        </tr>
    </tbody>
  </table>`

const commands: SlashCommandItem[] = [
    {
        title: 'Source',
        description: 'Edit raw HTML source',
        icon: 'fa-regular fa-code',
        command: (editor: Editor) => {
            window.dispatchEvent(new CustomEvent('tiptap:source-mode'))
        },
    },
    {
        title: 'Gallery',
        description: 'Insert an image from gallery',
        icon: 'fa-regular fa-images',
        searchTerms: ['image', 'photo', 'picture', 'media'],
        command: (editor: Editor) => {
            editor.commands.openGallery()
        },
    },
    {
        title: 'Insert Media',
        description: 'Upload an image from your device',
        icon: 'fa-regular fa-upload',
        searchTerms: ['image', 'photo', 'picture', 'media', 'upload', 'file'],
        command: (editor: Editor) => {
            editor.commands.uploadMedia()
        },
    },
    {
        title: 'Table',
        description: 'Insert a table',
        icon: 'fa-regular fa-table',
        command: (editor: Editor) => {
            editor
                .chain()
                .focus()
                .insertContent(tableHTML, { parseOptions: { preserveWhitespace: true } })
                .run()
        },
    },
    {
        title: 'Heading 1',
        description: 'Huge heading',
        icon: 'fa-regular fa-heading',
        command: (editor: Editor) => {
            editor.chain().focus().toggleHeading({ level: 1 }).run()
        },
    },
    {
        title: 'Heading 2',
        description: 'Large heading',
        icon: 'fa-regular fa-heading',
        command: (editor: Editor) => {
            editor.chain().focus().toggleHeading({ level: 2 }).run()
        },
    },
    {
        title: 'Heading 3',
        description: 'Medium heading',
        icon: 'fa-regular fa-heading',
        command: (editor: Editor) => {
            editor.chain().focus().toggleHeading({ level: 3 }).run()
        },
    },
    {
        title: 'Bullet List',
        description: 'Create a bullet list',
        icon: 'fa-regular fa-list-ul',
        command: (editor: Editor) => {
            editor.chain().focus().toggleBulletList().run()
        },
    },
    {
        title: 'Numbered List',
        description: 'Create a numbered list',
        icon: 'fa-regular fa-list-ol',
        command: (editor: Editor) => {
            editor.chain().focus().toggleOrderedList().run()
        },
    },
    {
        title: 'Task List',
        description: 'Create a checklist',
        icon: 'fa-regular fa-square-check',
        searchTerms: ['checkbox', 'checklist', 'todo', 'task'],
        command: (editor: Editor) => {
            editor.chain().focus().toggleTaskList().run()
        },
    },
    {
        title: 'Quote',
        description: 'Insert a quote block',
        icon: 'fa-regular fa-quote-right',
        command: (editor: Editor) => {
            editor.chain().focus().toggleBlockquote().run()
        },
    },
    {
        title: 'Code Block',
        description: 'Insert a code block',
        icon: 'fa-regular fa-code',
        command: (editor: Editor) => {
            editor.chain().focus().toggleCodeBlock().run()
        },
    },
    {
        title: 'Horizontal Rule',
        description: 'Insert a divider',
        icon: 'fa-regular fa-minus',
        command: (editor: Editor) => {
            editor.chain().focus().setHorizontalRule().run()
        },
    },
]

export default () => {
    return {
        items: ({ query }: { query: string }): SlashCommandItem[] => {
            const q = query.toLowerCase()
            return commands.filter(item =>
                item.title.toLowerCase().includes(q)
                || item.searchTerms?.some(term => term.includes(q))
            )
        },

        render: () => {
            let component: VueRenderer

            return {
                onStart: (props: any) => {
                    component = new VueRenderer(SlashCommandList, {
                        props: {
                            items: props.items,
                            command: props.command,
                        },
                        editor: props.editor,
                    })

                    if (!props.clientRect) {
                        return
                    }

                    component.element.style.position = 'absolute'
                    document.body.appendChild(component.element)
                    updatePosition(props.editor, component.element)
                },

                onUpdate(props: any) {
                    component.updateProps({
                        items: props.items,
                        command: props.command,
                    })

                    if (!props.clientRect) {
                        return
                    }

                    updatePosition(props.editor, component.element)
                },

                onKeyDown(props: any) {
                    if (props.event.key === 'Escape') {
                        component.destroy()
                        return true
                    }

                    return component.ref?.onKeyDown(props)
                },

                onExit() {
                    component.destroy()
                },
            }
        },
    }
}
