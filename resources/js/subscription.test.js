import test from 'node:test';
import assert from 'node:assert/strict';
import { readFileSync } from 'node:fs';
import { runInNewContext } from 'node:vm';

const source = readFileSync(new URL('./subscription.js', import.meta.url), 'utf8');

function setup({ savedCard = true, confirmSetup = async () => ({}), couponValue = 'INVALID' } = {}) {
    const element = (extra = {}) => ({
        listeners: {},
        classList: {
            classes: new Set(),
            add(...names) { names.forEach(name => this.classes.add(name)); },
            remove(...names) { names.forEach(name => this.classes.delete(name)); },
            contains(name) { return this.classes.has(name); },
        },
        addEventListener(event, callback) { this.listeners[event] = callback; },
        ...extra,
    });
    let submissions = 0;
    let fetchCalls = 0;
    let resolveCoupon;
    const button = element({ disabled: false });
    const form = element({
        dataset: {},
        querySelector: () => button,
        submit: () => submissions++,
    });
    const coupon = element({ value: couponValue, dataset: { url: '/coupon' } });
    const card = { value: savedCard ? 'pm_saved' : '' };
    const pricingNow = element({ dataset: { originalPrice: '50.00' }, textContent: '50.00', innerHTML: '50.00' });
    const pricingButton = element({ dataset: { originalPrice: '50.00' }, textContent: '50.00' });
    const couponError = element();
    const couponSuccess = element();
    const ids = {
        'stripe-token': { value: 'pk_test' },
        'subscription-confirm': form,
        'subscribe-confirm': element(),
        'payment-element': element({ dataset: { returnUrl: 'https://example.test/payment-return' } }),
        'coupon-check': coupon,
        'coupon-success': couponSuccess,
        'coupon-invalid': couponError,
        'coupon': { value: '' },
        'coupon-validating': element(),
        'pricing-now': pricingNow,
        'pricing-button': pricingButton,
    };
    runInNewContext(source, {
        document: {
            getElementById: id => ids[id],
            querySelector: selector => ({
                '.subscription-confirm-button': button,
                '.alert-error': element(),
                'input[name="subscription-intent-token"]': { value: 'secret' },
                'input[name="payment_id"]': card,
            })[selector],
            querySelectorAll: () => [],
        },
        window: { onEvent: callback => callback() },
        Stripe: () => ({
            elements: () => ({ create: () => ({ mount() {} }) }),
            confirmSetup,
        }),
        fetch: () => {
            fetchCalls++;
            return new Promise(resolve => { resolveCoupon = resolve; });
        },
        URL,
    });

    return {
        button,
        form,
        coupon,
        couponError,
        couponSuccess,
        pricingNow,
        pricingButton,
        fetchCalls: () => fetchCalls,
        submitEvent: () => form.listeners.submit({ target: form, preventDefault() {} }),
        couponChange: () => coupon.listeners.change({ target: coupon }),
        resolveCoupon: valid => resolveCoupon({ json: async () => ({ valid, error: 'Invalid coupon', price: '10', coupon: 'VALID' }) }),
        submissions: () => submissions,
    };
}

test('a coupon response cannot re-enable a submitting checkout', async () => {
    for (const valid of [false, true]) {
        const state = setup();
        const pending = state.couponChange();
        state.submitEvent();
        assert.equal(state.button.disabled, true);
        state.resolveCoupon(valid);
        await pending;
        assert.equal(state.button.disabled, true);
        assert.equal(state.form.dataset.submitting, 'true');
    }
});

test('repeated submit events send a saved-card checkout only once', () => {
    const state = setup();
    state.submitEvent();
    state.submitEvent();
    assert.equal(state.submissions(), 1);
});

test('Stripe validation errors allow the user to retry', async () => {
    let confirmations = 0;
    const state = setup({ savedCard: false, confirmSetup: async () => {
        confirmations++;
        return { error: { message: 'Card declined' } };
    } });
    await state.submitEvent();
    assert.equal(state.button.disabled, false);
    assert.equal(state.form.dataset.submitting, undefined);
    await state.submitEvent();
    assert.equal(confirmations, 2);
});

test('a rejected Stripe confirmation also releases the submitting state', async () => {
    const state = setup({ savedCard: false, confirmSetup: async () => { throw new Error('Network error'); } });
    await state.submitEvent();
    assert.equal(state.button.disabled, false);
    assert.equal(state.form.dataset.submitting, undefined);
});

test('empty or whitespace coupon input skips fetch and hides errors', async () => {
    const state = setup({ couponValue: '   ' });
    await state.couponChange();
    assert.equal(state.fetchCalls(), 0);
    assert.equal(state.couponError.classList.contains('hidden'), true);
    assert.equal(state.couponSuccess.classList.contains('hidden'), true);
    assert.equal(state.pricingNow.textContent, '50.00');
    assert.equal(state.pricingButton.textContent, '50.00');
});

test('valid coupon updates both pricing-now and pricing-button, and invalid restores them', async () => {
    const state = setup({ couponValue: 'SAVE80' });
    const first = state.couponChange();
    state.resolveCoupon(true);
    await first;
    assert.equal(state.pricingNow.innerHTML, '10');
    assert.equal(state.pricingButton.textContent, '10');

    const second = state.couponChange();
    state.resolveCoupon(false);
    await second;
    assert.equal(state.pricingNow.textContent, '50.00');
    assert.equal(state.pricingButton.textContent, '50.00');
});
