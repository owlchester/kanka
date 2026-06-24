// Strip variables for the page
let stripe, elements, card;

// Form status
let formSubmitBtn;

// Coupon stuff
let couponField, couponSuccess, couponError, couponId, couponValidating, cancelField;

const subscribeModal = document.getElementById('subscribe-confirm');

const init = () => {
    initStripe();
    initPeriodToggle();
    initAnalytics();
    window.onEvent(function() {
        initConfirmListener();
    });
};

// Initialize the stripe API
const initStripe = () => {
    const token = document.getElementById('stripe-token');
    if (!token) return;
    stripe = Stripe(token.value);
    // Elements are initialised in initConfirmListener once we have the client secret
};

// When the modal is opened and loaded, inject stripe if needed and the form validator
const initConfirmListener = () => {
    formSubmitBtn = document.querySelector('.subscription-confirm-button');

    const intentInput = document.querySelector('input[name="subscription-intent-token"]');
    const paymentElementContainer = document.getElementById('payment-element');

    if (paymentElementContainer && intentInput && !elements) {
        // Initialise PaymentElement with the SetupIntent client secret
        elements = stripe.elements({ clientSecret: intentInput.value });
        const paymentElement = elements.create('payment');
        paymentElement.mount('#payment-element');
    }

    document.getElementById('subscription-confirm')?.addEventListener('submit', subscribe);

    couponField = document.getElementById('coupon-check');
    if (couponField) {
        couponSuccess = document.getElementById('coupon-success');
        couponError = document.getElementById('coupon-invalid');
        couponId = document.getElementById('coupon');
        couponValidating = document.getElementById('coupon-validating');
        couponField.addEventListener('change', checkCoupon);
        couponField.addEventListener('focusout', checkCoupon);
    }
};

const checkCoupon = (event) => {
    const element = event.target;
    const coupon = element.value;
    const url = element.dataset.url;

    if (!coupon) {
        formSubmitBtn.classList.remove('btn-disabled', 'loading');
        formSubmitBtn.disabled = false;
    }
    couponValidating.classList.remove('hidden');
    fetch(url + '?coupon=' + coupon)
        .then((response) => response.json())
        .then((result) => {
            formSubmitBtn.classList.remove('btn-disabled', 'loading');
            formSubmitBtn.disabled = false;
            couponValidating.classList.add('hidden');

            if (!result.valid) {
                couponSuccess.classList.add('hidden');
                couponError.innerHTML = result.error;
                couponError.classList.remove('hidden');
                couponId.value = '';
                subscribeModal.classList.remove('valid-coupon');
                return;
            }

            document.getElementById('pricing-now').innerHTML = result.price;
            couponError.classList.add('hidden');
            couponSuccess.innerHTML = result.discount;
            couponSuccess.classList.remove('hidden');
            couponId.value = result.coupon;
            subscribeModal.classList.add('valid-coupon');
        }).catch((result) => {
            couponValidating.classList.add('hidden');
            if (result.responseJSON) {
                couponError.innerHTML = result.responseJSON.message;
                couponError.classList.remove('hidden');
            }
        });
};

const subscribe = (event) => {
    const form = event.target;
    event.preventDefault();
    disableSubmit(event);

    const errorMessage = document.querySelector('.alert-error');
    errorMessage.classList.add('hidden');

    // User already has a saved payment method — submit directly
    const cardID = document.querySelector('input[name="payment_id"]');
    if (cardID && cardID.value) {
        form.submit();
        return;
    }

    const periodInput = document.querySelector('input[name="period"]');
    const couponInput = document.getElementById('coupon');
    const returnUrl = new URL(document.getElementById('payment-element').dataset.returnUrl);
    if (periodInput) returnUrl.searchParams.set('period', periodInput.value);
    if (couponInput && couponInput.value) returnUrl.searchParams.set('coupon', couponInput.value);

    stripe.confirmSetup({
        elements,
        confirmParams: {
            return_url: returnUrl.toString(),
        },
        redirect: 'if_required',
    }).then((result) => {
        if (result.error) {
            formSubmitBtn.classList.remove('disabled', 'loading');
            formSubmitBtn.disabled = '';
            errorMessage.innerHTML = result.error.message;
            errorMessage.classList.remove('hidden');
            return;
        }

        if (result.setupIntent && result.setupIntent.payment_method) {
            cardID.value = result.setupIntent.payment_method;
            form.submit();
        }
    });
};

const initPeriodToggle = () => {
    const pricingOverview = document.getElementById('pricing-overview');
    const yearly = document.querySelector('[data-period="yearly"]');
    const monthly = document.querySelector('[data-period="monthly"]');

    const togglers = document.querySelectorAll('[data-period]');

    togglers?.forEach((toggler) => {
        toggler.addEventListener('click', function () {
            if (this.dataset.period === 'monthly') {
                yearly.classList.remove('bg-base-100');
                yearly.classList.add('text-neutral-content');
                monthly.classList.add('bg-base-100');
                monthly.classList.remove('text-neutral-content');
                pricingOverview.classList.remove('period-year');
                pricingOverview.classList.add('period-month');
            } else if (this.dataset.period === 'yearly') {
                monthly.classList.remove('bg-base-100');
                monthly.classList.add('text-neutral-content');
                yearly.classList.add('bg-base-100');
                yearly.classList.remove('text-neutral-content');
                pricingOverview.classList.remove('period-month');
                pricingOverview.classList.add('period-year');
            }
        });
    });
};


const disableSubmit = (event) => {
    const form = event.target;
    const submitBtn = form.querySelector('.subscription-confirm-button');
    submitBtn.classList.add('disabled', 'loading');
    submitBtn.disabled = true;
    return true;
};


// Send a gtag event when .price-monthly and .price-yearly buttons are clicked
const initAnalytics = () => {
    // Select all elements with .price-monthly and .price-yearly classes
    const monthlyButtons = document.querySelectorAll('.price-monthly');
    const yearlyButtons = document.querySelectorAll('.price-yearly');

    // Attach click event listener to each .price-monthly button
    monthlyButtons.forEach((button) => {
        button.addEventListener('click', () => {
            let item = {
                item_id: button.dataset.id,
                item_name: button.dataset.name,
                item_price: button.dataset.price
            };
            gtag('event', 'select_item', {
                items: [item]
            });
        });
    });

    // Attach click event listener to each .price-yearly button
    yearlyButtons.forEach((button) => {
        button.addEventListener('click', () => {
            let item = {
                item_id: button.dataset.id,
                item_name: button.dataset.name,
                item_price: button.dataset.price
            };
            gtag('event', 'select_item', {
                items: [item]
            });
        });
    });

}

init();
