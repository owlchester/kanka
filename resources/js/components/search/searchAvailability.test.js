import test from 'node:test';
import assert from 'node:assert/strict';
import { applySearchAvailability } from './searchAvailability.js';

test('an accepted full-text response can enable and disable maintenance without stale rest state', () => {
    const maintenance = applySearchAvailability(
        { available: null, message: '' },
        false,
        'Rebuilding index',
    );
    assert.deepEqual(maintenance, { available: false, message: 'Rebuilding index' });

    const available = applySearchAvailability(maintenance, true, '');
    assert.deepEqual(available, { available: true, message: '' });

    const laterMaintenance = applySearchAvailability(available, false, '', 'Rebuilding index');
    assert.deepEqual(laterMaintenance, { available: false, message: 'Rebuilding index' });
});

test('unknown status does not overwrite the latest accepted availability', () => {
    const current = { available: false, message: 'Rebuilding index' };

    assert.equal(applySearchAvailability(current, undefined, 'Unexpected error'), current);
    assert.equal(applySearchAvailability(current, null, ''), current);
});
