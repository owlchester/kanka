import test from 'node:test';
import assert from 'node:assert/strict';
import { initEntryDate } from './entry-dates.js';

class Select {
    constructor() {
        this.children = [];
        this.options = [];
        this._value = '';
    }

    add(option) {
        this.children.push(option);
        this.options.push(option);
    }

    append(group) {
        this.children.push(group);
        this.options.push(...group.children);
    }

    replaceChildren(...children) {
        this.children = children;
        this.options = children.flatMap(child => child.children || [child]);
        if (!this.options.some(option => option.value === this._value)) this._value = '';
    }

    set value(value) {
        this._value = this.options.some(option => option.value === value) ? value : '';
    }

    get value() {
        return this._value;
    }

    addEventListener(event, callback) {
        this.change = callback;
    }
}

test('switching to a calendar without the selected moon phase falls back to no recurrence', () => {
    globalThis.Option = class {
        constructor(text, value) { this.text = text; this.value = value; }
    };
    globalThis.document = {
        createElement: () => ({ children: [], append(option) { this.children.push(option); } }),
    };

    const controls = {
        '[data-date-calendar]': new Select(),
        '[data-date-year]': { value: '' },
        '[data-date-month]': new Select(),
        '[data-date-day]': { value: '' },
        '[data-date-recurrence]': new Select(),
    };
    const row = {
        dataset: { calendars: JSON.stringify({
            one: { recurrence: { '': 'None', 'moon-full': 'Full moon' } },
            two: { recurrence: { '': 'None', month: 'Monthly', Luna: { 'other-new': 'New moon' } } },
        }) },
        querySelector: selector => controls[selector],
    };

    initEntryDate(row);
    const recurrence = controls['[data-date-recurrence]'];
    recurrence.add(new Option('Full moon', 'moon-full'));
    recurrence.value = 'moon-full';
    controls['[data-date-calendar]']._value = 'two';
    controls['[data-date-calendar]'].change();

    assert.equal(recurrence.value, '');
    assert.ok(recurrence.options.some(option => option.value === 'other-new'));
});
