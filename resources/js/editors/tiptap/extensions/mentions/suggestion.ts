
import { computePosition, flip, shift } from '@floating-ui/dom'
import { posToDOMRect, VueRenderer } from '@tiptap/vue-3'
import MentionList from './MentionList.vue'

interface MentionItem {
    id?: string
    name: string
    image?: string
    link?: string
    mention?: string
    type?: string
    aliases?: any
    inject?: string
    value?: string
    section: 'entities' | 'posts' | 'new' | 'attributes'
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
                const items: MentionItem[] = []

                // Map entities
                if (data.entities?.length) {
                    data.entities.forEach((item: any) => {
                        items.push({
                            id: item.id,
                            name: item.name,
                            image: item.image,
                            link: item.link,
                            aliases: item.aliases,
                            mention: item.mention,
                            type: item.type,
                            section: 'entities',
                        })
                    })
                }

                // Map posts
                if (data.posts?.length) {
                    data.posts.forEach((item: any) => {
                        items.push({
                            id: item.id,
                            name: item.name,
                            inject: item.inject,
                            section: 'posts',
                        })
                    })
                }

                // Map attributes
                if (data.attributes?.length) {
                    data.attributes.forEach((item: any) => {
                        items.push({
                            id: item.id,
                            name: item.name,
                            value: item.value,
                            inject: item.inject,
                            section: 'attributes',
                        })
                    })
                }

                // Map new entity suggestions
                if (data.new?.length) {
                    data.new.forEach((item: any) => {
                        items.push({
                            name: item.name,
                            type: item.type,
                            inject: item.inject,
                            section: 'new',
                        })
                    })
                }

                return items
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
                                // Only for actual entities (not posts, new, or attributes)
                                if (onEntityAdded && item.section === 'entities') {
                                    onEntityAdded({
                                        id: parseInt(item.id),
                                        name: item.name,
                                        type: item.type,
                                        image: item.image,
                                        link: item.link,
                                        aliases: item.aliases,
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
                        // Only add to mentions for actual entities
                        if (onEntityAdded && item.section === 'entities') {
                            onEntityAdded({
                                id: parseInt(item.id),
                                name: item.name,
                                type: item.type,
                                image: item.image,
                                link: item.link,
                                aliases: item.aliases,
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
