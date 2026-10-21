import { test } from 'node:test';
import assert from 'node:assert/strict';
import { initEntryDate } from './entry-dates.js';

globalThis.Option = class {
    constructor(label, value) {
        this.label = label;
        this.value = value;
    }
};

const makeRow = (options, initial = {}) => {
    const fields = Object.fromEntries(['calendar', 'year', 'month', 'day'].map(key => [key, {
        value: initial[key] ?? '',
        options: [],
        addEventListener(event, callback) { this[event] = callback; },
        replaceChildren(...options) { this.options = options; },
        add(option) { this.options.push(option); },
    }]));
    initEntryDate({
        dataset: { calendars: JSON.stringify(options) },
        querySelector(selector) { return fields[selector.match(/data-date-(\w+)/)[1]]; },
    });
    return fields;
};

const calendars = {
    1: { months: ['Dawn', 'Sun', 'Dusk'], current: { year: 5530, month: 2, day: 17 } },
    2: { months: ['Winter', 'Summer'], current: { year: -42, month: 1, day: 4 } },
};

test('selecting a calendar defaults both birth and death rows to its current date', () => {
    for (const type of ['birth', 'death']) {
        const fields = makeRow(calendars);
        fields.calendar.value = '1';
        fields.calendar.change();
        assert.equal(fields.year.value, 5530, type);
        assert.equal(fields.month.value, 2, type);
        assert.equal(fields.day.value, 17, type);
        assert.deepEqual(fields.month.options.map(option => option.label), ['—', 'Dawn', 'Sun', 'Dusk']);
    }
});

test('initializing an existing date leaves its saved values untouched', () => {
    const fields = makeRow(calendars, { calendar: '1', year: '5488', month: '3', day: '12' });
    assert.equal(fields.year.value, '5488');
    assert.equal(fields.month.value, '3');
    assert.equal(fields.day.value, '12');
});

test('switching calendars uses the newly selected calendar and supports negative years', () => {
    const fields = makeRow(calendars, { calendar: '1', year: '5488', month: '3', day: '12' });
    fields.calendar.value = '2';
    fields.calendar.change();
    assert.equal(fields.year.value, -42);
    assert.equal(fields.month.value, 1);
    assert.equal(fields.day.value, 4);
});

test('clearing the calendar clears its date inputs', () => {
    const fields = makeRow(calendars, { calendar: '1', year: '5488', month: '3', day: '12' });
    fields.calendar.value = '';
    fields.calendar.change();
    assert.equal(fields.year.value, '');
    assert.equal(fields.month.value, '');
    assert.equal(fields.day.value, '');
});

test('a calendar with no current date leaves date inputs blank', () => {
    const fields = makeRow({ 1: { months: ['Dawn'], current: null } });
    fields.calendar.value = '1';
    fields.calendar.change();
    assert.equal(fields.year.value, '');
    assert.equal(fields.month.value, '');
    assert.equal(fields.day.value, '');
});
