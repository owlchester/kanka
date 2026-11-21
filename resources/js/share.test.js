import test from 'node:test'
import assert from 'node:assert/strict'
import { readFileSync } from 'node:fs'
import { runInNewContext } from 'node:vm'
import { mountOnce } from './utility/mountOnce.js'

const source = readFileSync(new URL('./share.js', import.meta.url), 'utf8').replace(/^import .*;\n/gm, '')

test('share dialogs mount once per fragment and preserve typed visibility props', () => {
    const EntityShareModal = {}
    const CampaignShareModal = {}
    const elements = new Map()
    const mounts = []
    let onDialogLoaded

    runInNewContext(source, {
        EntityShareModal,
        CampaignShareModal,
        mountOnce,
        createApp: (component, props) => ({
            mount: element => mounts.push({ component, props, element }),
        }),
        document: {
            getElementById: id => elements.get(id),
            addEventListener: (event, callback) => {
                assert.equal(event, 'dialog.loaded')
                onDialogLoaded = callback
            },
        },
    })

    const entity = { dataset: {
        initialCampaignVisibility: 'unlisted',
        initialEntityPrivate: '0',
        canChangeVisibility: '0',
        trans: JSON.stringify({ title: `Share "Ada's" page` }),
    } }
    elements.set('entity-share-container', entity)
    onDialogLoaded()
    onDialogLoaded()

    assert.equal(mounts.length, 1)
    assert.equal(mounts[0].component, EntityShareModal)
    assert.equal(mounts[0].element, entity)
    assert.equal(mounts[0].props.initialEntityPrivate, false)
    assert.equal(mounts[0].props.canChangeVisibility, false)
    assert.equal(mounts[0].props.trans.title, `Share "Ada's" page`)

    const nextEntity = { dataset: { ...entity.dataset, initialEntityPrivate: '1' } }
    elements.set('entity-share-container', nextEntity)
    elements.set('campaign-share-container', { dataset: {
        initialVisibility: 'private',
        canChangeVisibility: '1',
        trans: '{}',
    } })
    onDialogLoaded()
    onDialogLoaded()

    assert.equal(mounts.length, 3)
    assert.equal(mounts[1].element, nextEntity)
    assert.equal(mounts[1].props.initialEntityPrivate, true)
    assert.equal(mounts[2].component, CampaignShareModal)
    assert.equal(mounts[2].props.initialVisibility, 'private')
    assert.equal(mounts[2].props.canChangeVisibility, true)
})
