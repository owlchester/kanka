<template>
    <div>

        <div v-show="paymentMethodsLoadStatus != 2" class="text-center">
            <i class="fa fa-spin fa-spinner"></i>
        </div>
        <div v-show="paymentMethodsLoadStatus == 2
    && paymentMethods.length > 0">
            <div v-for="(method, key) in paymentMethods"
                 v-bind:key="'method-'+key"
                 class="box box-solid"
            >
                <div class="box-body">
                    <div class="row">
                        <div class="col-xs-2">
                            {{ method.brand.charAt(0).toUpperCase() }}{{ method.brand.slice(1) }}
                        </div>
                        <div class="col-xs-7">
                            {{ translate('ending') }}: {{ method.last_four }} Exp: {{ method.exp_month }} / {{ method.exp_year }}
                        </div>
                        <div class="col-xs-3 text-right">
                            <span v-on:click.stop="removePaymentMethod( method.id )" title="Remove" class="text-red">
                                <i class="fa fa-trash"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-show="paymentMethodsLoadStatus == 2 && paymentMethods.length == 0">
            <p class="help-block">
                {{ translate('add_one') }}
                <a href="#" v-on:click.close="toggleShowNewPaymentMethod">
                    <i class="far fa-credit-card"></i> {{ translate('actions.add_new') }}
                </a>
            </p>
        </div>

        <div class="showNewCard" v-show="showNewPaymentMethod">
            <div class="modal" tabindex="-1" role="dialog" style="display: block">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" v-on:click="toggleShowNewPaymentMethod"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="clickModalLabel">
                                <h4 class="box-title">{{ translate('new_card') }}</h4>
                            </h4>
                        </div>
                        <div class="modal-body">
                            <label>{{ translate('card_name') }}</label>
                            <input id="card-holder-name" type="text" v-model="name" class="form-control mb-2">

                            <label>{{ translate('card') }}</label>
                            <div id="card-element">

                            </div>
                        </div>
                        <div class="box-footer">
                            <div class="pull-right">
                                <button class="btn btn-primary mt-3" id="add-card-button" v-on:click="submitPaymentMethod()" v-show="savePaymentMethodStatus == 0">
                                    {{ translate('actions.save') }}
                                </button>
                                <button class="btn btn-primary" v-show="savePaymentMethodStatus != 0" disabled="disabled">
                                    <i class="fa fa-spin fa-spinner"></i>
                                </button>
                            </div>


                            <p class="help-block">
                                {{ translate('helper') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: [
            'api_token',
            'trans'
        ],

        data(){
            return {
                stripe: '',
                elements: '',
                card: '',
                intentToken: '',

                name: '',
                addPaymentStatus: 0,
                addPaymentStatusError: '',

                paymentMethods: [],
                paymentMethodsLoadStatus: 0,
                paymentMethodSelected: 0,

                showNewPaymentMethod: false,
                savePaymentMethodStatus: 0,
                deletingPaymentMethodStatus: 0,
                json_trans: [],
            }
        },


        mounted(){
            this.includeStripe('js.stripe.com/v3/', function(){
                this.configureStripe();
            }.bind(this) );

            this.loadIntent();
            this.loadPaymentMethods();

            this.json_trans = JSON.parse(this.trans);
        },

        methods: {
            /*
                Includes Stripe.js dynamically
            */
            includeStripe(URL, callback) {
                let documentTag = document, tag = 'script',
                        object = documentTag.createElement(tag),
                        scriptTag = documentTag.getElementsByTagName(tag)[0];
                object.src = '//' + URL;
                if (callback) {
                    object.addEventListener('load', function (e) {
                        callback(null, e);
                    }, false);
                }
                scriptTag.parentNode.insertBefore(object, scriptTag);
            },

            /*
                Configures Stripe by setting up the elements and
                creating the card element.
            */
            configureStripe() {
                this.stripe = Stripe(this.api_token);

                this.elements = this.stripe.elements();
                this.card = this.elements.create('card', {
                    hidePostalCode: true
                });

                this.card.mount('#card-element');
            },

            /*
                Loads the payment intent key for the user to pay.
            */
            loadIntent() {
                axios.get('/subscription-api/setup-intent')
                        .then(function (response) {
                            this.intentToken = response.data;
                        }.bind(this));
            },

            submitPaymentMethod() {
                this.addPaymentStatus = 1;
                this.savePaymentMethodStatus = 1;

                this.stripe.confirmCardSetup(
                    this.intentToken.client_secret, {
                        payment_method: {
                            card: this.card,
                            billing_details: {
                                name: this.name
                            }
                        }
                    }
                ).then(function (result) {
                    this.savePaymentMethodStatus = 0;
                    if (result.error) {
                        this.addPaymentStatus = 3;
                        this.addPaymentStatusError = result.error.message;
                    } else {
                        this.savePaymentMethod(result.setupIntent.payment_method);
                        this.addPaymentStatus = 2;
                        this.card.clear();
                        this.name = '';
                        this.toggleShowNewPaymentMethod();
                    }
                }.bind(this));
            },

            /*  Saves the payment method for the user and re-loads the payment methods.*/
            savePaymentMethod(method) {
                this.paymentMethodsLoadStatus = 0;
                axios.post('/subscription-api/payments', {
                    payment_method: method
                }).then(function () {
                    this.loadPaymentMethods();
                }.bind(this));
            },

            /*
                Loads all of the payment methods for the
                user.
            */
            loadPaymentMethods() {
                this.paymentMethodsLoadStatus = 1;
                axios.get('/subscription-api/payment-methods')
                        .then(function (response) {
                            this.paymentMethods = response.data;
                            this.paymentMethodsLoadStatus = 2;
                        }.bind(this));
            },

            removePaymentMethod(paymentID) {
                this.paymentMethodsLoadStatus = 0;
                axios.post('/subscription-api/remove-payment', {
                    id: paymentID
                }).then(function (response) {
                    this.loadPaymentMethods();
                }.bind(this));
            },

            toggleShowNewPaymentMethod() {
                this.showNewPaymentMethod = !this.showNewPaymentMethod;
            },

            translate(key) {
                return this.json_trans[key] ?? 'unknown';
            }
        },
    }
</script>
