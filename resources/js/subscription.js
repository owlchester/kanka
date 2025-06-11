// Strip variables for the page
let stripe, elements, card;

// Form status
let formSubmitBtn;

// Coupon stuff
let couponField, couponSuccess, couponError, couponId, couponValidating, paypalCoupon;

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
    stripe = Stripe(token.value);

    // Create an instance of Elements.
    elements = stripe.elements();
};

// When the modal is opened and loaded, inject stripe if needed and the form validator
const initConfirmListener = ()=> {
    formSubmitBtn = document.querySelector('.subscription-confirm-button');

    let cardSelector = document.getElementById('card-element');
    if (cardSelector) {
        // First time opening the modal, initiate a new card
        if (!card) {
            // Custom styling can be passed to options when creating an Element.
            // (Note that this demo uses a wider set of styles than the guide below.)
            let style = {
                base: {
                    color: '#555555',
                    fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                    fontSmoothing: 'antialiased',
                    fontSize: '14px',
                    '::placeholder': {
                        color: '#777777'
                    }
                },
                invalid: {
                    color: '#fa755a',
                    iconColor: '#fa755a'
                }
            };

            // Create an instance of the card Element.
            card = elements.create('card', {hidePostalCode: true, style: style});
        }

        // Add an instance of the card Element into the `card-element` <div>.
        card.mount('#card-element');
    }

    document.getElementById('subscription-confirm')?.addEventListener('submit', subscribe);


    couponField = document.getElementById('coupon-check');
    if (couponField) {
        couponSuccess = document.getElementById('coupon-success');
        couponError = document.getElementById('coupon-invalid');
        couponId = document.getElementById('coupon');
        couponValidating = document.getElementById('coupon-validating');
        paypalCoupon = document.querySelector('.paypal-coupon');
        couponField.addEventListener('change', checkCoupon);
        couponField.addEventListener('focusout', checkCoupon);
    }

    const selectMethod = document.querySelector('select[name="select-method"]');
    if (selectMethod) {
        selectMethod.addEventListener('change', changeMethod);
    }
};

const changeMethod = (event) => {
    //console.log('changing method to', event.target.value);
    const card = document.querySelector('#card-panel');
    const paypal = document.querySelector('#paypal-panel');
    if (event.target.value === 'paypal') {
        card.classList.add('hidden');
        paypal.classList.remove('hidden');
    } else {
        card.classList.remove('hidden');
        paypal.classList.add('hidden');
    }
}

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
                paypalCoupon.classList.add('hidden');
                return;
            }

            document.getElementById('pricing-now').innerHTML = result.price;
            couponError.classList.add('hidden');
            couponSuccess.innerHTML = result.discount;
            couponSuccess.classList.remove('hidden');
            couponId.value = result.coupon;
            subscribeModal.classList.add('valid-coupon');
            paypalCoupon.classList.remove('hidden');
        }).catch((result) => {
            couponValidating.classList.add('hidden');
            if (result.responseJSON) {
                couponError.innerHTML = result.responseJSON.message;
                couponError.classList.remove('hidden');
            }
            paypalCoupon.classList.add('hidden');
        });
};

const subscribe = (event) => {
    const form = event.target;
    event.preventDefault();
    disableSubmit(event);

    const intentToken = document.querySelector('input[name="subscription-intent-token"]');
    const errorMessage = document.querySelector('.alert-error');
    errorMessage.classList.add('hidden');

    // If the form already has a payment id, we don't need stripe to add the new one
    const cardID = document.querySelector('input[name="payment_id"]');
    if (cardID.value) {
        // Let the animation handler do its thing
        form.submit();
        return false;
    }

    stripe.confirmCardSetup(
        intentToken.value, {
            payment_method: {
                card: card,
                billing_details: {
                    name: document.querySelector('input[name="card-holder-name"]').value
                }
            }
        }
    ).then(function (result) {
        if (result.error) {
            formSubmitBtn.classList.remove('disabled', 'loading');
            formSubmitBtn.disabled = '';
            errorMessage.innerHTML = result.error.message;
            errorMessage.classList.remove('hidden');
            return false;
        } else {
            cardID.value = result.setupIntent.payment_method;
            // Let the animation handler do its thing
            form.submit();
        }
    }.bind(this));
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
