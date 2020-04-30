// Strip variables for the page
var stripe, elements, card;

// Form status
var formSubmit = false;

$(document).ready(function() {
    initStripe();
    $('#subscribe-confirm').on('shown.bs.modal', () => {
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
        let button = $('.subscription-confirm-button');
        button.addClass('disabled').html('<i class="fa fa-spin fa-spinner"></i>');

        let intentToken = $('input[name="subscription-intent-token"]');
        let errorMessage = $('.alert-danger');
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
                button.removeClass('disabled').text(button.data('text'));
                errorMessage.text(result.error.message).show();
                return false;
            } else {
                cardID.val(result.setupIntent.payment_method);
                formSubmit = true;
                $('#subscription-confirm').submit();

            }
        }.bind(this));
    });

    $('.subscription-form').submit(function (e) {
        let button = $('.subscription-confirm-button');
        button.addClass('disabled').html('<i class="fa fa-spin fa-spinner"></i>');

        return true;
    });
}
