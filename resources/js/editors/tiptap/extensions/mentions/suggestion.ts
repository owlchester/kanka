
import { computePosition, flip, shift } from '@floating-ui/dom'
import { posToDOMRect, VueRenderer } from '@tiptap/vue-3'
import MentionList from './MentionList.vue'

interface MentionItem {
    id: string
    name: string
    image: string
    link: string
    mention: string
    preview: string
    type?: string
}

const updatePosition = (editor, element) => {
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

export default (mentionsUrl: string, onEntityAdded?: (entity: any) => void) => {
    let abortController: AbortController | null = null

    return {
        char: '@',

        items: async ({ query }: { query: string }): Promise<MentionItem[]> => {
            // Only query if we have at least 3 characters
            if (query.length < 3) {
                return []
            }

            // Cancel previous request if it exists
            if (abortController) {
                abortController.abort()
            }

            abortController = new AbortController()

            try {
                const url = new URL(mentionsUrl)
                url.searchParams.set('q', query)

                const response = await fetch(url.toString(), {
                    signal: abortController.signal,
                })

                if (!response.ok) {
                    return []
                }

                const data = await response.json()
                // Map API response to what MentionList expects
                return (data.entities || []).map((item: any) => ({
                    id: item.id,
                    name: item.name,
                    image: item.image,
                    url: item.link,
                    mention: item.mention,
                    type: item.type,
                }))
            } catch (error: any) {
                // Ignore abort errors
                if (error.name === 'AbortError') {
                    return []
                }
                console.error('Error fetching mentions:', error)
                return []
            }
        },

        render: () => {
            let component

            return {
                onStart: (props: any) => {
                    component = new VueRenderer(MentionList, {
                        props: {
                            items: props.items,
                            command: (item: MentionItem) => {
                                // Add entity to the mentions array if callback provided
                                if (onEntityAdded) {
                                    onEntityAdded({
                                        id: parseInt(item.id),
                                        name: item.name,
                                        type: item.type,
                                        image: item.image,
                                        url: item.link,
                                    })
                                }

                                // Execute the original command
                                props.command(item)
                            },
                            loading: props.query && props.query.length >= 3,
                            query: props.query || '',
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
                    // Determine loading state: loading if query is >= 3 chars and items haven't loaded yet
                    const isLoading = props.query && props.query.length >= 3 && props.items.length === 0

                    // Update the command wrapper with the new command
                    const wrappedCommand = (item: MentionItem) => {
                        if (onEntityAdded) {
                            onEntityAdded({
                                id: parseInt(item.id),
                                name: item.name,
                                type: item.type,
                                image: item.image,
                                url: item.link,
                            })
                        }
                        props.command(item)
                    }

                    component.updateProps({
                        items: props.items,
                        command: wrappedCommand,
                        loading: isLoading,
                        query: props.query || '',
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
