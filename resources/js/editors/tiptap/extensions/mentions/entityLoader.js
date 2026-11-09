export function createMentionEntityLoader({ getEditor, getEntities, addEntity, fetchEntities }) {
    const pending = new Set()
    const unavailable = new Set()
    let destroyed = false

    const hydrate = () => {
        const editor = getEditor()
        if (destroyed || !editor || editor.isDestroyed) {
            return
        }

        const entities = new Map(getEntities().map(entity => [String(entity.id), entity]))
        const tr = editor.state.tr
        editor.state.doc.descendants((node, pos) => {
            if (node.type.name !== 'mention') {
                return
            }

            const entity = entities.get(String(node.attrs.id))
            if (!entity || node.attrs.entity === entity) {
                return
            }

            const aliasId = node.attrs.config?.match(/(?:^|\|)alias:(\d+)(?:\||$)/)?.[1]
            const alias = entity.aliases?.find(alias => String(alias.id) === aliasId)
            const name = alias?.name || entity.name
            tr.setNodeMarkup(pos, undefined, {
                ...node.attrs,
                name,
                entity,
                image: entity.image || null,
                imageAlt: entity.image_alt || name,
                url: entity.url || null,
            })
        })

        if (tr.docChanged) {
            // Loading display metadata must not add an extra undo step.
            editor.view.dispatch(tr.setMeta('addToHistory', false))
        }
    }

    return {
        async load() {
            const editor = getEditor()
            if (destroyed || !editor || editor.isDestroyed) {
                return
            }

            const known = new Set(getEntities().map(entity => Number(entity.id)))
            const ids = new Set()
            editor.state.doc.descendants(node => {
                if (node.type.name === 'mention') {
                    const id = Number(node.attrs.id)
                    if (Number.isSafeInteger(id) && id > 0 && !known.has(id) && !pending.has(id) && !unavailable.has(id)) {
                        ids.add(id)
                    }
                }
            })

            ids.forEach(id => pending.add(id))
            hydrate()
            if (!ids.size) {
                return
            }

            try {
                const entities = await fetchEntities([...ids])
                if (destroyed) {
                    return
                }
                entities.forEach(addEntity)
                // Inaccessible/deleted entities should not be requested on every keystroke.
                const loaded = new Set(entities.map(entity => Number(entity.id)))
                ids.forEach(id => {
                    if (!loaded.has(id)) {
                        unavailable.add(id)
                    }
                })
                hydrate()
            } catch {
                // Keep the mention intact; a subsequent edit can retry a failed request.
            } finally {
                ids.forEach(id => pending.delete(id))
            }
        },
        destroy() {
            destroyed = true
        },
    }
}
