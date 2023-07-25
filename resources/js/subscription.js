// Strip variables for the page
var stripe, elements, card;

// Form status
var formSubmit = false;
var formSubmitBtn;

// Coupon stuff
var couponBtn, couponField, couponSuccess, couponError, couponId;

var subscribeModal;

$(document).ready(function() {
    initStripe();
    initPeriodToggle();
    subscribeModal = $('#subscribe-confirm');
    subscribeModal.on('shown.bs.modal', () => {
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

    couponBtn = $('#coupon-check-btn');
    couponField = $('#coupon-check');
    couponSuccess = $('#coupon-success');
    couponError = $('#coupon-invalid');
    couponId = $('#coupon');

    couponBtn.click(function () {
        checkCoupon();
    });
    couponField.change(function() {
        checkCoupon();
    });
    couponField.focus(function () {
        formSubmitBtn.addClass('disabled').prop('disabled', true);
    });
    couponField.focusout(function () {
        let coupon = couponField.val();
        if (!coupon) {
            formSubmitBtn.removeClass('disabled').prop('disabled', false);
        }
    });
}

function checkCoupon() {
    let coupon = couponField.val();
    let url = couponField.data('url');

    couponBtn.prop('disabled', true)
        .find('.check').hide()
        .parent().find('.spinner').show();

    if (!coupon) {
        formSubmitBtn.removeClass('disabled').prop('disabled', false);
    }

    $.ajax({
        url: url + '?coupon=' + coupon,
        context: this
    }).done(function (result) {
        couponBtn
            .prop('disabled', false)
            .find('.check').show()
            .parent().find('.spinner').hide();

        formSubmitBtn.removeClass('disabled').prop('disabled', false);

        if (!result.valid) {
            couponSuccess.hide();
            couponError.html(result.error).show();
            couponId.val('');
            subscribeModal.removeClass('valid-coupon');

            return;
        }

        couponError.hide();
        couponSuccess.html(result.discount).show();
        couponId.val(result.coupon);
        subscribeModal.addClass('valid-coupon');
    }).fail(function (result) {
        couponBtn
            .prop('disabled', false)
            .find('.check').show()
            .parent().find('.spinner').hide();

        if (result.responseJSON) {
            couponError.html(result.responseJSON.message).show();
        }
    });
}

function initPeriodToggle() {
    $('input[name="period"]').change(function () {
        let box = $('#pricing-overview');
        console.log('checked?', this.checked);
        if (this.checked) {
            box.removeClass('period-month').addClass('period-year');
        } else {
            box.removeClass('period-year').addClass('period-month');
        }
    });
    let selector = $('#currency-selector');

    if (selector.length === 0) {
        return false;
    }
    selector.change(function (e) {
        e.preventDefault();
        let selected = $(this).find(":selected").val();
        let box = $('#pricing-overview');

        if (selected == 'eur') {
            box.removeClass('currency-usd').addClass('currency-eur');
        } else if (selected == 'usd') {
            box.removeClass('currency-eur').addClass('currency-usd');
        }
    });
}
