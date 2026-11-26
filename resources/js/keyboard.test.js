import test from 'node:test';
import assert from 'node:assert/strict';
import { parseShortcut, matchesShortcut } from './keyboard.js';

const keyEvent = (overrides = {}) => ({
    key: '',
    ctrlKey: false,
    metaKey: false,
    altKey: false,
    shiftKey: false,
    ...overrides,
});

test('unmodified symbol shortcut matches across US, Apple Option, and AltGr layouts', () => {
    const desc = parseShortcut(']');

    assert.equal(matchesShortcut(keyEvent({ key: ']' }), desc), true);
    assert.equal(matchesShortcut(keyEvent({ key: ']', altKey: true }), desc), true);
    assert.equal(matchesShortcut(keyEvent({ key: ']', ctrlKey: true, altKey: true }), desc), true);
    assert.equal(matchesShortcut(keyEvent({ key: ']', shiftKey: true }), desc), true);
});

test('unmodified symbol shortcut does not match Cmd or Ctrl without AltGr', () => {
    const desc = parseShortcut(']');

    assert.equal(matchesShortcut(keyEvent({ key: ']', metaKey: true }), desc), false);
    assert.equal(matchesShortcut(keyEvent({ key: ']', ctrlKey: true }), desc), false);
});

test('letter shortcut still requires no modifiers', () => {
    const desc = parseShortcut('k');

    assert.equal(matchesShortcut(keyEvent({ key: 'k' }), desc), true);
    assert.equal(matchesShortcut(keyEvent({ key: 'K' }), desc), true);
    assert.equal(matchesShortcut(keyEvent({ key: 'k', altKey: true }), desc), false);
    assert.equal(matchesShortcut(keyEvent({ key: 'k', shiftKey: true }), desc), false);
    assert.equal(matchesShortcut(keyEvent({ key: 'k', metaKey: true }), desc), false);
});

test('explicit modifier shortcuts still match only exact modifiers', () => {
    const desc = parseShortcut('ctrl+shift+s');

    assert.equal(matchesShortcut(keyEvent({ key: 'S', ctrlKey: true, shiftKey: true }), desc), true);
    assert.equal(matchesShortcut(keyEvent({ key: 'S', metaKey: true, shiftKey: true }), desc), true);
    assert.equal(matchesShortcut(keyEvent({ key: 's', ctrlKey: true }), desc), false);
    assert.equal(matchesShortcut(keyEvent({ key: 's', ctrlKey: true, shiftKey: true, altKey: true }), desc), false);
});
