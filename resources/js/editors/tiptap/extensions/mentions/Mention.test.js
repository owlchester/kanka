import test from 'node:test'
import assert from 'node:assert/strict'
import { getSchema } from '@tiptap/core'
import StarterKit from '@tiptap/starter-kit'
import { Mention } from './Mention.ts'

const entity = {
    id: 123,
    name: 'Character',
    image: 'https://example.com/avatar.png',
    image_alt: 'Portrait',
    url: '/characters/123',
}
const schema = getSchema([
    StarterKit,
    Mention.configure({ resolveEntity: id => id === '123' ? entity : null }),
])
const mention = schema.nodes.mention

function roundTrip(attrs, tag = 'a[data-mention]') {
    const node = mention.create(attrs)
    const [element, htmlAttrs] = mention.spec.toDOM(node)
    const rule = mention.spec.parseDOM.find(rule => rule.tag === tag)
    assert.ok(rule, `Missing parse rule for ${tag}`)
    const parsedAttrs = rule.getAttrs({ getAttribute: name => htmlAttrs[name] ?? null })

    return { element, htmlAttrs, node: mention.create(parsedAttrs) }
}

test('mention HTML round trip preserves identity, custom label and config', () => {
    const result = roundTrip({
        id: '123',
        mention: 'character:123',
        name: 'Alias name',
        label: 'Custom label',
        config: 'alias:456|page:inventory',
        entity,
    })

    assert.equal(result.element, 'a')
    assert.equal(result.node.attrs.id, '123')
    assert.equal(result.node.attrs.mention, 'character:123')
    assert.equal(result.node.attrs.name, 'Alias name')
    assert.equal(result.node.attrs.label, 'Custom label')
    assert.equal(result.node.attrs.config, 'alias:456|page:inventory')
    assert.equal(result.node.attrs.entity, entity)
    assert.equal(result.node.attrs.image, entity.image)
    assert.equal(result.node.attrs.imageAlt, entity.image_alt)
    assert.equal(result.node.attrs.url, entity.url)
})

test('legacy span mentions remain supported', () => {
    const { node } = roundTrip({ id: '123', mention: 'character:123' }, 'span[data-mention]')

    assert.equal(node.attrs.mention, 'character:123')
    assert.equal(node.attrs.entity, entity)
})

test('unknown mentions preserve their identity without trusting clipboard entity data', () => {
    const { node } = roundTrip({ id: '999', mention: 'location:999', name: 'Unknown location' })

    assert.equal(node.attrs.mention, 'location:999')
    assert.equal(node.attrs.name, 'Unknown location')
    assert.equal(node.attrs.entity, null)
})
