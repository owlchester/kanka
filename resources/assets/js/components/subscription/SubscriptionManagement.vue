<template>
    <div>
        <h4>
            {{ $t('settings.subscription.payment_method.select' )}}
        </h4>

        <div v-show="paymentMethodsLoadStatus != 2" class="text-center">
            <i class="fa fa-spin fa-spinner"></i>
        </div>
        <div v-show="paymentMethodsLoadStatus == 2
    && paymentMethods.length > 0">
            <div v-for="(method, key) in paymentMethods"
                 v-bind:key="'method-'+key"
                 v-on:click="paymentMethodSelected = method.id"
                 class="box box-solid box-hover"
                 v-bind:class="{
                'box-active box-green': paymentMethodSelected == method.id
            }">
                <div class="box-body">
                    <div class="row">
                        <div class="col-xs-2">
                            {{ method.brand.charAt(0).toUpperCase() }}{{ method.brand.slice(1) }}
                        </div>
                        <div class="col-xs-7">
                            {{ $t('settings.subscription.payment_method.ending' )}}: {{ method.last_four }} Exp: {{ method.exp_month }} / {{ method.exp_year }}
                        </div>
                        <div class="col-xs-3 text-right">
                            <span v-on:click.stop="removePaymentMethod( method.id )" title="Remove">
                                <i class="fa fa-trash"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-show="paymentMethodsLoadStatus == 2 && paymentMethods.length == 0">
            <p class="help-block">
                {{ $t('settings.subscription.payment_method.add_one' )}}
            </p>
        </div>
        <div class="text-right">
            <button class="btn btn-default" v-on:click.close="toggleShowNewPaymentMethod">
                <i class="far fa-credit-card"></i> {{ $t('settings.subscription.payment_method.actions.add_new' )}}
            </button>
        </div>

        <div class="showNewCard" v-show="showNewPaymentMethod">
            <div class="modal" tabindex="-1" role="dialog" style="display: block">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" v-on:click="toggleShowNewPaymentMethod"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="clickModalLabel">
                                <h4 class="box-title">{{ $t('settings.subscription.payment_method.new_card' )}}</h4>
                            </h4>
                        </div>
                        <div class="modal-body">
                            <label>{{ $t('settings.subscription.payment_method.card_name' )}}</label>
                            <input id="card-holder-name" type="text" v-model="name" class="form-control mb-2">

                            <label>{{ $t('settings.subscription.payment_method.card' )}}</label>
                            <div id="card-element">

                            </div>
                        </div>
                        <div class="box-footer text-right">
                            <button class="btn btn-primary mt-3" id="add-card-button" v-on:click="submitPaymentMethod()" v-show="savePaymentMethodStatus == 0">
                                {{ $t('settings.subscription.payment_method.actions.save' )}}
                            </button>
                            <button class="btn btn-primary" v-show="savePaymentMethodStatus != 0" disabled="disabled">
                                <i class="fa fa-spin fa-spinner"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div v-show="paymentMethodSelected">
            <h4 class="mt-3 mb-3">{{ $t('settings.subscription.subscription.select' )}}</h4>

            <div class="row" v-show="plansLoadStatus == 2">
                <div v-for="plan in plans" class="col-xs-4">
                    <div class="box box-solid box-hover" v-on:click="selectedPlan = plan.key" v-bind:class="{'box-active': selectedPlan == plan.key}">
                        <div class="box-widget widget-user widget-patreon" >
                            <div v-bind:class="planHeaderClass(plan)">
                                <h3 class="widget-user-username">{{ plan.name }}</h3>
                                <h5 class="widget-user-desc">${{ plan.price}}</h5>
                            </div>
                            <div class="widget-user-image">
                                <img class="img-circle" v-bind:src="plan.image" v-bind:alt="plan.name">
                            </div>
                            <div class="box-body">

                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div v-if="selectedPlan != 0">
                <button v-show="savingSubscriptionStatus == 0" class="btn btn-primary mt-3" id="add-card-button" v-on:click="updateSubscription()">
                    {{ $t('settings.subscription.subscription.actions.subscribe' )}}
                </button>
                <button v-show="savingSubscriptionStatus != 0" class="btn btn-primary" disabled="disabled">
                    <i class="fa fa-spin fa-spinner"></i> {{ $t('settings.subscription.subscription.actions.processing' )}}
                </button>
            </div>
            <div v-else>
                <button class="btn btn-default" disabled="disabled">
                    {{ $t('settings.subscription.subscription.actions.subscribe' )}}
                </button>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        props: [
            'api_token',
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

                plans: [],
                plansLoadStatus: 0,

                selectedPlan: '',

                savingSubscriptionStatus: 0,
                showNewPaymentMethod: false,
                savePaymentMethodStatus: 0,
                deletingPaymentMethodStatus: 0,
            }
        },


        mounted(){
            this.includeStripe('js.stripe.com/v3/', function(){
                this.configureStripe();
            }.bind(this) );

            this.loadIntent();
            this.loadPaymentMethods();
            this.loadPlans();
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

            /*
                Loads all of the plans.
            */
            loadPlans() {
                this.plansLoadStatus = 1;
                axios.get('/subscription-api/plans')
                        .then(function (response) {
                            this.plans = response.data;
                            this.plansLoadStatus = 2;
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

            updateSubscription() {
                this.savingSubscriptionStatus = 1;
                axios.put('/subscription-api/subscription', {
                    plan: this.selectedPlan,
                    payment: this.paymentMethodSelected
                }).then(function (response) {
                    this.savingSubscriptionStatus = 0;
                    alert('You Are Subscribed!');
                }.bind(this));
            },

            planHeaderClass(plan) {
                return 'widget-user-header bg-' + plan.colour + '-active';
            },

            toggleShowNewPaymentMethod() {
                this.showNewPaymentMethod = !this.showNewPaymentMethod;
            }
        },
    }
</script>
