// Strip variables for the page
var stripe, elements, card;

// Form status
var formSubmit = false;
var formSubmitBtn;

// Coupon stuff
var couponField, couponSuccess, couponError, couponId, couponValidating;

var subscribeModal, pricingOverview;

$(document).ready(function() {
    initStripe();
    initPeriodToggle();
    subscribeModal = $('#subscribe-confirm');
    $(document).on('shown.bs.modal', () => {
        initConfirmListener();
    });
});

// Initialize the stripe API
function initStripe() {
    let token = $('#stripe-token');
    stripe = Stripe(token.val());

    // Create an instance of Elements.
    elements = stripe.elements();
}

// When the modal is opened and loaded, inject stripe if needed and the form validator
function initConfirmListener()
{
    formSubmitBtn = $('.subscription-confirm-button');

    let cardSelector = $('#card-element');
    if (cardSelector.length === 1) {
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

    $('#subscription-confirm').submit(function (e) {
        // If we've passed the strip validation, we can go further
        if (formSubmit) {
            return true;
        }

        e.preventDefault();
        formSubmitBtn.addClass('disabled').addClass('loading');
        formSubmitBtn.prop('disabled', 'disabled');

        let intentToken = $('input[name="subscription-intent-token"]');
        let errorMessage = $('.alert-error');
        errorMessage.hide();

        // If the form already has a payment id, we don't need stripe to add the new one
        let cardID = $('input[name="payment_id"]');
        if (cardID.val()) {
            formSubmit = true;
            $('#subscription-confirm').submit();
            return false;
        }

        stripe.confirmCardSetup(
            intentToken.val(), {
                payment_method: {
                    card: card,
                    billing_details: {
                        name: $('input[name="card-holder-name"]').val()
                    }
                }
            }
        ).then(function (result) {
            if (result.error) {
                formSubmitBtn.removeClass('disabled').removeClass('loading');
                formSubmitBtn.prop('disabled', '');
                errorMessage.text(result.error.message).show();
                return false;
            } else {
                cardID.val(result.setupIntent.payment_method);
                formSubmit = true;
                $('#subscription-confirm').submit();

            }
        }.bind(this));
    });

    $('.subscription-form').submit(function () {
        formSubmitBtn.addClass('disabled')
            .find('span').hide()
            .parent().find('.spinner').show();

        return true;
    });

    couponField = $('#coupon-check');
    couponSuccess = $('#coupon-success');
    couponError = $('#coupon-invalid');
    couponId = $('#coupon');
    couponValidating = $('#coupon-validating');

    couponField.change(function() {
        checkCoupon();
    });
    couponField.focusout(function () {
        checkCoupon();
    });
}

function checkCoupon() {
    let coupon = couponField.val();
    let url = couponField.data('url');

    if (!coupon) {
        formSubmitBtn.removeClass('disabled').prop('disabled', false);
    }
    couponValidating.removeClass('hidden');
    fetch(url + '&coupon=' + coupon)
        .then((response) => response.json())
        .then((result) => {
            formSubmitBtn.removeClass('disabled').prop('disabled', false);
            couponValidating.addClass('hidden');

            if (!result.valid) {
                couponSuccess.hide();
                couponError.html(result.error).show();
                couponId.val('');
                subscribeModal.removeClass('valid-coupon');

                return;
            }

            $('#pricing-now').html(result.price);
            couponError.hide();
            couponSuccess.html(result.discount).show();
            couponId.val(result.coupon);
            subscribeModal.addClass('valid-coupon');
        }).catch((result) => {
            couponValidating.addClass('hidden');
            if (result.responseJSON) {
                couponError.html(result.responseJSON.message).show();
            }
        });
}

function initPeriodToggle() {
    pricingOverview = $('#pricing-overview');
    $('input[name="period"]').change(function () {
        if (this.checked) {
            pricingOverview.removeClass('period-month').addClass('period-year');
        } else {
            pricingOverview.removeClass('period-year').addClass('period-month');
        }
    });

    if ($('input[name="period"]').is(':checked')) {
        pricingOverview.removeClass('period-month').addClass('period-year');
    }
}
