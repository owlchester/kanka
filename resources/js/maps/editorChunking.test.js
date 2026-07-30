import test from 'node:test'
import assert from 'node:assert/strict'
import { readFileSync } from 'node:fs'

const manifest = JSON.parse(
    readFileSync(new URL('../../../public/build/manifest.json', import.meta.url), 'utf8'),
)

function eagerDependencyKeys(entryKey) {
    const dependencies = new Set()
    const pending = [entryKey]

    while (pending.length) {
        const key = pending.pop()

        if (dependencies.has(key)) {
            continue
        }

        dependencies.add(key)
        pending.push(...(manifest[key]?.imports ?? []))
    }

    return dependencies
}

test('map explorer defers its marker editor and Tiptap bundles', () => {
    const explorerKey = 'resources/js/maps/explore.js'
    const markerPanelKey = 'resources/js/components/maps/MarkerPanel.vue'
    const explorer = manifest[explorerKey]
    const markerPanel = manifest[markerPanelKey]

    assert.ok(explorer)
    assert.ok(markerPanel)
    assert.ok(explorer.dynamicImports?.includes(markerPanelKey))

    const tiptapKey = markerPanel.dynamicImports?.find(
        (key) => manifest[key]?.file.includes('/Tiptap-'),
    )

    assert.ok(tiptapKey)

    const eagerFiles = [...eagerDependencyKeys(explorerKey)].map(
        (key) => manifest[key]?.file ?? key,
    )

    assert.equal(eagerFiles.some((file) => file.includes('/MarkerPanel-')), false)
    assert.equal(eagerFiles.some((file) => file.includes('/Tiptap-')), false)
})
